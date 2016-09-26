'use strict'
angular.module('clientApp').controller('productNewCtrl', [
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
		var method = 'save';
        if($stateParams.id === null  || $stateParams.id === undefined ) {
            $scope.product = {}
            $scope.show = true;
        } else {
            $scope.show = false;
            method = 'update';
            $scope.product = product;
            $scope.product.typeid = "" + $scope.product.typeid;
        }

        $scope.tab = ['Lait', 'Viande', 'Boisson', 'Fruits'];

        var dataURLToBlob = function(dataURL) {
            var BASE64_MARKER = ';base64,';
            if (dataURL.indexOf(BASE64_MARKER) == -1) {
                var parts = dataURL.split(',');
                var contentType = parts[0].split(':')[1];
                var raw = parts[1];
                return new Blob([raw], {type: contentType});
            }
            var parts = dataURL.split(BASE64_MARKER);
            var contentType = parts[0].split(':')[1];
            var raw = window.atob(parts[1]);
            var rawLength = raw.length;
            var uInt8Array = new Uint8Array(rawLength);
            for (var i = 0; i < rawLength; ++i) {
                uInt8Array[i] = raw.charCodeAt(i);
            }
                        // console.log(uInt8Array);

            return new Blob([uInt8Array], {type: contentType});
        };
        var elet = document.getElementById('fichier');
        elet.addEventListener('change', function() {
            var current_file = this.files[0];
            var reader = new FileReader();
            if (current_file.type.indexOf('image') == 0) {
                reader.onload = function (event) {
                var image = new Image();
                image.src = event.target.result;
                console.log('Autre');
                // console.log(event.target.result);
                    image.onload = function() {
                        var imageWidth = 150;
                        var imageHeight = 100;
                        var canvas = document.createElement('canvas');
                        canvas.width = imageWidth;
                        canvas.height = imageHeight;
                        image.width = imageWidth;
                        image.height = imageHeight;
                        var ctx = canvas.getContext("2d");
                        ctx.drawImage(this, 0, 0, 150, 100);
                        $scope.product.name_file = canvas.toDataURL(current_file.type);
                    }
                }
                reader.readAsDataURL(current_file);
            } else {
                alert("vous devez choisir une image sinon votre requete ne sera pas envoyée");
            }
        }); 
        $scope.saveProduct = function () {
            $scope.product.fournid = parseInt($stateParams.userid);
            $scope.product.typeid = parseInt($scope.product.typeid);
            $scope.product.price = parseInt($scope.product.price);
            Product[method]($scope.product, function(success){
                    console.log(success);
                   $state.go("profile.product.list", {}, {reload: true});
                },function(error){
                console.log(error);
            });
        }

    }
]);