'use strict'
angular.module('clientApp').controller('orderCtrl', [
	'$rootScope',
	'$scope',
	'$stateParams',
	'$state',
	'lookedUser',
	'orders',
	'Order',
	function(
		$rootScope,
		$scope,
		$stateParams,
		$state,
		lookedUser,
		orders,
		Order
		){
		$scope.orders = orders;
		console.log($scope.orders);
		$scope.acceptOrder =function(order){
			$scope.order_accept = order;
			$scope.order_accept.status = 'accept';
			delete $scope.order_accept.name;
			Order.update($scope.order_accept, function(success){
				$state.go('profile.order', {}, {reload: true});
			}, function(error){
				console.log(error);
			});
		}
		$scope.refuseOrder =function(order){
			$scope.order = order;
			$scope.order.status = 'refuse';
			// console.log($scope.order);
			Order.update($scope.order, function(success){
				console.log(success);
			}, function(error){
				console.log(error);
			});
		}
		}
]);