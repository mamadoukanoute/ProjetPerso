'use strict'
angular.module('clientApp').controller('usersNewCtrl', [
	'$scope',
	'User',
	'user',
	'$stateParams',
	function(
		$scope,
		User,
		user,
		$stateParams
		){
		var method = 'save';
        if($stateParams.id === null  || $stateParams.id === undefined ) {
            $scope.user = {}
        } else {
            method = 'update';
            $scope.user = user;
        }

        $scope.saveUser = function () {
        	console.log(method);
        	User[method]($scope.user, function(success){
                console.log(success);
                // $state.go("users.list", {}, {reload: true});
            },function(error){
            	console.log(error);
        });



	}
}
]);