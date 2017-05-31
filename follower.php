<?php
  // Page Parameters
  $page_config['css'] = array('history.css');
  $page_config['js'] = array('history.js');
  include('template/main.php');
  require('lib/db.connect.php');
  // Find the followee of the user
  $stmt = $db->prepare('SELECT `Followee` FROM `Follow` WHERE `Follower`=?');
  $stmt->bindValue(1,$_SESSION['user']);
  $stmt->execute();
  $result = $stmt->fetchAll();
?>
<div class="container">

<div class="box-content">
  <div class="box-head clearfix">
      <h1 class="pull-left">You are following</h1> <!--name from database-->
  </div>
  <br>
    <div class="table-container">
      <?php if($result): ?>
        <table id="products_buying" class="table table-hover">
          <thead>
            <tr>
              <th>Profile Picture</th>
              <th>Nickname</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($result as $item): ?>
            <?php
              // Fetching user information
              $user = user_info($item['Followee']);
              $nickname = $user['Nickname'];
              $email = $user['Email'];
              // Generate seed required for finding user avatar
              $seed = md5(strtolower(trim($email)));
            ?>
            <tr class="clickable-row" data-href="profile.php?id=<?php echo $item['Followee'] ?>">
              <td>
                <img src="//www.gravatar.com/avatar/<?php echo $seed ?>?s=200" alt="" class="img-circle" style="height: 5em;width: 5em;">
              </td>
              <td>
                <!-- Show the nickname of the followee -->
                <?php echo $nickname ?>
              </td>
            </tr>
          <?php endforeach; ?>
      <?php else: ?>
        <h3>You have not followed anyone.</h3>
          </tbody>
        </table>
       <?php endif; ?>

    </div>
  </div>
</div>

<?php include('template/footer.php');?>
