'use strict'
angular.module('clientApp').controller('basketCtrl', [
	'$scope',
	'$stateParams',
	'baskets',
	'Order',
	'$state',
	function(
		$scope,
		$stateParams,
		baskets,
		Order,
		$state
		){
		$scope.baskets = baskets;
		$scope.tab = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
		var test;
		$scope.addToOrder = function(){
			for (var i = 0; i < $scope.baskets.length; i++){
				$scope.order = {};
				$scope.order.userid = parseInt($stateParams.userid);
				$scope.order.pid = $scope.baskets[i].id;
				$scope.order.prodid = $scope.baskets[i].prodid;
				$scope.order.qte = $scope.baskets[i].qte;
				Order.save($scope.order, function(success){
					alert("commande passée avec succès");
					$state.go('profile.order', {}, {reload: true});
				}, function(error){
					console.log(error);
				});	
			}
		}
		// var method = 'save';
  //       if($stateParams.id === null  || $stateParams.id === undefined ) {
  //           $scope.user = {}
  //       } else {
  //           method = 'update';
  //           $scope.user = user;
  //       }

 //        $scope.saveProduct = function () {
 //        	console.log(method);
 //        	User[method]($scope.user, function(success){
 //                console.log(success);
 //                $state.go("users.list", {}, {reload: true});
 //            },function(error){
 //            	console.log(error);
 //        });



	// }
}
]);