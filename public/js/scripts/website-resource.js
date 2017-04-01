(function(angular){
	
	app.factory('WebsiteResource',function(Restangular){
		
		var retVal = {};
		
		retVal.newWebsite = function(websiteInfo){
			return Restangular.all('website').post(websiteInfo).then(function(item){
				return item;
			}, function(errors){
				return errors;
			});
		}

		retVal.changeMode = function(answ){
			return Restangular.one('user').one('mode').put(answ).then(function(item){
				return item;
			});
		}

		return retVal;
	})
	
})(angular);