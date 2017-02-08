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

app.controller('editUserCtrl', function($scope, $uibModalInstance, UserResource){
	$scope.submitForm = function(editType){
		userEditInfo = {
			editType: editType,
			email: $scope.email,
			phone: $scope.phone,
			oldPassword: $scope.oldPassword,
			password: $scope.password
		};
		UserResource.updateUser(userEditInfo).then(function(item){
			$scope.error = item.data;
		});
		
	}
	
	$scope.cancel = function() {
		$uibModalInstance.dismiss('cancel');
	};
});
})(angular);