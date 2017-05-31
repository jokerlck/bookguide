function getUrlParameter() {
    //var sPageURL = dummyPath || window.location.search.substring("");
    var sPageURL = window.location.search.substring("");
        //sURLVariables = sPageURL.split(/[&||?]/),
        var sURLVariables = sPageURL.split("?");
        //res;

    //for (var i = 0; i < sURLVariables.length; i += 1) {
        //var paramName = sURLVariables[i],
            //sParameterName = (paramName || '').split('=');

        //if (sParameterName[0] === param) {
            //res = sParameterName[1];
        //}
    //}
    var str1="info.php?";
    return str1.concat(sURLVariables[1]);
  }
var app= angular.module('myApp',[]);
app.controller('searchCtrl',function($scope,$http,$location){
  var $str=getUrlParameter();
  $http.get($str)
  .then(function (response) {$scope.data = response.data.dataset;});
});
