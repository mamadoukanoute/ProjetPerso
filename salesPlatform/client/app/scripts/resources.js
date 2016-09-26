'use strict'
angular.module('pxResources', ['ngResource'])
.factory('User', ['$resource', 'constants', function ($resource, constants) {
    return $resource(constants.api_url + 'users/:id', {id:'@id'},
        {
            update :{
                method:'PUT'
            },

        });
}])
.factory('AuthToken', ['$resource', 'constants', function ($resource, constants) {
    return $resource(constants.api_url + 'auth-tokens/:id', {id:'@id'},
        {
            update :{
                method:'PUT'
            },  
            login :{
                method:'POST'
            },           

        });
}])
.factory('Product', ['$resource', 'constants', function ($resource, constants) {
    return $resource(constants.api_url + 'products/:id', {id:'@id'},
        {
            update :{
                method:'PUT'
            },

        });
}])
.factory('Basket', ['$resource', 'constants', function ($resource, constants) {
    return $resource(constants.api_url + 'baskets/:id', {id:'@id'},
        {
            update :{
                method:'PUT'
            },

        });
}])
.factory('Order', ['$resource', 'constants', function ($resource, constants) {
    return $resource(constants.api_url + 'orders/:id', {id:'@id'},
        {
            update :{
                method:'PUT'
            },           

        });
}])