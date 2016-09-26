'use strict'
angular.module('clientApp').controller('usersCtrl', [
	'$scope',
	'constants',
	function(
		$scope,
		constants
		){
		$scope.test = "test";
		$scope.api_url= constants.api_url;




	}
]);