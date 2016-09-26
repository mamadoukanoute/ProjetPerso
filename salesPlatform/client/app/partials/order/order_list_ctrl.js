'use strict'
angular.module('clientApp').controller('orderListCtrl', [
	'$scope',
	'$stateParams',
	'Order',
	'orders',
	function(
		$scope,
		$stateParams,
		Order,
		orders
		){
		$scope.orders = orders;
		//console.log($scope.current_user)
		// console.log('test');
}
]);