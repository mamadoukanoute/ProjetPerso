'use strict'
angular.module('clientApp').controller('panierNewCtrl', [
    '$rootScope',
	'$scope',
	'$stateParams',
    'Basket',
    '$state',
    'basket',
	function(
        $rootScope,
		$scope,
		$stateParams,
        Basket,
        $state,
        basket
		){
		var method = 'save';
        if($stateParams.id === null  || $stateParams.id === undefined ) {
            $scope.basket = {}
        } else {
            method = 'update';
            $scope.basket = basket;
            $scope.basket.typeid = "" + $scope.basket.typeid;
        }

        $scope.tab = ['Lait', 'Viande', 'Boisson', 'Fruits'];
        $scope.savebasket = function () {
            $scope.basket.fournid = parseInt($stateParams.userid);
            $scope.basket.typeid = parseInt($scope.basket.typeid);
            $scope.basket.price = parseInt($scope.basket.price);
            $scope.basket.name_file = 'test';
            // console.log($scope.basket)
        	Basket[method]($scope.basket, function(success){
                console.log(success);
                $state.go("profile.basket.list", {}, {reload: true});
            },function(error){
            	console.log(error);
        });
}


	}
]);