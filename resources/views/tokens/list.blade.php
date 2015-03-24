@extends('app')

@section('content')
<div class="container" ng-app="videosApp">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Your Tokens</div>
				
				<div class="panel-body">
					<div ng-view></div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection

@section('script')
	<script>
		var API_KEY = '{{\Rve\Services\UserToken::getToken()}}';
	</script>

	<script type="text/javascript" src="/ng-vendors/angular-1.3.14/angular.min.js"></script>
	<script src="/ng-vendors/angular-1.3.14/angular-resource.min.js"></script>
	<script src="/ng-vendors/angular-1.3.14/angular-route.min.js"></script>
	<script type="text/javascript" src="/ng-vendors/ng-bootstrap/ng-bootstrap-0.12.1.min.js"></script>
	<script type="text/javascript" src="/specifics/tokens/app.js"></script>
	<script type="text/javascript" src="/specifics/http-interceptors.js"></script>
	<script type="text/javascript" src="/specifics/tokens/controller.js"></script>
	<script type="text/javascript" src="/specifics/tokens/resources.js"></script>
@endsection
