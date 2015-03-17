app.controller('VideoListCtrl', function VideoListCtrl($scope, Videos, $window, $routeParams){
	var init = function() {
		
		Videos.get({}, function(response) {
			$scope.videos = response.data;
		});

	}();
}).controller('VideoCtrl', function VideoCtrl($scope, Videos, $window, $routeParams){
	var init = function() {
		Videos.get({}, function(response) {
			console.log(response.data);
		});
	}();
});