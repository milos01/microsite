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
					newParagraph: form.newParagraph,
					image: form.image
				}
				TokenResource.updateTokenElement(cont, form.id).then(function(items){});
				$scope.receves.push({type: cont.elType, price: 5});
				form.element_type = form.elType;
				form.url = form.url;
				form.myValue2 = false;
	      		form.myValue22 = false;
			}else{
				
				if(cont.update){
					TokenResource.updateTokenElement(cont, $scope.elemId).then(function(items){});
				}else{

					TokenResource.addTokenElement(cont).then(function(item){
						cont.update = true;
						$scope.elemId = item.id;
						var idk = item.id;
					});
				}
				$scope.receves.push({type: cont.elType, price: 5});
	      		cont.myValue = true;
	      		cont.mv = true;
			}
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
	    	Dropzone.forElement("#myDropzone").removeAllFiles(true);

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
	    $scope.init = function(cont)
		 {
		 	
		    $scope.dropzoneConfig = {
			    'options': {
			      'url': '/api/upload',
			      'addRemoveLinks': true,
			      'maxFiles': 1,
			    },
			    
			    
			    'eventHandlers': {
			      'sending': function (file, xhr, formData) {
			      		formData.append("_token", $('meta[name="csrf-token"]').attr('content')); 
			      },
			      'success': function (file, response) {

			      	if(response.file){
			      		file.previewElement.classList.add("dz-error");
			      		_ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
			      		_results = [];
			      		
			      		for (_i = 0, _len = response.file.length; _i < _len; _i++) {
					      node = _ref[_i];
					      _results.push(node.textContent = response.file[0]);
					    }
			      		
			      		return _results;
			      	}
			      	cont.image = response;
			      }
			    }
			  }
		 };
		
	});

	app.controller('dropzoneController', function($scope){


	})

	 
	


	
})(angular);