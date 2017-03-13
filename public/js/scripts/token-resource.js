(function(angular){
	
	app.factory('TokenResource',function(Restangular){
		
		var retVal = {};
		
		retVal.getUserSites = function(){
			return Restangular.one('user').all('websites').getList().then(function(item){
				return item;
			});
		}
		return retVal;
	})
	
})(angular);