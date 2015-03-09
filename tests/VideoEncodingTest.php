<?php

class VideoEncodingTest extends TestCase {


	/**
	 * Tests the video API and the return type
	 * @test
	 * @covers \App\Http\Controllers\RveController::index
	 * @return void
	 */
	public function videoApiIndexReturnJson() {
		//$response = $this->call('GET', '/rve/');

		$service = App::make('\Rve\Http\Controllers\RveApi');
		$response = $service->index();
		$content = $response->getContent();
		$json = json_decode($content);
		assertTrue(isset($json), 'The return type is not a JSON object');
	}

	/**
	 * Service is not accessible without token
	 * @test
	 * @covers Rve\Http\Middleware::handle
	 * @return void
	 */
	public function apiIsAccessibleWithTokenOnly() {
		

		$response = $this->call('GET', '/rve/');
		assertFalse($response->isOk());

		$user = \Rve\User::create(['name' => str_random(10), 'email' => str_random(5).'.@gmail.com', 'password' => str_random(10)]);
		$userToken = \Rve\Services\UserToken::generateNewToken($user);
		$response = $this->call('GET', '/rve/', [], [], [], ['X-Auth-Token' => $userToken]);
		
		assertFalse($response->isOk());


	}

}
