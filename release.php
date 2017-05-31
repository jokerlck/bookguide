<?php
      session_start();
      if (!isset($_SESSION['user'])){
      	header("Location: sign_in.php?error=2");
      }
      require('lib/db.connect.php');
      $stmt = $db->prepare('SELECT Book.Status,Book.Bid, Book.Bid,Book.Bname,Book.Author,concat(Category.chiName," ",Category.engName) as category,Book.ISBN,Book.Price,Book.Description,Book.PostTime,Book.filename,User.Nickname as Seller FROM Book
      LEFT JOIN Category ON Book.Category = Category.categoryID
      LEFT JOIN User ON User.Uid = Book.Seller
      WHERE Book.Status <> "c"
      order by PostTime DESC limit 20;');
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $formatedResult="";
      $json="";
      $data=array();
      if (count($result) > 0){
        $json=json_encode($result,JSON_UNESCAPED_UNICODE);
        $json='{"dataset":'.$json;
        $formatedResult.=$json;
        }
      else{
        echo("sorry");
      }
      $stmt = $db->prepare('SELECT Bid,User.nickname,Bname,filename FROM Follow left join Book on Book.seller=Followee left join User on Followee=User.Uid WHERE Follower='.$_SESSION['user'].' order by PostTime DESC;');
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $data=array();
      if (count($result) > 0){
        $json=json_encode($result,JSON_UNESCAPED_UNICODE);
        $formatedResult.=',"follow":';
        $formatedResult.=$json;
        }
        $formatedResult.='}';
        echo $formatedResult;
      $db=null;
?>
