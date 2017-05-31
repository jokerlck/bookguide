var app= angular.module('myApp',[]);
app.controller('myCtrl',function($scope,$http,$location,$window){
  $http.get("release.php")
  .then(function (response) {
    $scope.data = response.data.dataset;
    $scope.follow = response.data.follow;
  });
});
app.filter('split', function() {
      return function(input, splitChar, splitIndex) {
          // do some bounds checking here to ensure it has that index
          return input.split(splitChar)[splitIndex];
      }
  });