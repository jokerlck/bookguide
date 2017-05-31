<?php
  if (session_status() == PHP_SESSION_NONE)
    session_start();
  if (!isset($_SESSION['user'])){
    header("Location: sign_in.php?error=2");
  }
  require('lib/db.connect.php');
  require('lib/user_info.php');
?>
<script>
  // for fetching unseen msg and noti in main.js
  var myid = <?php echo $_SESSION['user']; ?>
</script>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php if (isset($page_config['title'])) echo $page_config['title'].' - '?>Bookguide</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Custom Fonts -->
  <link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href="//fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <link href="//fonts.googleapis.com/css?family=Jim+Nightshade" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!--Style-->

  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <?php if (isset($page_config['css'])):?>
    <?php if (!is_array($page_config['css'])) $page_config['css'] = array($page_config['css'])?>
      <?php foreach ($page_config['css'] as $css_file):?>
        <?php if (file_exists("css/".$css_file)) $css_file = "css/".$css_file?>
  <link rel="stylesheet" type="text/css" href="<?php echo $css_file ?>" />
      <?php endforeach;?>
  <?php endif;?>

</head>

<body data-target="#navbar-spy" data-spy="scroll">
  <!--navbar start-->
  <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bottom-bar" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php"><span class="glyphicon glyphicon-book" aria-hidden="true"></span></a>
    </div>
    <!--bottombar-->
    <div class="collapse navbar-collapse" id="bottom-bar">
        <ul class="nav navbar-nav navbar-right">
            <li id="advance_search"><a href="advanced_search.php">Advanced Search</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="myAc">Hello, <?php echo $_USER['Nickname']; ?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="upload.php"><span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> Upload Item</a></li>
                  <li><a href="msg.php"><span class="glyphicon glyphicon glyphicon-envelope" aria-hidden="true"></span> Message<span id="unseen_msg" class="label label-default" style="float:right"></span></a></li>
                  <li><a href="follower.php"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Following</a></li>
                  <li><a href="shopping_cart.php"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Trade</a></li>
                  <li><a href="history.php"><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span> History</a></li>
                  <li><a href="noti.php"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> Notification<span id="unseen_noti" class="label label-default" style="float:right"></span></a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="ac_manage.php"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Setting</a></li>
                  <li><a href="logout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Sign Out</a></li>
                </ul>
            </li>
        </ul>
    </div><!--bottombar end-->
    <!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
  <div class="CoverImage FlexEmbed FlexEmbed--3by1" style="background-image:url(&quot;../img/newbookCover.jpg&quot;)"></div>
  </nav>
