(function(angular){
	app.controller('tokenController', function($scope, $log, TokenResource){
		TokenResource.getUserSites().then(function(items){
			$scope.sites = items;
		});
        $scope.forms = [];

		$scope.addElement = function(){
			var idnum = 'form' + ($scope.forms.length+1);
			$scope.forms.push({name: idnum, contacts:[{ userSite: '', url: '', description: '', elType:'' }]});
		}

		$scope.saveElement = function(form){
	      console.log(form.contacts);
	    }

		
	});
	
})(angular);