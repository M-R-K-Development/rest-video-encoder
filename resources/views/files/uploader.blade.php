@extends('app')
@section('header')
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
  <style type="text/css">
    .container {
      width:1170px;
      margin:0 auto;
    }
  </style>
@endsection
@section('content')
  <section class="container" ng-app="app">
    <div class="header">
      <h1>Video upload</h1>
      <p>Drop your video here and let's get started!</p>
    </div>

    <div flow-init="{query:{videoId: 1}, target: '{{URL::to('/rve/api')}}/{{Config::get('rve.api-version')}}/files', headers: {'X-Auth-Token':'{{$token}}'}, testChunks: false}"
         flow-files-submitted="$flow.upload()"
         flow-file-success="$file.msg = $message">
      <div class="drop">
        <span class="btn btn-default accept-videos" flow-btn>Upload File</span>
      </div>

      <br/>

      <div class="well" ng-show="files">
        <a class="btn btn-small btn-success" ng-click="$flow.resume()">Resume all</a>
        <a class="btn btn-small btn-danger" ng-click="$flow.pause()">Pause all</a>
        <a class="btn btn-small btn-info" ng-click="$flow.cancel()">Cancel all</a>
        <span class="label label-info">Total Size: [[$flow.getSize()]]bytes</span>
      </div>

      <div>

        <div ng-repeat="file in $flow.files" class="transfer-box">
          [[file.relativePath]] ([[file.size]]bytes)
          <div class="progress progress-striped" ng-class="{active: file.isUploading()}">
            <div class="progress-bar" role="progressbar"
            aria-valuenow="[[file.progress() * 100]]"
            aria-valuemin="0"
            aria-valuemax="100"
            ng-style="{width: (file.progress() * 100) + '%'}">
            <span class="sr-only">[[file.progress()]]% Complete</span>
          </div>
        </div>
        <div class="btn-group">
          <a class="btn btn-xs btn-warning" ng-click="file.pause()" ng-show="!file.paused && file.isUploading()">Pause</a>
          <a class="btn btn-xs btn-warning" ng-click="file.resume()" ng-show="file.paused">Resume
          </a>
          <a class="btn btn-xs btn-danger" ng-click="file.cancel()">
            Cancel
          </a>
          <a class="btn btn-xs btn-info" ng-click="file.retry()" ng-show="file.error">
            Retry
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('script')
  <script type="text/javascript" src="/ng-vendors/angular-1.3.14/angular.min.js"></script>
  <script type="text/javascript" src="/ng-vendors/ng-flow/ng-flow-standalone.min.js"></script>
  <script type="text/javascript" src="/specifics/files/app.js"></script>

  <script>
    $(document).ready(function(){
      $('.accept-videos').children('input').attr('accept', 'video/mp4,video/mpeg,video/quicktime');
    });
  </script>
@endsection
