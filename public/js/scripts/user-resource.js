(function(angular){
	
	app.factory('UserResource',function(Restangular){
		
		var retVal = {};
		
		retVal.updateUser = function(editInfo){
			return Restangular.one('update').put(editInfo).then(function(item){
				return item;
			});
		}

		return retVal;
	})
	
})(angular);