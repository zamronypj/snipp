
'use strict';

/**
 * class that encapsulate get request
 * using jquery ajax request
 * This is part of snippet application https://github.com/zamronypj/snipp
 * @author Zamrony P. Juhara <zamronypj@yahoo.com>
 */

var ApiService = (function () {

    /**
     * URL to get request from
     * @var string
     */
    var apiEndpointUrl;

    var dataAvailableCallback;
    var errorCallback;

    /**
     * hold data retrieve from API
     * @var object
     */
    var dataFromApi = {};

    var handleSuccessRequestCallback = function (data, status) {
        if (typeof dataAvailableCallback === 'function') {
            dataAvailableCallback(data);
        }
    };

    var handleFailedRequestCallback = function (data, status) {
        if (typeof errorCallback === 'function') {
            errorCallback(data, status);
        }
    };

    function ApiServiceClass(endpointUrl) {
        apiEndpointUrl = endpointUrl;
    };

    ApiServiceClass.prototype.getDataFromBackend = function (params) {
        return $.get(apiEndpointUrl + '?' + $.param(params))
                .done(handleSuccessRequestCallback)
                .fail(handleFailedRequestCallback);
    };

    ApiServiceClass.prototype.getData = function () {
        return dataFromApi;
    };

    ApiServiceClass.prototype.onDataAvailable = function (callback) {
        dataAvailableCallback = callback;
    };

    ApiServiceClass.prototype.onError = function (callback) {
        errorCallback = callback;
    };

    return ApiServiceClass;
}());
