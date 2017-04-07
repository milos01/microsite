(function (angular) {
app.controller('braintreeController', function($scope, $http){
      $http({
        method: 'GET',
        url: '/api/generateToken',
        data: {}
    }).then(function successCallback(res) {
        braintree.setup(res.data.token, 'dropin', {
          container: 'dropin-container',
          onReady: function(){
            $("#paymentPart1").show();
            $("#paymentPart2").show();
            $("#paymentPart3").show();
          }
        });

    });

    $scope.clickPayButt = function(){
      $scope.showSpin = true;
    }

});

app.controller('subscriptionController', function($scope, WebsiteResource, UserResource, $window){
    UserResource.getLogedUser().then(function(item){
       if (item.subscribed == 0) {
          $scope.oneTimer = true;
        }else{
          $scope.oneTimer = false;
        }
    });
    $scope.$watch('subscribed', function(value) {
        if (value == "no") {
          $scope.oneTimer = true;
        }else{
          $scope.oneTimer = false;
        }
        if (value != undefined) {
            sVal = {
              val: value
            }

            WebsiteResource.changeMode(sVal).then(function(){
                $window.location.reload();
            })
        }
    });
});
})(angular);