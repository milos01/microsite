(function(angular){
	
	app.factory('UserResource',function(Restangular){
		
		var retVal = {};
		
		retVal.updateUser = function(editInfo){
			return Restangular.one('update').put(editInfo).then(function(item){
				return item;
			}, function(errors){
				return errors;
			});
		}

		retVal.getLogedUser = function(editInfo){
			return Restangular.one('user').get().then(function(item){
				return item;
			});
		}

		return retVal;
	})
	
})(angular);