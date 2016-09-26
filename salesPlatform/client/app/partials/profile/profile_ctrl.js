'use strict'
angular.module('clientApp').controller('profileCtrl', [
	'$rootScope',
	'$scope',
	'user',
	'$state',
	'AuthToken',
	'UserService',
	'Product',
	function(
		$rootScope,
		$scope,
		user,
		$state,
		AuthToken,
		UserService,
		Product
		){
			$scope.current_user = user;
			console.log($scope.current_user);
			$scope.isConnected = true;
			$('#notConnected').hide();

			// $scope.search = function() {
			// 	Product.query({search: $scope.lookedProduct}, function(success){
			// 		$scope.searchedProducts = success;
			// 		console.log(success);
			// 		$state.go('profile.product.search');
			// 		//console.log(success);
			// 	}, function(error){
			// 		console.log(error);
			// 	});
			// }
			$scope.logout = function(){
				var tokenId = UserService.getCurrentUser().id;
				AuthToken.delete({id: tokenId}, function(success){
					UserService.setCurrentUser(null);
					$state.go('login', {}, {reload: true});
				}, function(error){
					console.log(error);
				});
	            // $scope.current_user = undefined;
	            // $rootScope.user = undefined;
	            // $state.go('login', {}, {reload: true});
			}
        }
]);