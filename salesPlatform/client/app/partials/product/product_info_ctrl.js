'use strict'
angular.module('clientApp').controller('productInfoCtrl', [
    '$rootScope',
    '$scope',
    '$stateParams',
    'Product',
    '$state',
    'product',
    '$timeout',
    function(
        $rootScope,
        $scope,
        $stateParams,
        Product,
        $state,
        product,
        $timeout
        ){
        $scope.product = product;
        $scope.tab = [];
        for(var i = 1; i <= $scope.product.qte; i++){
            $scope.tab.push(i);
        }
        $scope.qte = '0';
        $scope.addBasket = function(){
            $scope.addToBasketFunction($scope.product, $scope.tab[$scope.qte]);
        }
    }
]);