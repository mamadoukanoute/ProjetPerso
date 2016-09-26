'use strict';
angular.module('pxResolverModule', []).factory('pxResolver', ['$q', '$state', 'User','Product','Basket','Order',
    function ($q, $state, User, Product, Basket, Order) {
        // Todo: Fix uri query, move to separate file, use this for all views.
        var resolver = {
            userList: function(){
                var deferred = $q.defer();
                User.query(function (successResponse) {
                    deferred.resolve(successResponse);
                }, function (error){
                    console.log(error);
                });
                return deferred.promise;
            },
            user: function(key){
                    var deferred = $q.defer();
                    User.get({id:key},function (successResponse) {
                    deferred.resolve(successResponse);
                }, function (error){
                    console.log(error);
                });
                return deferred.promise;
            },
            productList: function(){
                var deferred = $q.defer();
                    Product.query(function (successResponse) {
                        console.log(successResponse);
                        deferred.resolve(successResponse);
                    }, function (error){
                        if(error.status == 404 ){
                            alert("Vous n'avez pas de produit dans la bd");
                        } else {
                            console.log(error);
                        }
                    });
                return deferred.promise;
            },
            product: function(key){
                      var deferred = $q.defer();
                    Product.get({id:key},function (successResponse) {
                    deferred.resolve(successResponse);
                }, function (error){
                    console.log(error);
                });
                return deferred.promise;
            },
            basketList: function(id){
                var deferred = $q.defer();
                if(id !== null || id !== undefined){
                    console.log("putain");
                    Basket.query({userid: id}, function (successResponse) {

                        console.log(successResponse);
                        deferred.resolve(successResponse);
                    }, function (error){
                        if(error.status == 404 ){
                            alert("Vous n'avez pas de panier dans la bd");
                        } else {
                            console.log(error);
                        }
                    });
                }else console.log("putain");
                return deferred.promise;
            },
            basket: function(key){
                      var deferred = $q.defer();
                    Basket.get({id:key},function (successResponse) {
                    deferred.resolve(successResponse);
                }, function (error){
                    console.log(error);
                });
                return deferred.promise;
            },
            orderList: function(){
                var deferred = $q.defer();
                    Order.query(function (successResponse) {
                        deferred.resolve(successResponse);
                    }, function (error){
                        if(error.status == 404 ){
                            alert("Vous n'avez pas de panier dans la bd");
                        } else {
                            console.log(error);
                        }
                    });
                return deferred.promise;
            }

        };

        return resolver;
    }
]);