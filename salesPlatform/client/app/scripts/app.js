'use strict';

/**
 * @ngdoc overview
 * @name clientApp
 * @description
 * # clientApp
 *
 * Main module of the application.
 */
angular
    .module('clientApp', [
        'ngRoute',
        'ui.router',
        'pxResources',
        'pxResolverModule',
        'loginModule',
        'angular-storage',
        'localTokenModule',
    ])
    .config(function ($stateProvider,  $urlRouterProvider, $httpProvider) {
        $httpProvider.interceptors.push('APIInterceptor');
        $urlRouterProvider.otherwise("/");
        $stateProvider
            .state('login', {
                url: "/login",
                controller: 'loginCtrl',
                // abstract: true,
                templateUrl: "partials/auth/login.html",
                // resolve: {
                //     users: ['pxResolver',
                //         function (pxResolver) {
                //             return pxResolver.userList();
                //     }]
                // }
            })
            .state('signin', {
                url: "/update",
                controller: 'signinCtrl',
                // abstract: true,
                templateUrl: "partials/auth/signin.html",
                // resolve: {
                //     users: ['pxResolver',
                //         function (pxResolver) {
                //             return pxResolver.userList();
                //     }]
                // }
            })
            // .state('signin', {
            //     url: "/update",
            //     controller: 'signinCtrl',
            //     // abstract: true,
            //     templateUrl: "partials/auth/signin.html",
            //     // resolve: {
            //     //     users: ['pxResolver',
            //     //         function (pxResolver) {
            //     //             return pxResolver.userList();
            //     //     }]
            //     // }
            // })            
           .state('profile', {
                url: '/profile/{userid}',
                abstract: true,
                controller: 'profileCtrl',
                templateUrl: "partials/profile/profile.html",
                resolve: {
                    user: ['pxResolver', '$stateParams',
                        function (pxResolver, $stateParams) {
                            if($stateParams.userid ){
                                return pxResolver.user($stateParams.userid);
                            }
                    }],
                }
            })
           .state('profile.home', {
                url: '',
                controller: 'profileHomeCtrl',
                templateUrl: "partials/profile/profile_home.html",
            })                        
            .state('profile.product', {
                url: '/product',
                abstract: true,
                controller: 'productCtrl',
                templateUrl: "partials/product/product.html",
            })
            .state('profile.product.list', {
                url: '',
                controller: 'productListCtrl',
                templateUrl: "partials/product/product_list.html",
                resolve: {
                    lookedUser: ['pxResolver','$stateParams',
                        function (pxResolver, $stateParams) {
                            return pxResolver.user($stateParams.userid);
                    }],
                    products: ['pxResolver','$stateParams','lookedUser',
                        function (pxResolver, $stateParams,lookedUser) {
                            return pxResolver.productList();
                    }]
                }
            })
           .state('profile.product.search', {
                url: '/search',
                controller: 'productSearchedCtrl',
                templateUrl: "partials/product/product_search.html",
                // resolve: {
                //     user: ['pxResolver', '$stateParams',
                //         function (pxResolver, $stateParams) {
                //             if($stateParams.userid ){
                //                 return pxResolver.user($stateParams.userid);
                //             }
                //     }],
                // }
            })
            // .state('profile.product.list_client', {
            //     url: '/client',
            //     controller: 'productListCtrl',
            //     templateUrl: "partials/product/product_list.html",
            //     resolve: {
            //         products: ['pxResolver','$stateParams',
            //             function (pxResolver, $stateParams) {
            //                 return pxResolver.productList();
            //         }]
            //     }
            // })
            .state('profile.product.info', {
                url: '/{prodid}/info',
                controller: 'productInfoCtrl',
                templateUrl: "partials/product/product_info.html",
                resolve: {
                    product: ['pxResolver','$stateParams',
                        function (pxResolver, $stateParams) {
                            return pxResolver.product($stateParams.prodid);
                    }]
                }
            })
            .state('profile.product.new', {
                url: '/edit',
                controller: 'productNewCtrl',
                templateUrl: "partials/product/product_new.html",
                resolve: {
                    product: function(){}
                }
            })          
            .state('profile.product.edit', {
                url: '/{id}/edit',
                controller: 'productNewCtrl',
                templateUrl: "partials/product/product_new.html",
                resolve: {
                    product: ['pxResolver', '$stateParams',
                        function (pxResolver, $stateParams) {
                            if($stateParams.id ){
                                return pxResolver.product($stateParams.id);
                            }
                    }]
                }
            })
            .state('profile.basket', {
                url: '/basket',
                // abstract: true,
                controller: 'basketCtrl',
                templateUrl: "partials/basket/basket.html",
                resolve: {
                    baskets: ['pxResolver','$stateParams',
                        function (pxResolver, $stateParams) {
                            return pxResolver.basketList($stateParams.userid);
                    }]
                }
            })
            .state('profile.order', {
                url: '/order',
                // abstract: true,
                controller: 'orderCtrl',
                templateUrl: "partials/order/order.html",
                resolve: {
                    lookedUser: ['pxResolver','$stateParams',
                        function (pxResolver, $stateParams) {
                            return pxResolver.user($stateParams.userid);
                    }],
                    orders: ['pxResolver','lookedUser','$stateParams',function(pxResolver,lookedUser,$stateParams){
                        return  pxResolver.orderList();
                    }]
                },
                // onEnter: ['$rootScope','pxResolver','lookedUser','$stateParams',function($rootScope, pxResolver,lookedUser,$stateParams){
                //     $rootScope.orders = pxResolver.orderList({userid: parseInt($stateParams.userid), type: lookedUser.type});
                //     console.log($rootScope.orders.status);
                // }]
            })
            // .state('profile.order.list', {
            //     url: '',
            //     controller: 'orderListCtrl',
            //     templateUrl: "partials/order/order_list.html",

            // })

            // .state('profile.basket.list', {
            //     url: '',
            //     controller: 'basketListCtrl',
            //     templateUrl: "partials/basket/basket_list.html",
            // })         

    // $routeProvider
    //   .when('/', {
    //     templateUrl: 'views/main.html',
    //     controller: 'MainCtrl',
    //     controllerAs: 'main'
    //   })
    //   .when('/about', {
    //     templateUrl: 'views/about.html',
    //     controller: 'AboutCtrl',
    //     controllerAs: 'about'
    //   })
    //   .otherwise({
    //     redirectTo: '/'
    //   });
  });
