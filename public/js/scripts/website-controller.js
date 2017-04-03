(function (angular) {
app.controller('websiteController', function(WebsiteResource, $scope, $uibModal, $log, $window){
	$scope.submitForm = function(themeID){
		newWebiste = {
			companyName: $scope.companyName,
			websiteTitle: $scope.websiteTitle,
			domain: $scope.domain,
			theme_id: themeID,
		};

		WebsiteResource.newWebsite(newWebiste).then(function(item){
			if(item.data){
				$scope.error = item.data;
			}else{
				$window.location.assign('/billing');
			}
		});
		
	}

	$scope.emptyErrorArray = function(){
		$scope.error = [];
	}
});
})(angular);