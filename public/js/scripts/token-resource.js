(function(angular){
	
	app.factory('TokenResource',function(Restangular){
		
		var retVal = {};
		
		retVal.getUserSites = function(){
			return Restangular.one('user').all('websites').getList().then(function(item){
				return item;
			});
		}

		retVal.getSavedElements = function(){
			return Restangular.all('saved_elements').getList().then(function(items){
				return items;
			});
		}

		retVal.addTokenElement = function(element){
			return Restangular.all('content_element').post(element).then(function(item){
				return item;
			});
		}

		retVal.updateTokenElement = function(element, id){
			return Restangular.one('saved_elements', id).put(element).then(function(item){
				return item;
			});
		}

		retVal.addTokenOrder = function(order){
			return Restangular.all('content_oreder').post(order).then(function(item){
				return item;
			});
		}

		retVal.removeTokenElement = function(id){
			console.log(id);
			return Restangular.one('saved_elements', id).remove().then(function(item){
				return item;
			});
		}

		return retVal;
	})
	
})(angular);