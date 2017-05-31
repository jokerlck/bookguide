<?php
    // Page parameters
    $page_config['js'] = array('category_page.js','home_page.js','clickable-row.js');
    $page_config['css'] = array('clickable-row.css');
  include('template/main.php');
?>
<!--searchBar-->
<script type="text/javascript">
  function setSearchType(type){
    // Change searchBy selection by type parameter
    document.getElementById('searchType').value = type;
    if(type=='Bname'){
        document.getElementById('searchBy').innerHTML = "Book Name";
      }
      else if (type=='hashtag') {
        document.getElementById('searchBy').innerHTML = "Hash Tag";
      }
      else{
        document.getElementById('searchBy').innerHTML = type;
      }
  }
</script>

<form action="category_page.php" method="GET">
  <div class="container" id="topbar-search">
      <form class="navbar-form">
        <div class="input-group"><!--input group-->
          <div class="input-group-btn"><!--left input btn-->
              <li class="dropdown"><a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="searchBy" >Search By <span class="caret"></span></a>
                  <ul class="dropdown-menu" id="main-search">
                    <li><a href="javascript:setSearchType('Bname')">Book Name</a></li> <!--hidden field implement by ivan/ronald-->
                    <li><a href="javascript:setSearchType('Author')">Author</a></li> <!--hidden field implement by ivan/ronald-->
                    <li><a href="javascript:setSearchType('ISBN')">ISBN</a></li> <!--hidden field implement by ivan/ronald-->
                    <li><a href="javascript:setSearchType('Category')">Category</a></li> <!--hidden field implement by ivan/ronald-->
                  </ul>
                </li>
              </div><!--/left input btn-->
            <form  id="search"  name="form">
              <input type="hidden" name="by" id="searchType" value="Bname" ng-model="by">
              <div class="form validate" >
                <input type="text" name="q"  class="form-control" aria-label="..." ng-model="q" required>
              </div>
              	<!--text-->
              <div class="input-group-btn" id="searchBtn"><!--right input btn-->
                <button type="submit" class="btn" ng-disabled="form.$invalid"><span class="glyphicon glyphicon-search grey" aria-hidden="true"></span></button>
              </div><!--/right input btn-->
            </form>
        </div><!--/input group-->
  </form>
</div><!--searchBar end-->
<div class="container"><!--category start-->
  <div class="row">
    <div class="col-sm-4 col-md-3">
      <div class="navbar-vertical">
        <ul class="nav nav-stacked" id="category">
          <li class="header"><h6 class="text-uppercase">Categories</h6></li>
          <?php
            $stmt = $db->prepare("SELECT * FROM `Category` WHERE `parentID` = -1");
            $stmt->execute();
            $topmost = $stmt->fetchAll();
          ?>
          <?php foreach ($topmost as $entry): ?>
          <li class="dropdown" id="c-drop"><a class="dropdown-toggle" href="category_page.php?by=Category&q=<?php echo $entry['categoryID']?>"><?php echo $entry['chiName']?> <?php echo $entry['engName']?> <i class="glyphicon glyphicon-chevron-right pull-right"></i></a>
          <?php
            $subStmt = $db->prepare("SELECT * FROM `Category` WHERE `parentID`=?");
            $subStmt->bindValue(1, $entry['categoryID']);
            $subStmt->execute();
            $subEntries = $subStmt->fetchAll();
          ?>
          <?php if (sizeof($subEntries) > 0): ?>
            <ul class="dropdown-menu" id="category-dropdown">
            <?php foreach ($subEntries as $subentry): ?>
              <li><a href="category_page.php?by=Category&q=<?php echo $entry['categoryID']?>"><?php echo $subentry['chiName']?> <?php echo $subentry['engName']?></a></li>
            <?php endforeach;?>
            </ul>
          <?php endif;?>
          <?php endforeach;?>
        </ul>
      </div><!--category end-->

     <hr class="spacer-20 no-border">
      <div class="widget"><h6 class="subtitle text-uppercase">Top Rating Book</h6>
          <table class="table table-hover " id="topRating" >
          <tbody>
            <?php
              // Find the 5 most clicked book
              $stmt = $db->prepare('SELECT `ISBN` FROM `ClickRate` ORDER BY `rate` DESC LIMIT 5');
              $stmt->execute();
              $result = $stmt->fetchAll();
              // For each book find the book details
              foreach($result as $item):
                $stmt2 = $db->prepare("SELECT DISTINCT `Bname`, `Bid`, `Author`, `filename` FROM `Book` WHERE `ISBN`=?");
                $stmt2->bindValue(1,$item['ISBN']);
                $stmt2->execute();
                $book = $stmt2->fetch();
                if ($book):?>
                <tr class=".clickable-row" data-href="book_info.php?Bid=<?php echo $book['Bid']?>&ISBN=<?php echo $item['ISBN']?>">
                  <td>
                    <div class="product-details">
                      <img src="book_cover.php?id=<?php echo $book['Bid']?>" class="product-image">
                  </td>
                  <td>
                    <div>
                      <a href="book_info.php?Bid=<?php echo $book['Bid']?>&ISBN=<?php echo $item['ISBN']?>" class="product-image" style="text-decoration:none; color: inherit;">
                        <p class="bname" style="text-align:right;"><?php echo $book['Bname']?></p>
                        <p class="author" style="text-aligsn:right;"><?php echo $book['Author']?></p>
                      </a>
                    </div>
                </div>
                </tr>
                <?php endif; ?>

                </td>
              <?php endforeach;?>
              </tbody>
          </table>
      </div>
    </div> <!--/Categories end-->
    <div class="col-sm-8 col-md-9">
        <div class="well">
       <!--Category Field-->
          <div class="row" ng-app="myApp" ng-controller="searchCtrl">
              <h4>SearchBy:<span ng-bind="by"></span>:<span ng-bind="q"></span><span ng-bind="num" style="float:right;"></span><span style="float:right;">No Of result:</span></h4>
              <table class="table table-hover ">
                <thead>
                  <tr>
                    <th>Book</th>
                    <th>Description</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="search in data | startFrom:0| limitTo:8 " ng-click="alert(search.Bid,search.ISBN,seller)">
                    <td class="col-md-2">
                        <img  ng-src="./book_cover.php?id={{search.Bid}}" alt="Sample Product" style="max-width: 100%; max-height: 100%; width:auto; height: auto;">
                    </td><!--book cover pic field-->
                    <td class="col-md-8">
                      <table>
                        <tr>
                          <td><h4>{{search.Bname}}</h4></td> <!--Book name field-->
                        </tr>
                        <tr>
                          <td>Author:  {{search.Author}}</td>  <!--Author field-->
                        </tr>
                        <tr ng-show="seller==1">
                          <td ng-show="seller==1">Seller: {{search.Nickname}}</td>
                        </tr>
                        <tr ng-show="seller==1">
                          <td>Price: ${{search.Price}}</td>
                        </tr>
                        <tr>
                          <td><br>{{search.Description| limitTo: 400 }}{{search.Description.length > 400 ? '...' : ''}}</td>  <!--description field-->
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <!--End of one entry-->
                </tbody>
              </table>
          </div>
          <!--END ROW-->

        </div>
    </div>
</div>
</div>

<?php require('template/footer.php'); ?>
