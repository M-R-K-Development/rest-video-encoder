<?php /**
 * 
 */
namespace Rve\Services;

/**
 *  Deals with User Token Controllers
 */
class UserToken {


    /**
       * Checks the token and authenticates the users if present.
       *
       * @param [type] $token [description]
       *
       * @return [type] [description]
       */
      public static function checkAndAuthToken($request) {

        $authenticated = false;
        $authInfo = [
          'token' => $request->header('X-Auth-Token'),
          'app_id' => $request->header('X-App-ID'),
        ];

        if ($authInfo['token']) {
            if ($authInfo['app_id']) {
              $userToken = \Rve\Models\UserToken::where('token', '=', $authInfo['token'])
                                                ->where('application_id', '=', $authInfo['app_id'])
                                                ->first();  
            } else {
              $userToken = \Rve\Models\UserToken::where('token', '=', $authInfo['token'])
                                                ->first();
            }

            if (!$userToken) {
                return false;
            }

            $date = new \DateTime($userToken->updated_at);
            $timestamp = $date->format('U');
            $delay = time() - $timestamp;
            $timeInMinutes = $delay/60;

            $expires = \Config::get('rve.expires');
            if ($expires && $timeInMinutes < $expires) {
              $user = \Rve\User::find($userToken->user_id);

              if ($user) {
                  if (\Auth::loginUsingId($user->id)) {
                    self::refreshToken($user);
                    $authenticated = true;
                  } 
              }
            }
          }
        return $authenticated;
      }


    /**
     * getToken
     *
     * Will create a new token or refresh the existing one on a successfull
     * authentication
     * @return String the generated token
     */
    public static function getToken()
    {
        $inputToken = \Request::header('X-Auth-Token');
        if ($inputToken == '') {
          $inputToken = \Session::get('token_input');
        }

        $applicationId = \Request::header('X-App-ID');
        if ($applicationId == '') {
          $applicationId = \Session::get('token_app_id');
        }

        if ($applicationId == null) {
            $applicationId = '';
        }

        $token = '';

        if (\Auth::check()) {
            $user = \Auth::user();
            $userToken = \Rve\Models\UserToken::where('user_id', $user->id)
                            ->where('application_id', $applicationId)
                            ->first();

            if (!$userToken) {
                $userToken = new \Rve\Models\UserToken;
                $userToken->user_id = $user->id;
                $userToken->application_id = $applicationId;
                $userToken->token = hash('sha256', str_random(10), false);
            }

            $token = $userToken->token;
            $userToken->updated_at = time();
            $userToken->save();
        } else {

            $userToken = \Rve\Models\UserToken::where('token', $inputToken)
                ->where('application_id', $applicationId)
                ->first();

            if ($userToken) {
                $user_id   = $userToken->user_id;
                $user      = Sentry::findUserById($user_id);
                Sentry::login($user);
                $token = $userToken->token = hash('sha256', str_random(10), false);
                $userToken->save();
            }
        }

        // Session::put('token', $token);
        return $token;
    }

    /**
     * Refreshing
     * @return [type]
     */
    public static function refreshToken($user) {

      $userToken = \Rve\Models\UserToken::where('user_id', $user->id)
                                        ->first();
      if ($userToken) {
        $userToken->updated_at = \Carbon\Carbon::now();
        $userToken->save();
      }                

      return $userToken;
    }

    public static function generateNewToken(\Rve\User $user, $applicationId = null)
    {
        $token = hash('sha256', str_random(10), false);

        $userToken = \Rve\Models\UserToken::firstOrNew(['user_id' => $user->id, 'application_id' => $applicationId]);

        $userToken->user_id = $user->id;
        $userToken->application_id = $applicationId;
        $userToken->token = $token;
        $userToken->save();

        return $token;
    }

    
    /**
     * Checks the token and authenticates the users if present.
     *
     * @param [type] $token [description]
     *
     * @return [type] [description]
     */
    public function check($token)
    {
        $userToken = UserToken::where('token', '=', $token)->first();

        if (!$userToken) {
            return false;
        }

        $date = new DateTime($userToken->updated_at);
        $timestamp = $date->format('U');
        $delay = time() - $timestamp;
        $timeInMinutes = $delay/60;

        $expires = Session::get('token_expires');
        if ($expires && $timeInMinutes < $expires) {
          $user = Sentry::findUserById($userToken->user_id);

          if ($user) {
              return true;
          }
        }

        return false;
    }
}
