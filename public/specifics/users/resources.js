app.factory('Users', ['$resource', function($resource){
	return $resource(
		'/rve/api/1.0/users/:id', 
		{id : '@id'}, 
		{ 
			'get':    {method:'GET', params: {}},
			'post':    {method:'POST', params: {}},
			'destroy':    {method:'DELETE', params: {}}
		}
	);
}])