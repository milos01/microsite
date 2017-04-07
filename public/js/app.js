(function (angular) {
angular.module('dropzone', []).directive('dropzone', function () {
  return function (scope, element, attrs) {
    var config, dropzone;

    config = scope[attrs.dropzone];

    // create a Dropzone for the element with the given options
    dropzone = new Dropzone(element[0], config.options);

    // bind the given event handlers
    angular.forEach(config.eventHandlers, function (handler, event) {
      dropzone.on(event, handler);
    });
  };
});

app = angular.module('micrositeApp', ['restangular', 'ui.bootstrap', 'ui.select2', 'dropzone'])
.run(function(Restangular, $log) {
		var headers = {
			'Content-Type' : 'Application/json',
			'Accept' : 'application/x.laravel.v1+json'
		};
        Restangular.setDefaultHeaders(headers);
        Restangular.setBaseUrl("api");
        Restangular.setErrorInterceptor(function(response) {
            if (response.status === 500) {
                $log.info("internal server error");
                return true;
            }
            return true; // greska nije obradjena
        });
});
})(angular);