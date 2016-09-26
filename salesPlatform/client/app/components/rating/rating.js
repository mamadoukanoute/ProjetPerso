angular.module('clientApp').directive('rating', function () {
	return {
		restrict: 'EA',
		require: 'ngModel',
		templateUrl: 'components/rating/rating.html',
		scope: {
			ratingMaxValue: '=',
			ngModel: '='
		},
		link: function($scope, elem, attrs, ngModelCtrl){
			var updateComponent = function(){
				$scope.notes = [];
				for(var i = 0; i < $scope.ratingMaxValue; i++){
					$scope.notes.push({selected: i < ngModelCtrl.$modelValue});
				}
			};

			$scope.rate = function(index){
				for(var i = 0; i < $scope.notes.length; i++){
					if (i <= index){
						$scope.notes[i].selected = true;
					}else {
						$scope.notes[i].selected = false;
					}
				}
				ngModelCtrl.$setViewValue(index+1);
			};
			$scope.$watch('ngModel', function(oldVal, newVal){
				updateComponent();
			})
		}
	}
    });