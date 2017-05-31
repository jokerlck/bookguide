<?php
  require('template/main.php');
  if(!isset($_GET['ISBN'])){
    header('Location: http://bookguide.jaar.ga/home.php');
  }
?>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.0/angular.min.js"></script>
<div class="container" ng-app="myApp" ng-controller="searchCtrl" >
  <div class="well" ng-repeat="i in data | limitTo: 1">

           <!--BOOK TITLE Field-->
            <br>
            <h3>{{i.name}}</h3>
            <div class="row">
            <div class="col col-md-8">

              <table style="width:100%">
                  <tr>
                      <th>Author</th>
                      <td><a ng-href="./category_page.php?by=author&q={{i.author}}">{{i.author}}</a></td>  <!--Author Field-->
                  </tr>
                  <tr>
                      <th>Publication Date</th>
                      <td>{{i.PostTime}}</td>                     <!--Publish date Field-->
                  </tr>
                  <tr>
                      <th>ISBN</th>
                      <td>{{i.ISBN}}</td>                  <!--ISBN Field-->
                  </tr>
                  <tr>
                      <th>Category</th>
                      <td><a ng-href="./category_page.php?by=Category&q={{i.category}}">{{i.category}}</a></td>   <!--Category Field-->
                  </tr>
              </table>
            <br>

            <table style="width:100%">
              <tr>
                <th>Description</th>
              </tr>
              <tr>
                <td>
                  {{i.Description}}
                  <!--Description field-->
                </td>
              </tr>
            </table> <br>

            </div>

            <div class="col-6 col-md-4">
                <img ng-src="./data/upload/{{datai.filename|| i.filename|split:',':0}}" class="img-rounded" alt="book_cover" >  <!--Image field-->
            </div>
            </div>
            <!--END ROW-->
          </div>


            <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
            <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>

            <!--new row-->
            <div class="row">

                <BR><h3>People selling this book</h3>
                <div class='list-group gallery'>
                  <!--Fetch data and use for loop to generate the following-->
                      <div ng-repeat="i in data | limitTo:4" >
                        <div class="col-sm-6 col-xs-12 col-md-6 col-lg-6">
                        <a class="thumbnail fancybox" rel="ligthbox" ng-href="item.php?bid={{i.Bid}}">
                        <img class="img-responsive" ng-src="./data/upload/{{datai.filename|| i.filename|split:',':0}}" alt="">
                        <small class='text-muted'>{{i.Seller}}</small>
                        </a>
                        </div>
                      </div> <!-- container end -->
            </div> <!-- row / end -->



    </div>
<script>
function getUrlParameter() {
    var sPageURL = window.location.search.substring("");
        var sURLVariables = sPageURL.split("?");
    var str1="info.php?";
    return str1.concat(sURLVariables[1]);
  }
var app= angular.module('myApp',[]);
app.controller('searchCtrl',function($scope,$http,$location,$window){
  var $str=getUrlParameter();
  $http.get($str)
  .then(function (response) {
      $scope.data = response.data.dataset;
      if(!$scope.data){
        $window.location.href="home.php";
      }


    });

});
app.filter('split', function() {
        return function(input, splitChar, splitIndex) {
            // do some bounds checking here to ensure it has that index
            return input.split(splitChar)[splitIndex];
        }
      });

</script>
<?php require('template/footer.php'); ?>
