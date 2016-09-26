'use strict';
var localTokenmodule = angular.module('localTokenModule', []);

localTokenmodule
.service('UserService',function (store) {
    var service = this;
        var currentUser = null;
    service.setCurrentUser = function(user) {
        currentUser = user;
        store.set('user', user);
        return currentUser;
    };
    service.getCurrentUser = function() {
        if (!currentUser) {
            currentUser = store.get('user');
        }
        return currentUser;
    };
})
.service('APIInterceptor', function($rootScope, UserService) {
    var service = this;
    service.request = function(config) {
        var currentUser = UserService.getCurrentUser();
        var access_token = currentUser ? currentUser.value : null;
        if (access_token) {
            config.headers['X-Auth-Token'] = access_token;
        }
        return config;
    };
    service.responseError = function(response) {
        if (response.status === 401) {
            $rootScope.$broadcast('unauthorized');
        }
        return response;
    };
})