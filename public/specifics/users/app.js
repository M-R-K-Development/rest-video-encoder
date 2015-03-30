var app = angular.module('videosApp', ['ngRoute', 'ngResource', 'ui.bootstrap'], 
	function ($interpolateProvider) {
	    $interpolateProvider.startSymbol('[[');
	    $interpolateProvider.endSymbol(']]');
	});

app.config(['$routeProvider', function($routeProvider) {
  $routeProvider
   .when('/list', {
    templateUrl: '/specifics/users/templates/list.html',
    controller: 'UserListCtrl'
  })
   .when('/add', {
    templateUrl: '/specifics/users/templates/add.html',
    controller: 'UserCtrl'
  })
  .otherwise({
	 redirectTo: '/list'
   });

  // configure html5 to get links working on jsfiddle
  // $locationProvider.html5Mode(true);
}]);