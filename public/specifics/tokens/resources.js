app.factory('Tokens', ['$resource', function($resource){
	return $resource(
		'/rve/api/1.0/tokens/:id', 
		{id : '@id'}, 
		{ 
			'get':    {method:'GET', params: {}},
			'post':    {method:'POST', params: {}},
			'destroy':    {method:'DELETE', params: {}}
		}
	);
}])