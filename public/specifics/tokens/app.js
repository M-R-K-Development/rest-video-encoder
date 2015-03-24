var app = angular.module('videosApp', ['ngRoute', 'ngResource', 'ui.bootstrap'], 
	function ($interpolateProvider) {
	    $interpolateProvider.startSymbol('[[');
	    $interpolateProvider.endSymbol(']]');
	});

app.config(['$routeProvider', function($routeProvider) {
  $routeProvider
   .when('/list', {
    templateUrl: '/specifics/tokens/templates/list.html',
    controller: 'TokenListCtrl'
  })
   .when('/add', {
    templateUrl: '/specifics/tokens/templates/add.html',
    controller: 'TokenCtrl'
  })
  .otherwise({
	 redirectTo: '/list'
   });

  // configure html5 to get links working on jsfiddle
  // $locationProvider.html5Mode(true);
}]);