(function(angular){
	app.controller('tokenController', function($scope, $log, TokenResource){
		TokenResource.getUserSites().then(function(items){
			$scope.sites = items;
		});
        $scope.forms = [];
        $scope.receves = [];

        $scope.getTotal = function(){
			var total = 0;
			for(var i = 0; i < $scope.receves.length; i++){
			        var receve = $scope.receves[i];
			        total += receve.price;
			}
			return '$' + total;
		}

		$scope.addElement = function(){
			var idnum = 'form' + ($scope.forms.length+1);
			$scope.forms.push({name: idnum, contacts:[{ userSite: '', url: '', description: '', elType:'' }]});
		}

		$scope.saveElement = function(form, cont){
	      $scope.receves.push({type: cont.elType, price: 5});
	      cont.myValue = true;
	    }

	    $scope.removeElement = function(idx){
	      $scope.forms.splice(idx, 1);
	      $scope.receves.splice(idx, 1);
	    }

	    $scope.showExtraFields = function(field, form){
	    	form.currentHeadline = '';
	    	form.newHeadline = '';
	    	form.currentParagraph = '';
	    	form.newParagraph = '';

	    	form.showHeadline = false;
	    	form.showParagraph = false;
	    	form.showImage = false;
	    	
	    	if (field === "Headline") {
	    		form.showHeadline = true;
	    	}else if(field === "Paragraph"){
	    		form.showParagraph = true;
	    	}else{
	    		form.showImage = true;
	    	}
	    }

		
	});
	
})(angular);