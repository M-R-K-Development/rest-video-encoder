app.factory('Videos', ['$resource', function($resource){
	return $resource(
		'/rve/api/1.0/videos/', 
		{}, 
		{ 
			'get':    {method:'GET', params: {}}
		}
	);
}])