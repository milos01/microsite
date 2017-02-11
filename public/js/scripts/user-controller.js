(function (angular) {
app.controller('profileController', function($scope, $uibModal, $log){
	$scope.openReportModal = function(editType) {
			$scope.edType = editType;
        	var modalInstance = $uibModal.open({
        	   templateUrl: '/template/showEditTemplate',
        	   controller: 'editUserCtrl',
        	   scope: $scope
        	});
        
        	modalInstance.result.then(function(value) {
        	    $log.info('Modal finished its job at: ' + new Date() + ' with value: ' + value);
        		}, function(value) {
        	    $log.info('Modal dismissed at: ' + new Date() + ' with value: ' + value);
        	    });
    };
});

app.controller('editUserCtrl', function($scope, $window, $uibModalInstance, UserResource){
	$scope.submitForm = function(editType){
		userEditInfo = {
			firstName: $scope.firstName,
			lastName: $scope.lastName,
			editType: editType,
			email: $scope.email,
			phone: $scope.phone,
			oldPassword: $scope.oldPassword,
			password: $scope.password
		};
		UserResource.updateUser(userEditInfo).then(function(item){
			if(item.data){
				$scope.error = item.data;
			}else{
				$window.location.reload();
			}
		});
		
	}
	
	$scope.cancel = function() {
		$uibModalInstance.dismiss('cancel');
	};
});
})(angular);