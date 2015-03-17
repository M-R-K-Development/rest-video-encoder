var app = angular.module('videosApp', ['ngRoute', 'ngResource', 'ui.bootstrap'], 
	function ($interpolateProvider) {
	    $interpolateProvider.startSymbol('[[');
	    $interpolateProvider.endSymbol(']]');
	});

app.config(['$routeProvider', function($routeProvider) {
  $routeProvider
   .when('/list', {
    templateUrl: '/specifics/videos/templates/list.html',
    controller: 'VideoListCtrl'
  })
   .when('/add', {
    templateUrl: '/specifics/videos/templates/add.html',
    controller: 'VideoCtrl'
  })
  .otherwise({
	 redirectTo: '/list'
   });

  // configure html5 to get links working on jsfiddle
  // $locationProvider.html5Mode(true);
}]);