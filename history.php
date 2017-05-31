<?php
  // Page parameters
  $page_config['title'] = 'History';
  $page_config['css'] = array('grading.css','/lib/jquery-bar-rating/themes/bootstrap-stars.css', 'history.css');
  $page_config['js'] = array('/lib/jquery-bar-rating/jquery.barrating.min.js','grading.js', 'history.js');
  include('template/main.php');
  // Get grade the user graded to the opponent of a specified transaction
  function grade($id, $from){
    global $db;
    $stmt = $db->prepare("SELECT * FROM `Grade` WHERE `fromUser`=? AND `itemID`=?");
    $stmt->BindValue(1, $from);
    $stmt->BindValue(2, $id);
    $stmt->execute();
    $result = $stmt->fetch();
    if ($result){
      $result = $result['grade'];
    } else {
      $result = 0;
    }
    return $result;
  }
?>

<div class="container">
  <div class="content-body">
    <div class="col-lg-12 col-sm-12 main-box-container">
      <div class="box-head clearfix">
          <h1 class="pull-left">Buying History</h1>
      </div>
      <br>
      <div class="box-content">
          <div class="table-container">
              <table id="products_buying" class="table table-hover">
                  <thead>
                      <tr>
                          <th>Book Name</th>
                          <th>Photo</th>
                          <th>Price</th>
                          <th>Seller</th>
                          <th>Grade</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      $stmt = $db->prepare('SELECT `Bid`, `Bname`, `filename`, `Price`, `Seller` FROM `Book` WHERE `Buyer`=? AND `Status`= ?');
                      $stmt->bindValue(1, $_SESSION['user']);
                      $stmt->bindValue(2, 'c');
                      $stmt->execute();
                      $buy = $stmt->fetchAll();
                      if($buy):
                        // Info of each bought/buying item
                        foreach($buy as $item): ?>
                          <tr class="clickable-row" data-href="item.php?bid=<?php echo $item['Bid'] ?>"><td><?php echo $item['Bname'] ?></td>
                          <td><img class="book-thumbnail" src="book_cover.php?id=<?php echo $item['Bid'] ?>&nopadding"></td>
                          <td><?php echo $item['Price'] ?></td>
                          <td><a href="profile.php?id=<?php echo $item['Seller']?>"><?php echo user_info($item['Seller'])['Nickname'] ?></a></td>
                          <td><select class="rating" data-current-rating="<?php echo grade($item['Bid'], $_SESSION['user'])?>">
                            <option value=""></option>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?php echo $i ?>"><?php echo $item['Bid'] ?>,<?php echo $item['Seller']?></option>
                            <?php endfor; ?>
                          </select></td></tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <td>No related Record.</td>';
                      <?php endif; ?>
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="content-body">
    <div class="col-lg-12 col-sm-12 main-box-container">
      <div class="box-head clearfix">
          <h1 class="pull-left">Selling History</h1>
      </div>
      <br>
      <div class="box-content">
          <div class="table-container">
            <table id="products_selling" class="table table-hover">
                <thead>
                    <tr>
                        <th>Book Name</th>
                        <th>Photo</th>
                        <th>Price</th>
                        <th>Buyer</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                    $stmt = $db->prepare('SELECT `Bid`, `Bname`, `filename`, `Price`, `Buyer` FROM `Book` WHERE `Seller`=? AND `Status`= ?');
                    $stmt->bindValue(1, $_SESSION['user']);
                    $stmt->bindValue(2, 'c');
                    $stmt->execute();
                    $sell = $stmt->fetchAll();
                    if($sell):
                      // Info of each sold/selling item
                      foreach($sell as $item):?>
                        <tr class="clickable-row" data-href="item.php?bid=<?php echo $item['Bid'] ?>"><td><?php echo $item['Bname'] ?></td>
                        <td><img class="book-thumbnail" src="book_cover.php?id=<?php echo $item['Bid'] ?>&nopadding"></td>
                        <td><?php echo $item['Price'] ?></td>
                          <td><a href="profile.php?id=<?php echo $item['Buyer']?>"><?php echo user_info($item['Buyer'])['Nickname'] ?></a></td>
                          <td><select class="rating" data-current-rating="<?php echo grade($item['Bid'], $_SESSION['user'])?>">
                        <option value=""></option>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?php echo $i ?>"><?php echo $item['Bid'] ?>,<?php echo $item['Buyer']?></option>
                        <?php endfor; ?>
                      </select></td></tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <td>No related Record.</td>
                    <?php endif; ?>
              </tbody>
            </table>
          </div>
      </div>
    </div>
  </div>
</div>


<?php include('template/footer.php');?>
