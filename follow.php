<?php
  // Follow a user
  $stmt = $db->prepare('INSERT INTO `Follow` VALUES (?,?)');
  $stmt->bindValue(1, $_SESSION['user']);
  $stmt->bindValue(2, $uid);
  $stmt->execute();

  // Insert new notification entry
  $stmt = $db->prepare("INSERT INTO Noti (ToUser, FromUser, Type) VALUES (?, ?, 'F')");
  $stmt->BindValue(1, $_SESSION['user']);
  $stmt->BindValue(2, $uid);

  $stmt->execute();

  header('Location: profile.php?id='.$uid);
?>
