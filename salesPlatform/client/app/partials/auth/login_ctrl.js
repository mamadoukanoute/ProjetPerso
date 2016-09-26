'use strict'
angular.module('clientApp').controller('loginCtrl', [
	'$rootScope',
	'$scope',
	'constants',
	'auth',
	'$state',
	'UserService',
	'AuthToken',
	function(
		$rootScope,
		$scope,
		constants,
		auth,
		$state,
		UserService,
		AuthToken
		){
		$('#isConnected').hide();
		if(UserService.getCurrentUser() != null){
			var userLocal =  UserService.getCurrentUser();
			var tokenId = userLocal.id;
	        AuthToken.get({id: tokenId}, function (successResponse) {
	        	if (successResponse.code === 401){
	        		// AuthToken.delete({id: tokenId}, function(success){
	        		// 	console.log(success);
	        		// });
					UserService.setCurrentUser(null);
					$state.go('login');
				} else {
	        		$state.go('profile.home',{'userid': userLocal.user.id});
	        	}
	        });
    	}
		$scope.loginSubmit = function(){
			auth.loginAuth($scope.username, $scope.password).then(
                function (success) {
                	var user = {};
                	user = success;
                	// user = success.user.id;
                	console.log(success);
                	UserService.setCurrentUser(user);
                	$rootScope.$broadcast('authorized');
                	$state.go('profile.home',{'userid': success.user.id});
                }, function (error){
                	console.log(error);
                });
		}
		// $scope.users = users;
		// $scope.deleteUser = function (userId){
		// 	console.log(userId);
		// 	User.delete({id:userId}, function(success){
		// 		console.log(success);
		// 	},function(error){
		// 		console.log(error);
		// 	});

		// }




	}
]);