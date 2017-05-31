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
    var str1="search.php?";
    return str1.concat(sURLVariables[1]);
  }
var app= angular.module('myApp',[]);
app.controller('searchCtrl',function($scope,$http,$location,$window){
  var $str=getUrlParameter();
  $http.get($str)
  .then(function (response) {
    $scope.data=response.data.dataset;
    $scope.by=response.data.by;
    $scope.q=response.data.q;
    $scope.num=response.data.num;
    $scope.seller=response.data.seller;
  });
  $scope.alert=function(bid,isbn,seller){
    //ISBN=ISBN&Bid=bid
    if(seller==1){
      var querystring="";
      querystring=querystring.concat("bid=",bid);
      var children = "http://bookguide.jaar.ga/item.php?";
      children=children.concat(querystring);
      $window.location.href = children;
    }
    else{
      var querystring="";
      querystring=querystring.concat("ISBN=",isbn);
      var children = "http://bookguide.jaar.ga/book_info.php?";
      children=children.concat(querystring);
      $window.location.href = children;
    }

  };
});
app.filter('split', function() {
      return function(input, splitChar, splitIndex) {
          // do some bounds checking here to ensure it has that index
          return input.split(splitChar)[splitIndex];
      }
  })
  app.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
})
;