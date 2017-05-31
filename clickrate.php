<?php
  require('lib/db.connect.php');
  // Find ISBN from book id
  $stmt = $db->prepare('SELECT `ISBN` FROM `Book` WHERE Bid=?');
  $stmt->bindValue(1, $_GET['bid']);
  $stmt->execute();
  $isbn = $stmt->fetch();

  // Find Click Rate entry from ISBN
  $stmt = $db->prepare('SELECT `ISBN` FROM `ClickRate` WHERE ISBN=?');
  $stmt->bindValue(1, $isbn);
  $stmt->execute();
  $result = $stmt->fetchAll();
  if(!$result){ 
    // ISBN not exist, then insert new Click Rate Entry
    $stmt = $db->prepare('INSERT INTO `ClickRate` VALUES(?,0)');
    $stmt->bindValue(1, $isbn);
    $stmt->execute();
  }

  // Update Click Rate
  $stmt = $db->prepare('UPDATE `ClickRate` SET rate = rate + 1');
  $stmt->execute();
?>
