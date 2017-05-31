<?php
  $page_config['js'] = array('home.js','home_page.js','clickable-row.js');
  $page_config['css'] = array('clickable-row.css');
  include('template/main.php');
  ?>
<!--searchBar-->
<script type="text/javascript">
  function setSearchType(type){
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

<form action="category_page.php" method="GET" >
  <div class="container" id="topbar-search" >
      <form class="navbar-form">
        <div class="input-group"><!--input group-->
          <div class="input-group-btn"><!--left input btn-->
              <li class="dropdown"><a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="searchBy" >Book Name <span class="caret"></span></a>
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
                  <input type="text" name="q"  class="form-control" aria-label="..." ng-model="q" required >
                </div>
                	<!--text-->
                <div class="input-group-btn" id="searchBtn"><!--right input btn-->
                  <button type="submit" class="btn" ng-disabled="form.$invalid "><span class="glyphicon glyphicon-search grey" aria-hidden="true"></span></button>
                </div><!--/right input btn-->

              </form>
        </div><!--/input group-->
  </form>

</div><!--searchBar end-->
<br>
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
              <li><a href="category_page.php?by=Category&q=<?php echo $subentry['categoryID']?>"><?php echo $subentry['chiName']?> <?php echo $subentry['engName']?></a></li>
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
              $stmt = $db->prepare('SELECT `ISBN` FROM `ClickRate` ORDER BY `rate` DESC LIMIT 5');
              $stmt->execute();
              $result = $stmt->fetchAll();
              foreach($result as $item):
                $stmt2 = $db->prepare("SELECT DISTINCT `Bname`, `Bid`, `Author`, `filename` FROM `Book` WHERE `ISBN`=?");
                $stmt2->bindValue(1,$item['ISBN']);
                $stmt2->execute();
                $book = $stmt2->fetch();
                if ($book):?>
                <tr class="clickable-row" data-href="book_info.php?Bid=<?php echo $book['Bid']?>&ISBN=<?php echo $item['ISBN']?>">
                  <td>
                    <div class="product-details">
                      <img src="book_cover.php?id=<?php echo $book['Bid']?>" class="product-image">
                  </td>
                  <td>
                    <div>
                      <p class="bname"><?php echo $book['Bname']?></p>
                      <p class="author"><?php echo $book['Author']?></p>
                    </div>
                </div>
                </tr>
                <?php endif; ?>

                </td>
              <?php endforeach;?>
              <!--<a href="#" class="product-image"><img src="img/1.jpg" alt="Sample Product"></a><p class="product-name"><a href="#">Aaron is a bit short</a></p><p class="product-name">$19.69</p><p class="product-name">JK Rollin</p>-->
          </tbody>
          </table>
      </div>
    </div> <!--/Categories end-->

  <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>


    <div class="col-sm-8 col-md-9" ng-app="myApp" ng-controller="myCtrl">
  			<div class="well">
    			<h2> New Release </h2>
    				<div class='list-group gallery' >
                <div style = "height: 600px;">
            	    <div class='col-sm-6 col-xs-6 col-md-4 col-lg-3' ng-repeat="i in data| limitTo:8">
                    	<a href=item.php?bid={{i.Bid}}><img class="img-responsive" alt="" ng-src="book_cover.php?id={{i.Bid}}" /> <!--Image Field--></a><div style = "height:50px;">
                        	<font size=2 class='text-muted'>{{i.Bname}} - <font color = rgb(0,73,208)>{{i.Seller}}</font></font></div>
                    	</div> <!-- text-right / end -->
                  </div>
            			</div> <!-- col-6 / end -->
            <br>
            <h2> Following </h2>
            <div class='list-group gallery'>
                  <div class='col-sm-6 col-xs-6 col-md-4 col-lg-3' ng-repeat="i in follow|limitTo:4">
                      <a ng-href="item.php?bid={{i.Bid}}"> <!--Link Field-->
                          <img class="img-responsive" alt="" ng-src="book_cover.php?id={{i.Bid}}" /> <!--Image Field-->
                              <font size=2 class='text-muted'><font color = rgb(10,79,165)>{{i.Bname}}</font> - <font color = rgb(0,73,208)>{{i.nickname}}</font></font>
                      </a>
                  </div> <!-- col-6 / end -->
            </div> <!-- list-group / end -->
  			</div> <!-- row / end -->
    </div>

<?php include('template/footer.php');?>
