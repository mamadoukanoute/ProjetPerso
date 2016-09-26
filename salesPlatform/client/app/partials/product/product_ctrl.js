'use strict'
angular.module('clientApp').controller('productCtrl', [
	'$scope',
	'$stateParams',
	'Basket',
	'$state',
	'$filter',
	function(
		$scope,
		$stateParams,
		Basket,
		$state,
		$filter
		){
			$scope.orderByFunction = function(order, products){
				var tabOrder = [{'rating': 'rating'}, {'price': 'asc'}, {'price': 'desc'}, {'name': 'name'}];
				var reverse = {name: {value: false}, asc: {value: false}, desc: {value: true}, rating: {value: true}};
				var orderBy = $filter('orderBy');
				var key = Object.keys(tabOrder[order])[0];
				var value = tabOrder[order][key];
				var reverseValue = reverse[value].value;
				return  orderBy(products, key, reverseValue);
			}
			$scope.addToBasketFunction = function (product, qte){
				var basket = {};
				basket.prodid = product.id;
				basket.qte = 1;
				if(qte){
					basket.qte = qte;
				}
				basket.userid = parseInt($stateParams.userid);
	        	Basket.save(basket, function(success){
	                var responseText = "Produit  " + product.name + "  mis dans le panier";
	                alert(responseText);
	                $state.go('profile.basket', {}, {reload: true});
	            },function(error){
	            	console.log(error);
	        });			
			}
		}
]);