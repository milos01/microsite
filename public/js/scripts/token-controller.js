(function(angular){
	app.controller('tokenController', function($scope, $log, TokenResource){
		TokenResource.getUserSites().then(function(items){
			$scope.sites = items;
		});
		TokenResource.getSavedElements().then(function(items){
			$scope.oldForms = items;
			for (var i = 0; i <  items.length; i++) {
				$scope.receves.push({type: items[i].element_type, price: 5});
			}
		});
        $scope.forms = [];
        $scope.receves = [];
       	$scope.tat = "whenever";

        $scope.getTotal = function(){
			var total = 0;
			for(var i = 0; i < $scope.receves.length; i++){
			        var receve = $scope.receves[i];
			        total += receve.price;
			}
			$scope.total = total;
			return '$' + total;
		}

		$scope.addElement = function(){
			var idnum = 'form' + ($scope.forms.length+1);
			$scope.forms.push({name: idnum, contacts:[{ userSite: '', url: '', description: '', elType:'' }]});
		}

		$scope.saveElement = function(form, cont){
			if(!cont){
				var cont = {
					userSite: form.userSite,
					url: form.url,
					description: form.description,
					elType: form.elType,
					currentHeadline: form.currentHeadline,
					newHeadline: form.newHeadline,
					currentParagraph: form.currentParagraph,
					newParagraph: form.newParagraph
				}
				TokenResource.updateTokenElement(cont, form.id).then(function(items){});
				$scope.receves.push({type: cont.elType, price: 5});
				form.element_type = form.elType;
				form.url = form.url;
				form.myValue2 = false;
	      		form.myValue22 = false;
			}else{
				TokenResource.addTokenElement(cont).then(function(item){
					$scope.elemId = item.id;
				});
				$scope.receves.push({type: cont.elType, price: 5});
	      		cont.myValue = true;
			}
			console.log(cont);
			
	      	

	    }

	    $scope.removeElement = function(idx, cont){
	      $scope.forms.splice(idx, 1);
	      $scope.receves.splice(idx, 1);
	      removeElem($scope.elemId);
	    }

	    $scope.removeOldElement = function(idx, dbId){
	      $scope.oldForms.splice(idx, 1);
	      $scope.receves.splice(idx, 1);
	      removeElem(dbId);
	    }

	    function removeElem(id){
	    	return TokenResource.removeTokenElement(id).then(function(items){});
	    }

	    $scope.updateElement = function(idx, cont){
	    	cont.myValue = false;
	    	cont.myValue2 = true;
	    	cont.myValue22 = true;
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

	    $scope.elementsCheckout = function(){
	    	orderInfo = {
				tat: $scope.tat,
				totalPrice: $scope.total,
			};
			TokenResource.addTokenOrder(orderInfo).then(function(items){
				//redirect to payment page
			});
	    	
	    }

		
	});
	
})(angular);