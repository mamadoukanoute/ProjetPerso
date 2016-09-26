'use strict'
angular.module('clientApp').controller('productListCtrl', [
    '$rootScope',
	'$scope',
	'$stateParams',
	'Product',
    'products',
    '$state',
    '$filter',
	function(
        $rootScope,
		$scope,
		$stateParams,
		Product,
        products,
        $state,
        $filter
		){

    		$scope.products = products;
    		$scope.selected = true;
			$scope.addToBasket = function(product){
				$scope.addToBasketFunction(product);
			}
			$scope.search = function() {
				Product.query({search: $scope.lookedProduct}, function(success){
					$scope.products = success;
					// console.log(success);
					// $state.go('profile.product.search');
					//console.log(success);
				}, function(error){
					console.log(error);
				});
			}
			$scope.lookedProductChange = function(){
				if ($scope.lookedProduct === ''){
					$scope.products = products;
				}
			}

			$scope.updateRating = function(product){
				Product.update(product, function(success){
					$state.go('profile.product.list', {}, {reload: true});
				}, function(error){
					console.log(error);
				});			
			}
			$scope.tab = [ 'Note', 'prix croissant', 'prix decroissant', 'name'];
			$scope.order = '0';
			$scope.orderBy = function(){
				$scope.products = $scope.orderByFunction($scope.order, $scope.products);
			}
			$scope.products = $scope.orderByFunction($scope.order, $scope.products);
			$scope.deleteProduct = function (prodid){
				Product.delete({id:prodid}, function(success){
					$state.go('profile.product.list', {}, {reload: true});
				}, function(error){
					console.log(error);
				});

			}
		}
]);