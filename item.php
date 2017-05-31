<?php
  require_once('lib/db.connect.php');
  $output['cm'] = false;

  if(isset($_POST['comment'])){
    // Insert comment
    $sql_cm = "INSERT INTO Comment (User, Book, Content) VALUES (:myid, :bid, :cm);";
    $stmt_cm = $db->prepare($sql_cm);
    $stmt_cm->bindValue(':myid',$_POST['myid'],PDO::PARAM_INT);
    $stmt_cm->bindValue(':bid',$_POST['bookid'],PDO::PARAM_INT);
    $stmt_cm->bindValue(':cm',$_POST['comment'],PDO::PARAM_STR);
    $stmt_cm->execute();
    $output['cm'] = true;

    // Insert noti
    $sql_noti = "INSERT INTO Noti (FromUser, ToUser, Book, Type)
                  VALUES (:myid,:ownerid,:bid,'C');";
    $stmt_noti = $db->prepare($sql_noti);
    $stmt_noti->bindValue(':myid',$_POST['myid'],PDO::PARAM_INT);
    $stmt_noti->bindValue(':ownerid',$_POST['ownerid'],PDO::PARAM_INT);
    $stmt_noti->bindValue(':bid',$_POST['bookid'],PDO::PARAM_INT);
    $stmt_noti->execute();

    // Refresh
    header("Location: item.php?bid=".$_POST['bookid']);
    exit();
  }

  if(isset($_GET['bid'])){
    $stmt = $db->prepare('SELECT * FROM `Book` WHERE `Bid`=?');
    $stmt->bindValue(1,$_GET['bid']);
    $stmt->execute();
    $result=$stmt->fetch();
    if(!$result) {
      header('Location: error.php');
    }
  } else {
    header('Location: error.php');
  }

  $page_config['css'] = array('//cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css','/lib/jquery-bar-rating/themes/bootstrap-stars.css','grading.css','item.css');
  $page_config['js'] = array('//cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js', '/lib/jquery-bar-rating/jquery.barrating.min.js','item.js','grading.js');
  include('template/main.php');
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



  $seller_name=user_info($result['Seller'])['Nickname'];

  #click rate
  $stmt3 = $db->prepare('SELECT `ISBN` FROM `ClickRate` WHERE `ISBN`=?');
  $stmt3->bindValue(1,$result['ISBN']);
  $stmt3->execute();
  $isbn = $stmt3->fetch();
  if(!$isbn){
    $stmt4 = $db->prepare('INSERT INTO `ClickRate` VALUES (?,1)');
    $stmt4->bindValue(1,$result['ISBN']);
    $stmt4->execute();
  }else{
    $add = $db->prepare('UPDATE `ClickRate` SET rate = rate + 1 WHERE `ISBN` = ?');
    $add->bindValue(1,$result['ISBN']);
    $add->execute();
  }

  #comment
  $stmt_cm = $db->prepare('SELECT Cmid, User, U.Nickname AS nickname, Content, CmTime FROM Comment JOIN User U ON (User = U.Uid) WHERE Book = ?');
  $stmt_cm->bindValue(1,$_GET['bid']);
  $stmt_cm->execute();
  $comments = $stmt_cm->fetchAll();
  $cm_cnt = $stmt_cm->rowCount();
  $cm_cur = 1;
?>
<div class="container">
  <div class="box-head clearfix">
      <h1 class="pull-left">(#<?php echo $result['Bid']; ?>) <?php echo $result['Bname']; ?></h1> <!--name from database-->
  </div>
  <br>
  <div class="col col-md-5">
      <img src="book_cover.php?id=<?php echo $result["Bid"]?>&nopadding" class="img-rounded" alt="book_cover" >  <!--Image field-->
  </div>
  <div class="col col-md-7">
    <table id="advance_search" class="table is-datatable dataTable">
      <tbody>
        <tr>
          <td><strong>Author</strong></td>
          <td><a href="category_page.php?by=Author&q=<?php echo str_replace(" ","+",$result['Author']); ?>"><?php echo $result['Author']; ?></a></td>
        </tr>
        <tr>
          <td><strong>Seller</strong></td>
          <td><a href="profile.php?id=<?php echo $result['Seller']; ?>"><?php echo $seller_name; ?></a></td>
        </tr>
        <tr>
          <td><strong>Price</strong></td>
          <td>HKD $<?php echo $result['Price'] ?></td>
        </tr>
        <tr>
        <?php
            $stmt = $db->prepare("SELECT * FROM `Hashtag` WHERE Book=?");
            $stmt->BindValue(1, $result["Bid"]);
            $stmt->execute();
            $hashtags = $stmt->fetchAll();
          ?>
          <?php if ($hashtags):?>
          <td><strong>Hash Tag</strong></td>
          <td>
            <?php foreach ($hashtags as $hashtag):?>
            <a href="hashtag.php?tag=<?php echo $hashtag["Tag"] ?>">#<?php echo $hashtag["Tag"] ?></a>
            <?php endforeach; ?>
          </td>
         <?php endif;?>
        </tr>
        <tr>
          <td><strong>Description</strong></td>
          <td><?php echo $result['Description']?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="container">
  <div class="modal-footer">
    <?php if ($result['Seller'] == $_SESSION['user']): ?>

      <?php switch ($result['Status']): ?><?php case 'r': ?><?php case 'c': ?>
        <select class="rating" data-current-rating="<?php echo grade($result['Bid'], $_SESSION['user'])?>">
          <option value=""></option>
          <?php for ($i = 1; $i <= 5; $i++): ?>
          <option value="<?php echo $i ?>"><?php echo $result['Bid'] ?>,<?php echo $result['Buyer']?></option>
          <?php endfor; ?>
        </select>
        <?php break; ?>

        <?php case 'a': ?>
          <?php if ($result['Buyer'] != NULL): ?>
            <a href="profile.php?id=<?php echo $result['Buyer'] ?>"><?php echo user_info($result['Buyer'])['Nickname'] ?></a> wants to buy this book... 
            <button type="button" data-id="<?php echo $result['Bid'] ?>" data-action="approve_buyer" class="btn btn-success trade">Approve</button>
            <button type="button" data-id="<?php echo $result['Bid'] ?>" data-action="decline_buyer" class="btn btn-warning trade">Decline</button>
          <?php endif; ?>
          <button type="button" data-id="<?php echo $result['Bid'] ?>" data-action="delete" class="btn btn-danger trade">Delete</button>
          <?php break; ?>

        <?php case 'u': ?>
          <button type="button" data-id="<?php echo $result['Bid'] ?>" data-action="complete" class="btn btn-primary trade">Transaction Complete</button>
        <?php break; ?>

        <?php endswitch; ?>

    <?php elseif ($result['Buyer'] == $_SESSION['user']): ?>
      <?php switch ($result['Status']): ?><?php case 'r': ?><?php case 'c': ?>
        <select class="rating" data-current-rating="<?php echo grade($result['Bid'], $_SESSION['user'])?>">
          <option value=""></option>
          <?php for ($i = 1; $i <= 5; $i++): ?>
          <option value="<?php echo $i ?>"><?php echo $result['Bid'] ?>,<?php echo $result['Seller']?></option>
          <?php endfor; ?>
        </select>
      <?php break ?>

        <?php case 'a': ?>
          <button type="button" data-action="retreat" data-id="<?php echo $result['Bid'] ?>" class="btn btn-warning trade">Retreat</button>
        <?php break ?>

        <?php case 'u': ?>
          <button type="button" data-action="complete" data-id="<?php echo $result['Bid'] ?>" class="btn btn-primary trade">Transaction Complete</button>
        <?php break ?>
      <?php endswitch; ?>

    <?php else: ?>
      <?php if ($result['Status'] == 'a' && $result['Buyer'] === NULL): ?>
          <button type="button" data-action="buy" data-id="<?php echo $result['Bid'] ?>" class="btn btn-primary trade">Buy</button>
      <?php else: ?>
      <button type="button" class="btn btn-primary" disabled>Bought</button> <!--Notification send to buyer if press BUY-->
      <?php endif; ?>

  <?php endif; ?>


  </div>
</div>
<br>


<div class="container">
  <div class="box">
    <div class="box-head clearfix">
        <h1 class="pull-left">Other Photo</h1>
    </div>
    <br>
    <div class="box-content">
      <div class='list-group gallery'>
        <!--Fetch data and use for loop to generate the following-->
        <?php
          $arr = explode(',',$result['filename'],5);
          if(count($arr) > 1):
            for($i = 1; $i < count($arr); $i++):?>
              <div class="col-sm-6 col-xs-6 col-md-3">
              <a data-fancybox="gallery" class="test" href="book_cover.php?id=<?php echo $result['Bid'] ?>&photo_id=<?php echo $i ?>&nopadding&type=.jpg" target="_blank">
                <img class="img-responsive" alt="" src="book_cover.php?id=<?php echo $result['Bid'] ?>&photo_id=<?php echo $i ?>" />
              </a>
              </div>
              <?php endfor; ?>
            <?php endif; ?>
        </div> <!-- col-6 / end -->
      </div> <!-- row / end -->
    </div>
  </div>
</div>

<br>
<div class="container">
  <div class="box">
    <div class="box-head clearfix">
        <h1 class="pull-left">Other similar items</h1>
    </div>
    <br>
    <div class="box-content">
      <div class='list-group gallery'>
        <?php
          $stmt = $db->prepare('SELECT * FROM `Book` WHERE `Category`=? AND `Bid`<>? ORDER BY `PostTime` DESC LIMIT 4');
          $stmt->bindValue(1,$result['Category']);
          $stmt->bindValue(2,$_GET['bid']);
          $stmt->execute();
          $similar = $stmt->fetchAll();
          if($similar):
            foreach($similar as $item): ?>
              <?php if (sizeof($similar) == 1): ?>
                <div class="col-sm-6 col-xs-6 col-md-6">
              <?php else: ?>
                <div class="col-sm-6 col-xs-12 col-md-3">
              <?php endif; ?>
              <a rel="ligthbox" href="item.php?bid=<?php echo $item['Bid'] ?>">
              <img class="img-responsive" alt="" src="book_cover.php?id=<?php echo $item['Bid'] ?>" />
              <small class="text-muted"><?php echo $item['Bname'] ?></small>
              </a></div>
            <?php endforeach; ?>
          <?php else: ?>
            <h3>No similar items.</h3>
          <?php endif; ?>
  </div>
</div>
</div>
</div>

<div class="container">
  <h2>Comments</h2>
  <div class="well">
    <div id="show-question" class="clearfix">
      <ul id="faq_list" class="faq-wrap-1 faq_list clearfix">
      <?php
        foreach ($comments as $cm) {
          echo '<li>';
          echo '<div class="clearfix">';
          echo '<div class="list_content">';
          echo '<strong><a href="profile.php?id='.$cm['User'].'">'.$cm['nickname'].'</a>:</strong> ';
          echo $cm['Content'];
          echo '<div class="fn-area">';
          echo '<span class="data_time">'.$cm['CmTime'].'</span>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</li>';
          echo '<hr />';
          $cm_cur++;
        }
      ?>

      <!--
      <li>
      <div class="clearfix">
        <div class="list_content">
          Do you think the book is good to read?
          <div class="fn-area">
            <span class="user_link">Joker</span>
            <span class="data_time">06-10 15:05</span>
          </div>
        </div>
      </div>
      </li>
      -->

      <!--<hr>-->
      <!--
      <li>
      <div class="clearfix">
        <div class="list_content">
          Very Good.
          <div class="fn-area">
            <span class="user_link">Ronald</span>
            <span class="data_time">06-10 15:05</span>
          </div>
        </div>
      </div>
      </li>
      -->
      </ul>
    </div>
    <div id="leave_cm">
      <form action="item.php" method="post">
        <div class="form-group">
          <label for="comment" class="control-label">Your comments</label>
          <input type="text" class="form-control" name="comment"></textarea>
        </div>
        <div class="form-group">
          <input type="hidden" name="myid" value="<?php echo $_SESSION['user']; ?>" />
          <input type="hidden" name="ownerid", value="<?php echo $result['Seller']; ?>" />
          <input type="hidden" name="bookid" value="<?php echo $_GET['bid']; ?>" />
          <button name="submit_cm" type="submit" class="btn btn-primary" id="submit_cm">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>


<?php include('template/footer.php');?>
