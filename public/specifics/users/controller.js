app.controller('UserListCtrl', function UserListCtrl($scope, $route, Users, $window, $routeParams){
	var init = function() {
		
		Users.get({}, function(response) {
			$scope.users = response.data;
		});

	}();

	$scope.destroyUser = function(user) {
		Users.destroy({id : user.id}, function() {
			$route.reload();
		}, function() {
			alert('Something went wrong..')
		});
	}
}).controller('UserCtrl', function UserCtrl($scope, $location, Users, $window, $routeParams){
	

	/**
	 * Create a user and display it in the browser
	 */
	$scope.createUser = function() {
		Users.post($scope.user, function(response) {
			$location.path('/');
		}, function() {
			alert('Something went wrong..')
		});
	}

	
});