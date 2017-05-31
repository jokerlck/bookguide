<?php
  $page_config['js'] = array('//ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js','//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js','noti.js');
  include('template/main.php');
  require_once('lib/db.connect.php');

  // First, delete notification if received action
  if (isset($_POST['del'])) {
    $sql_delnoti = "DELETE FROM Noti WHERE Nid=:id;";
    try {
      $stmt_delnoti = $db->prepare($sql_delnoti);
      $stmt_delnoti->bindValue(':id',$_POST['del']);
      $stmt_delnoti->execute();
    } catch(PDOException $e) {
      echo $e->getMessage();
    }
  }

  // Update all notifications to be seen, once entered this page
  $sql_seen = "UPDATE Noti SET Seen = 1 WHERE ToUser = :myid;";
  $stmt_seen = $db->prepare($sql_seen);
  $stmt_seen->bindValue(':myid',$_SESSION['user'],PDO::PARAM_INT);
  $stmt_seen->execute();

  // Get notifications
  try {
    $sql_noti = "
    SELECT Nid, FromUser, U.Nickname, Book, B.Bname, Type, NTime, Seen FROM Noti 
    JOIN User U ON FromUser = U.Uid LEFT JOIN Book B ON Book = B.Bid
    WHERE ToUser = :myid ORDER BY NTime DESC;";
    $stmt_noti = $db->prepare($sql_noti);
    $stmt_noti->bindValue(':myid',$_SESSION['user'],PDO::PARAM_INT);
    $stmt_noti->execute();
    $resultSet = $stmt_noti->fetchAll();
  } catch(PDOException $e) {
    echo $e->getMessage();
  }

  /*    *************************************************************
   *
   *    MODULE TO WRITE NOTIFICATIONS
   *  
   *    Input parameters:
   *    -   $type: type of notifications
   *        -   F: Start following
   *        -   C: Comment on book the user sells
   *        -   S: Approve book request the user gives (NOT implemented yet)
   *        -   G: Grade book transaction (NOT implemented yet)
   *        -   B: Receive a book transaction request (NOT implemented yet)
   *
   *    Output: Entire notification content
   *
   *  *************************************************************/
  function writeDesc($type, $user, $userid, $book, $bookid) {
    switch($type) {
      case 'F':
        echo '<a href="profile.php?id='.$userid.'"><strong>'.$user.'</strong></a> starts following you.';
        break;
      case 'C':
        echo '<a href="profile.php?id='.$userid.'"><strong>'.$user.'</strong></a> commented on your book <a href="item.php?bid='.$bookid.'"><strong>'.$book.'</strong></a>.';
        break;
      case 'S':
        echo '<a href="profile.php?id='.$userid.'"><strong>'.$user.'</strong></a> approved your request for <a href="shopping_cart.php#'.$bookid.'"><strong>'.$book.'</strong></a>.';
        break;
      case 'G':
        echo '<a href="profile.php?id='.$userid.'"><strong>'.$user.'</strong></a> has graded your transaction for <a href="item.php?bid='.$bookid.'"><strong>'.$book.'</strong></a>.';
        break;
      case 'B':
        echo '<a href="profile.php?id='.$userid.'"><strong>'.$user.'</strong></a> wants to buy your book <a href="item.php?bid='.$bookid.'"><strong>'.$book.'</strong></a>.';
        break;
    }
  }
?>

<div class="container">
  <div class="content-body">
    <div class="box">
      <div class="col-lg-12 col-sm-12 main-box-container">
        <div class="box-head clearfix">
            <h1 class="pull-left">Notification</h1>
        </div>
        <br>
        <div class="box-content">
            <div class="table-container">
                <table id="notification" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Time</th>
                            <th>Dismiss</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // Display all kept notifications in table form
                        foreach ($resultSet as $result) {
                            echo '<tr>';
                            echo '<td>';
                            writeDesc($result['Type'], $result['Nickname'], $result['FromUser'], $result['Bname'], $result['Book']);
                            echo '</td>';
                            echo '<td>';
                            echo '<span class="time">'.$result['NTime'].'</span>';
                            echo '</td>';
                            echo '<td><a href="#" id="'.$result['Nid'].'" class="del glyphicon glyphicon-remove"></a></td>';
                      }
                       ?>
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('template/footer.php');?>
