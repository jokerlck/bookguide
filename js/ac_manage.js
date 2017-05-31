var app = angular.module('myApp', ['ngMessages']);

var compareTo = function() {
	return {
		require: "ngModel",
		scope: {
			otherModelValue: "=compareTo"
		},
		link: function(scope, element, attributes, ngModel) {

			ngModel.$validators.compareTo = function(modelValue) {
				return modelValue == scope.otherModelValue;
			};

			scope.$watch("otherModelValue", function() {
				ngModel.$validate();
			});
		}
	};
};
var formControl=function(){

};
app.directive("compareTo", compareTo);
app.controller('myctrl',formControl);

var checkBoxes = $('tbody .checkbox');
checkBoxes.change(function(){
  $('#delete').prop('disabled', checkBoxes.filter(':checked').length < 1);
});
checkBoxes.change();

$('#delete').click(function(){
  if (confirm("Are you sure you want to delete this item?")) {
  	$('#delete_form').submit();
  }
});
