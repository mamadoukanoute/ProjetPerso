'use strict'
angular.module('clientApp').controller('productSearchedCtrl', [
    '$rootScope',
	'$scope',
	'$stateParams',
	'Product',
    '$state',
    '$filter',
	function(
        $rootScope,
		$scope,
		$stateParams,
		Product,
        $state,
        $filter
		){
			console.log($scope.searchedProducts);
			$scope.tab = [ 'Note', 'prix croissant', 'prix decroissant', 'name'];
			$scope.order = '0';
			$scope.orderBy = function(){
				$scope.searchedProducts = $scope.orderByFunction($scope.order, $scope.searchedProducts);
			}
			$scope.updateRating = function(product){
				Product.update(product, function(success){
					$scope.searchedProducts = $scope.orderByFunction($scope.order, $scope.searchedProducts);
				}, function(error){
					console.log(error);
				});			
			}	
			$scope.searchedProducts = $scope.orderByFunction($scope.order, $scope.searchedProducts);
		}
]);