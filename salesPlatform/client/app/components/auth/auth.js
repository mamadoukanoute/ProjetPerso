'use strict';
var loginmodule = angular.module('loginModule', []);

loginmodule.service('auth', ['$rootScope', 'AuthToken', '$q','$http',
    function ($rootScope, AuthToken, $q, $http) {
        this.loginAuth = function (username, password) {
           var deferred = $q.defer();
                AuthToken.login({username: username, password: password}, function (successResponse) {
                    $rootScope.user = successResponse.user;
                    //console.log($rootScope.user);
                    deferred.resolve(successResponse);
                }, function(error){
                    console.log(error);
                });
                return deferred.promise;
        }
        this.logout = function () {
            var deferred = $q.defer();
            User.logout(function () {
                destroyUserData();
                $rootScope.$broadcast('authChange', 'loggedOut');
                deferred.resolve(1);
                //Analytics.user().traits({});
                if (window.mixpanel && window.mixpanel.cookie && window.mixpanel.cookie.clear) {
                    window.mixpanel.cookie.clear();
                }
            }, function () {
                deferred.resolve(0);
            });
            return deferred.promise;
        };

        // service.ping = function () {
        //     var deferred = $q.defer();
        //     User.ping(function (data) {
        //         applyUserData(data);
        //         Analytics.identify(data.id);
        //         $rootScope.$broadcast('authChange', 'loggedIn');
        //         deferred.resolve(1);
        //     }, function () {
        //         deferred.resolve(0);
        //     });
        //     return deferred.promise;
        // };

        // service.ping(); // on 
    }
    ]);