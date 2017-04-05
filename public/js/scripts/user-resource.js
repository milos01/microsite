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

		retVal.newUser = function(userInfo){
			return Restangular.all('addnewuser').post(userInfo).then(function(item){
				return item;
			}, function(errors){
				return errors;
			});
		}
		
		retVal.loadInvoices = function(){
			return Restangular.one('user').all('invoices').getList().then(function(items){
				return items;
			});
		}


		return retVal;
	})
	
})(angular);