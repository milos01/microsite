(function (angular) {
app.controller('profileController', function($scope, $uibModal, $log, $window,UserResource){
	$scope.showEdit = false;
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

    $scope.showEditField = function($fullName){
    	$scope.firstName = $fullName.first_name;
    	$scope.lastName = $fullName.last_name;
    	$scope.showEdit = true;
    	$('#hideOriginalName').hide();
    }

    $scope.submitForm = function(editType){
		userEditInfo = {
			firstName: $scope.firstName,
			lastName: $scope.lastName,
			editType: editType
		};
		UserResource.updateUser(userEditInfo).then(function(item){
			if(item.data){
				$scope.error = item.data;
			}else{
				$window.location.reload();
			}
		});
		
	}
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

app.controller('newUserController', function($scope, $window, UserResource){
	$scope.submitNewUserForm = function(){
		userInfo = {
			firstName: $scope.f_name,
			lastName: $scope.l_name,
			email: $scope.email,
			role: $scope.role,

		};
		UserResource.newUser(userInfo).then(function(item){
			if(item.data){
					$scope.error = item.data;
			}else{
					$window.location.reload();
			}
		});
	}

	$scope.emptyErrorArray = function(){
		$scope.error = [];
	}
	
});

app.controller('invoiceController', function($scope, UserResource){
	$scope.showLoadInvoices = true;
	UserResource.loadInvoices().then(function(items){
		for (var i = items.length - 1; i >= 0; i--) {
			if(items[i][1] == 'submitted_for_settlement'){
				items[i][1] = 'Pending...';
			}else if(items[i][1] == 'settled'){
				items[i][1] = 'Paid';
			}else if(items[i][1] == 'gateway_rejected'){
				items[i][1] = 'Rejected';
			}
		}
		
		$scope.invoices = items;
		$scope.showLoadInvoices = false;
	})
});
})(angular);