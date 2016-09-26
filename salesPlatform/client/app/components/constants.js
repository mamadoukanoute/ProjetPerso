angular.module('clientApp').factory('constants', ['$rootScope', '$location', '$timeout',
    function ($rootScope, $location, $timeout) {
    	this.api_url = location.protocol + '//' + 'localhost:8000' + '/app_dev.php/api/';
    	return {
    		api_url: this.api_url
    	}
    }
]);