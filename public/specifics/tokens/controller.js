app.controller('TokenListCtrl', function TokenListCtrl($scope, $route, Tokens, $window, $routeParams){
	var init = function() {
		
		Tokens.get({}, function(response) {
			$scope.tokens = response.data;
		});

	}();

	$scope.destroyToken = function(token) {
		Tokens.destroy({id : token.id}, function() {
			$route.reload();
		}, function() {
			alert('Something went wrong..')
		});
	}
}).controller('TokenCtrl', function TokenCtrl($scope, $location, Tokens, $window, $routeParams){
	

	/**
	 * Create a token and display it in the browser
	 */
	$scope.createToken = function() {
		Tokens.post($scope.token, function(response) {
			$location.path('/');
		}, function() {
			alert('Something went wrong..')
		});
	}

	
});