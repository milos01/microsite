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

		return retVal;
	})
	
})(angular);