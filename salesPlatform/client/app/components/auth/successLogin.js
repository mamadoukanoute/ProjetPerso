'use strict';
var loginmodule = angular.module('loginModule', []);

loginmodule.service('successLogin', ['$rootScope', 'User', '$q','$http',
    function ($rootScope, User,  $q, $http) {
        this.redirect = function (user) {
            if(user.type === 0){
                $state.go('profile.home',{'userid': user.id});
            }
            if(user.type === 1){
                $state.go('profile.home_vendeur',{'userid': user.id});
            }
        }

    }
    ]);