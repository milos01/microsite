(function (angular) {
app.controller('braintreeController', function($scope, $http){
    $http({
        method: 'GET',
        url: '/api/generateToken',
        data: {}
    }).then(function successCallback(res) {
        braintree.setup(res.data.token, 'dropin', {
          container: 'dropin-container'
        });
    });
});
})(angular);