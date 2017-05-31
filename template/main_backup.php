<?php
  session_start();
  if (!isset($_SESSION['user'])){
    header("Location: sign_in.php?error=2");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Custom Fonts -->
  <link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href="//fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <link href="//fonts.googleapis.com/css?family=Jim+Nightshade" rel="stylesheet">
  <!-- Javascript -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!--Style-->
  <style type="text/css">
body{background-color: #D8D8D8 ;}
/*icon setting*/
.glyphicon-book {color:#fff;}
/*navbar setting*/
.navbar-inverse {border-radius: 0px;}
/*topbar search setting*/
#topbar-search {text-align: center;}
#topbar-search, .form-control, #searchBtn{min-width: 30em;}
.grey{color:#000;}
/*SearchBy Button, Dropdown-menu,SearchButton setting*/
.dropdown-menu,.btn-inverse, #searchBy {border-radius: 0px;}
/*cover photo setting*/
.FlexEmbed {overflow: hidden;}
.FlexEmbed:before {content: "";display: block;}
.FlexEmbed--3by1:before {padding-bottom: 25%;}
.CoverImage {background-position: 100%;background-size: cover;}
/*category dropdown menu open at right side only when website mode*/
@media only screen and (min-width : 768px){
  #category-dropdown {top:0;left:100%;}
/*when mouse hover, menu dropdown*/
  .dropdown:hover .dropdown-menu {display: block;margin-top: 0;}
  .nav .dropdown-menu li a:hover,.input-group-btn .dropdown-menu li a:hover,.nav .dropdown a:hover{
      background-repeat: repeat-x;
      background-image: -khtml-gradient(linear, left top, left bottom, from(#292929), to(#191919));
      background-image: -moz-linear-gradient(top, #292929, #191919);
      background-image: -ms-linear-gradient(top, #292929, #191919);
      background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #292929), color-stop(100%, #191919));
      background-image: -webkit-linear-gradient(top, #292929, #191919);
      background-image: -o-linear-gradient(top, #292929, #191919);
      background-image: linear-gradient(top, #292929, #191919);
      filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#292929', endColorstr='#191919', GradientType=0);
      color: #fff;
      border-radius: 0px;
  }
}
/*"SearchBy,MyAccount"dropdown menu color setting*/
@media only screen and (max-width : 768px){
  #myAc:hover {}
}

/*shadow box of categories*/
.navbar-vertical {box-shadow:0.1em 0.1em 0.3em;}
/*color of categories*/
.nav-stacked {background-color: #B8B8B8;}
#c-drop {background-color: #fff;}
.nav-stacked .dropdown-toggle{color: #000; font-size: 0.8em;}
/*font setting of categories*/
.text-uppercase{text-align: center;font-family: 'Jim Nightshade', cursive;font-size: 1.6em;}
#category-dropdown>li{font-size: 0.8em;}
/*category dropdown padding setting*/
#category-dropdown{padding:0px;}
/*font of whole page*/
li{font-family: 'Raleway', sans-serif;}
/*top rating book detail setting*/
img[alt="Sample Product"]{max-height:8em; max-width: 4em;float:left;}
.product-details{padding-bottom: 5.5em;}
ul#topRating{list-style: none}
.widget li{padding-bottom: 1em; padding-left: 0em;}
.product-name,.price{padding-left: 3em; float:right;}
.product-name a{color: #000;}
.gallery
{
    display: inline-block;
    margin-top: 20px;
}
img {
    width: 100%;
    height: auto;
}
/*====================for message====================*/
.bg-white {
  background-color: #fff;
}

.friend-list {
  list-style: none;
  margin-left: -40px;
}

.friend-list li {
  border-bottom: 1px solid #eee;
}

.friend-list li a img {
  float: left;
  width: 45px;
  height: 45px;
  margin-right: 2em;
}

 .friend-list li a {
  position: relative;
  display: block;
  padding: 10px;
  transition: all .2s ease;
  -webkit-transition: all .2s ease;
  -moz-transition: all .2s ease;
  -ms-transition: all .2s ease;
  -o-transition: all .2s ease;
}

.friend-list li.active a {
  background-color: #f1f5fc;
}

.friend-list li a .friend-name,
.friend-list li a .friend-name:hover {
  color: #777;
}

.friend-list li a .last-message {
  width: 65%;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
}

.friend-list li a .time {
  position: absolute;
  top: 10px;
  right: 8px;
}

small, .small {
  font-size: 85%;
}

.friend-list li a .chat-alert {
  position: absolute;
  right: 8px;
  top: 27px;
  font-size: 10px;
  padding: 3px 5px;
}

.chat-message {
  padding: 20px;
}

.chat {
    list-style: none;
    margin: 0;
}

.chat-message{
    background: #f9f9f9;
}

.chat li img {
  width: 45px;
  height: 45px;
  border-radius: 50em;
  -moz-border-radius: 50em;
  -webkit-border-radius: 50em;
}

img {
  max-width: 100%;
}

.chat-body {
  padding-bottom: 20px;
}

.chat li.left .chat-body {
  margin-left: 70px;
  background-color: #fff;
}

.chat li .chat-body {
  position: relative;
  font-size: 11px;
  padding: 10px;
  border: 1px solid #f1f5fc;
  box-shadow: 0 1px 1px rgba(0,0,0,.05);
  -moz-box-shadow: 0 1px 1px rgba(0,0,0,.05);
  -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
}

.chat li .chat-body .header {
  padding-bottom: 5px;
  border-bottom: 1px solid #f1f5fc;
}

.chat li .chat-body p {
  margin: 0;
}

.chat li.left .chat-body:before {
  position: absolute;
  top: 10px;
  left: -8px;
  display: inline-block;
  background: #fff;
  width: 16px;
  height: 16px;
  border-top: 1px solid #f1f5fc;
  border-left: 1px solid #f1f5fc;
  content: '';
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  -o-transform: rotate(-45deg);
}

.chat li.right .chat-body:before {
  position: absolute;
  top: 10px;
  right: -8px;
  display: inline-block;
  background: #fff;
  width: 16px;
  height: 16px;
  border-top: 1px solid #f1f5fc;
  border-right: 1px solid #f1f5fc;
  content: '';
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
}

.chat li {
  margin: 15px 0;
}

.chat li.right .chat-body {
  margin-right: 70px;
  background-color: #fff;
}

.chat-box {
  bottom: 3em;
  padding: 15px;
  border-top: 1px solid #eee;
  transition: all .5s ease;
}

.primary-font {
  color: #3c8dbc;
}

a:hover, a:active, a:focus {
  text-decoration: none;
  outline: 0;
}
/*====================for message end====================*/
/*====================ac_manage====================*/
#wrapper {
    padding-left: 0;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

#wrapper.toggled {
    padding-left: 250px;
}


#page-content-wrapper {
    width: 100%;
    position: absolute;
    padding: 15px;
}

#wrapper.toggled #page-content-wrapper {
    position: absolute;
    margin-right: -250px;
}

.hamburger {
    position: relative;
    top: 1px;
    display: inline-block;
    font-family: 'Glyphicons Halflings';
    font-style: normal;
    font-weight: 400;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
}

@media(min-width:768px) {
    #wrapper {
        padding-left: 250px;
    }

    #wrapper.toggled {
        padding-left: 0;
    }

    #sidebar-wrapper {
        width: 250px;
    }

    #wrapper.toggled #sidebar-wrapper {
        width: 0;
    }

    #page-content-wrapper {
        padding: 20px;
        position: relative;
    }

    #wrapper.toggled #page-content-wrapper {
        position: relative;
        margin-right: 0;
    }
}


@import url(https://fonts.googleapis.com/css?family=Montserrat:400,700);html{background-color:#f2f4f7}html body{font-family:Montserrat,sans-serif;color:#727272}html body #wrapper #sidebar-wrapper{background-color:#222d30}html body #wrapper #sidebar-wrapper .sidebar-nav .sidebar-brand{padding:20px;margin-bottom:10px;background-color:#55a4d3;text-transform:uppercase;text-align:center}html body #wrapper #sidebar-wrapper .sidebar-nav .sidebar-brand a{color:#fff;font-weight:700;font-size:16px}html body #wrapper #sidebar-wrapper .sidebar-nav .panel{border-radius:0;background-color:transparent;margin-bottom:0;border:none}html body #wrapper #sidebar-wrapper .sidebar-nav .panel:last-child>a{border-bottom:1px solid #283537}html body #wrapper #sidebar-wrapper .sidebar-nav .panel>a{color:#fff;position:relative;text-transform:uppercase;font-size:13px;padding:16px 0 16px 53px;border-top:1px solid #283537;border-right:3px solid #222d30}html body #wrapper #sidebar-wrapper .sidebar-nav .panel>a.active{border-right-color:#55a4d3}html body #wrapper #sidebar-wrapper .sidebar-nav .panel>a.collapsed{color:#a7abac}html body #wrapper #sidebar-wrapper .sidebar-nav .panel>a.collapsed:hover{color:#fff}html body #wrapper #sidebar-wrapper .sidebar-nav .panel>a.collapsed .arrow:before{content:"\e258"}html body #wrapper #sidebar-wrapper .sidebar-nav .panel>a .arrow{position:absolute;right:0;margin-top:20px;font-size:11px;margin-right:18px}html body #wrapper #sidebar-wrapper .sidebar-nav .panel>a .arrow:before{content:"\e259"}html body #wrapper #sidebar-wrapper .sidebar-nav .panel ul{list-style-type:none}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.dashboard>a{background:url(../images/ico_dashboard_on.png) 20px 18px no-repeat}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.dashboard>a.collapsed{background:url(../images/ico_dashboard.png) 20px 18px no-repeat}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.dashboard>a.collapsed:hover{background-image:url(../images/ico_dashboard_on.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.transactions>a{background:url(../images/ico_transactions_on.png) 20px 16px no-repeat}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.transactions>a.collapsed{background-image:url(../images/ico_transactions.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.transactions>a.collapsed:hover{background-image:url(../images/ico_transactions_on.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.inv>a{background:url(../images/ico_inventories_on.png) 20px 16px no-repeat}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.inv>a.collapsed{background-image:url(../images/ico_inventories.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.inv>a.collapsed:hover{background-image:url(../images/ico_inventories_on.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.hid>a{background:url(../images/ico_transactions_on.png) 20px 16px no-repeat}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.hid>a.collapsed{background-image:url(../images/ico_transactions.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.hid>a.collapsed:hover{background-image:url(../images/ico_transactions_on.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.settings>a{background:url(../images/ico_settings_on.png) 20px 16px no-repeat}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.settings>a.collapsed{background-image:url(../images/ico_settings.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.settings>a.collapsed:hover{background-image:url(../images/ico_settings_on.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel ul li a{color:#a7abac;margin:20px 0 20px 15px}html body #wrapper #sidebar-wrapper .sidebar-nav .panel ul li a:hover,html body #wrapper #sidebar-wrapper .sidebar-nav .panel ul li a.active{color:#fff}html body #wrapper #page-content-wrapper{background-color:#f2f4f7;padding:0}html body #wrapper #page-content-wrapper #topbar{background-color:#fff;padding:17px 20px;border-bottom:1px solid #eaeaea}html body #wrapper #page-content-wrapper #topbar a#menu-toggle{color:#666;font-size:25px}html body #wrapper #page-content-wrapper #topbar a#menu-toggle:hover,html body #wrapper #page-content-wrapper #topbar a#menu-toggle:focus,html body #wrapper #page-content-wrapper #topbar a#menu-toggle:active{text-decoration:none}html body #wrapper #page-content-wrapper #main-content{padding:20px 5px}html body #wrapper #page-content-wrapper #main-content .box-row .box:first-child{margin-left:0}html body #wrapper #page-content-wrapper #main-content .box-row .box:last-child{margin-right:0}html body #wrapper #page-content-wrapper #main-content .box{background-color:#fff;margin-top:20px;border:1px solid #eaeaea;border-top:3px solid #909090;min-height:237px}html body #wrapper #page-content-wrapper #main-content .box .box-head{padding:19px}html body #wrapper #page-content-wrapper #main-content .box .box-head .agg-data{text-align:right}html body #wrapper #page-content-wrapper #main-content .box .box-head .agg-data .title{font-size:13px;text-transform:uppercase}html body #wrapper #page-content-wrapper #main-content .box .box-head .agg-data .amount{font-size:16px}html body #wrapper #page-content-wrapper #main-content .box .box-head .agg-data .amount strong{font-size:25px}html body #wrapper #page-content-wrapper #main-content .box.inv{border-top-color:#55a4d3}html body #wrapper #page-content-wrapper #main-content .box.price{border-top-color:#e0d14f}html body #wrapper #page-content-wrapper #main-content .box.margin{border-top-color:#30a076}html body #wrapper #page-content-wrapper #main-content .box.sales{border-top-color:#454545}html body #wrapper #page-content-wrapper #main-content .main-box-container .box{margin-top:0;padding-top:0}html body #wrapper #page-content-wrapper #main-content .main-box-container .box .box-head{border-bottom:1px solid #eaeaea;padding:0}html body #wrapper #page-content-wrapper #main-content .main-box-container .box .box-head h1{font-size:16px;font-weight:400;padding:17px 0 0 20px}html body #wrapper #page-content-wrapper #main-content .main-box-container .box .box-head .actions{padding:5px 15px}html body #wrapper #page-content-wrapper #main-content .main-box-container .box .box-head .actions a{text-transform:uppercase;padding-left:20px;padding-right:20px}html body #wrapper #page-content-wrapper #main-content .main-box-container .box .box-content .table-container{margin:0;padding:20px}html body #wrapper #page-content-wrapper #main-content .main-box-container .box .box-content .table-container table tbody tr td{padding:10px!important}html body #wrapper #page-content-wrapper #main-content .sidebar-container{margin:0}html body #wrapper #page-content-wrapper #main-content .sidebar{margin:0}html body #wrapper #page-content-wrapper #main-content .sidebar .box-head{padding:0}html body #wrapper #page-content-wrapper #main-content .sidebar h3{font-size:15px;padding:20px;margin:0;border-bottom:1px solid #eaeaea}html body #wrapper #page-content-wrapper #main-content .sidebar .item{padding:10px 20px}html body #wrapper #page-content-wrapper #main-content .sidebar .item .type{font-size:12px;text-transform:uppercase;color:#909090}html body #wrapper #page-content-wrapper #main-content .sidebar .item .amount{font-size:16px}html body .table-container{padding-left:20px}html body .table-container .table-controls{margin-bottom:10px}html body .table-container .table-controls .table-actions .separator{display:inline-block;padding:0 7px;border-left:1px solid #eaeaea}html body .table-container .table-controls .table-actions a{display:inline-block;margin:5px 7px}html body .table-container .table-controls .table-actions a.btn-maximize{width:17px;height:17px;background:url(../images/ico3.png) no-repeat}html body .table-container .table-controls .table-actions a.btn-minimize{width:17px;height:17px;background:url(../images/ico2.png) no-repeat}html body .table-container .table-controls .table-actions a.btn-print{width:21px;height:17px;background:url(../images/ico_print.png) no-repeat}html body .table-container .table-controls .table-actions a.btn-edit{width:16px;height:17px;background:url(../images/ico_edit.png) no-repeat}html body .table-container .table-controls .table-actions a.btn-delete{width:14px;height:18px;background:url(../images/ico_delete.png) no-repeat}html body .table-container .table-controls .table-actions a.btn-popout{width:16px;height:16px;background:url(../images/ico1.png) no-repeat}html body table:not(.table-condensed){margin-bottom:0!important}html body table:not(.table-condensed).is-datatable tfoot{display:table-row-group!important}html body table:not(.table-condensed).dataTable td.select-checkbox:after{width:20px!important;height:20px!important;margin-top:-6px!important;margin-left:-5px!important}html body table:not(.table-condensed).dataTable td.select-checkbox:before{border:1px solid #e0e0e0;width:20px!important;height:20px!important}html body table:not(.table-condensed).data-table{margin-top:20px}html body table:not(.table-condensed).data-table tbody{margin-bottom:1px solid #eaeaea}html body table:not(.table-condensed).data-table tbody tr td{padding:10px 20px!important}html body table:not(.table-condensed).data-table thead tr th,html body table:not(.table-condensed).data-table tfoot tr th,html body table:not(.table-condensed).data-table thead tr td,html body table:not(.table-condensed).data-table tfoot tr td{padding:10px 20px}html body table:not(.table-condensed) thead tr th{border-bottom:none!important;border-top:1px solid #eaeaea!important;background-color:#f9f9f9}html body table:not(.table-condensed) thead tr th.number{text-align:right}html body table:not(.table-condensed) tbody{border-top-color:#fff!important}html body table:not(.table-condensed) tbody tr td{padding:20px!important;border-top:1px solid #eaeaea!important}html body table:not(.table-condensed) tbody tr td:last-child,html body table:not(.table-condensed) tbody tr td.number{text-align:right}html body table:not(.table-condensed) tbody tr td.row-title{text-transform:uppercase}html body table:not(.table-condensed) tfoot tr td{font-weight:700}html body table:not(.table-condensed) tfoot tr td.number{text-align:center;}html body .nav-tabs{border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;margin-top:10px}html body .nav-tabs li.active a{border-bottom:3px solid #55a4d3!important;color:#55a4d3!important}html body .nav-tabs li a{border:none!important;text-transform:uppercase;color:#727272;font-size:13px;margin-left:20px}html body .nav-tabs li a:hover{background-color:#fff}html body .modal .modal-dialog .modal-content{background-color:#f9f9f9}html body .modal .modal-dialog .modal-content .modal-header{color:#454545}html body .modal .modal-dialog .modal-content .modal-header .modal-title{padding-left:10px}html body .modal .modal-dialog .modal-content .modal-body .form-group label{text-transform:uppercase;font-weight:400;display:block;font-size:13px}html body .modal .modal-dialog .modal-content .modal-body .form-group label a{float:right;display:inline-block;padding-left:20px;color:#55a4d3;font-size:12px;background:url(../images/ico_plus.png) 0 0 no-repeat}html body .tab-content{padding:0 20px}html body h1{font-size:24px;font-weight:400;padding:0;margin:0}html body a.btn{background-color:#fcfcfc;border:1px solid #eaeaea;color:#666;padding:10px 15px}html body a.btn:hover{background-color:#666;color:#fcfcfc}

@import url(https://fonts.googleapis.com/css?family=Montserrat:400,700);html{background-color:#f2f4f7}html body{font-family:Montserrat,sans-serif;color:#727272}html body #wrapper #sidebar-wrapper{background-color:#222d30}html body #wrapper #sidebar-wrapper .sidebar-nav .sidebar-brand{padding:20px;margin-bottom:10px;background-color:#55a4d3;text-transform:uppercase;text-align:center}html body #wrapper #sidebar-wrapper .sidebar-nav .sidebar-brand a{color:#fff;font-weight:700;font-size:16px}html body #wrapper #sidebar-wrapper .sidebar-nav .panel{border-radius:0;background-color:transparent;margin-bottom:0;border:none}html body #wrapper #sidebar-wrapper .sidebar-nav .panel:last-child>a{border-bottom:1px solid #283537}html body #wrapper #sidebar-wrapper .sidebar-nav .panel>a{color:#fff;position:relative;text-transform:uppercase;font-size:13px;padding:16px 0 16px 53px;border-top:1px solid #283537;border-right:3px solid #222d30}html body #wrapper #sidebar-wrapper .sidebar-nav .panel>a.active{border-right-color:#55a4d3}html body #wrapper #sidebar-wrapper .sidebar-nav .panel>a.collapsed{color:#a7abac}html body #wrapper #sidebar-wrapper .sidebar-nav .panel>a.collapsed:hover{color:#fff}html body #wrapper #sidebar-wrapper .sidebar-nav .panel>a.collapsed .arrow:before{content:"\e258"}html body #wrapper #sidebar-wrapper .sidebar-nav .panel>a .arrow{position:absolute;right:0;margin-top:20px;font-size:11px;margin-right:18px}html body #wrapper #sidebar-wrapper .sidebar-nav .panel>a .arrow:before{content:"\e259"}html body #wrapper #sidebar-wrapper .sidebar-nav .panel ul{list-style-type:none}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.dashboard>a{background:url(../images/ico_dashboard_on.png) 20px 18px no-repeat}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.dashboard>a.collapsed{background:url(../images/ico_dashboard.png) 20px 18px no-repeat}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.dashboard>a.collapsed:hover{background-image:url(../images/ico_dashboard_on.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.transactions>a{background:url(../images/ico_transactions_on.png) 20px 16px no-repeat}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.transactions>a.collapsed{background-image:url(../images/ico_transactions.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.transactions>a.collapsed:hover{background-image:url(../images/ico_transactions_on.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.inv>a{background:url(../images/ico_inventories_on.png) 20px 16px no-repeat}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.inv>a.collapsed{background-image:url(../images/ico_inventories.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.inv>a.collapsed:hover{background-image:url(../images/ico_inventories_on.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.hid>a{background:url(../images/ico_transactions_on.png) 20px 16px no-repeat}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.hid>a.collapsed{background-image:url(../images/ico_transactions.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.hid>a.collapsed:hover{background-image:url(../images/ico_transactions_on.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.settings>a{background:url(../images/ico_settings_on.png) 20px 16px no-repeat}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.settings>a.collapsed{background-image:url(../images/ico_settings.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel.settings>a.collapsed:hover{background-image:url(../images/ico_settings_on.png)}html body #wrapper #sidebar-wrapper .sidebar-nav .panel ul li a{color:#a7abac;margin:20px 0 20px 15px}html body #wrapper #sidebar-wrapper .sidebar-nav .panel ul li a:hover,html body #wrapper #sidebar-wrapper .sidebar-nav .panel ul li a.active{color:#fff}html body #wrapper #page-content-wrapper{background-color:#f2f4f7;padding:0}html body #wrapper #page-content-wrapper #topbar{background-color:#fff;padding:17px 20px;border-bottom:1px solid #eaeaea}html body #wrapper #page-content-wrapper #topbar a#menu-toggle{color:#666;font-size:25px}html body #wrapper #page-content-wrapper #topbar a#menu-toggle:hover,html body #wrapper #page-content-wrapper #topbar a#menu-toggle:focus,html body #wrapper #page-content-wrapper #topbar a#menu-toggle:active{text-decoration:none}html body #wrapper #page-content-wrapper #main-content{padding:20px 5px}html body #wrapper #page-content-wrapper #main-content .box-row .box:first-child{margin-left:0}html body #wrapper #page-content-wrapper #main-content .box-row .box:last-child{margin-right:0}html body #wrapper #page-content-wrapper #main-content .box{background-color:#fff;margin-top:20px;border:1px solid #eaeaea;border-top:3px solid #909090;min-height:237px}html body #wrapper #page-content-wrapper #main-content .box .box-head{padding:19px}html body #wrapper #page-content-wrapper #main-content .box .box-head .agg-data{text-align:right}html body #wrapper #page-content-wrapper #main-content .box .box-head .agg-data .title{font-size:13px;text-transform:uppercase}html body #wrapper #page-content-wrapper #main-content .box .box-head .agg-data .amount{font-size:16px}html body #wrapper #page-content-wrapper #main-content .box .box-head .agg-data .amount strong{font-size:25px}html body #wrapper #page-content-wrapper #main-content .box.inv{border-top-color:#55a4d3}html body #wrapper #page-content-wrapper #main-content .box.price{border-top-color:#e0d14f}html body #wrapper #page-content-wrapper #main-content .box.margin{border-top-color:#30a076}html body #wrapper #page-content-wrapper #main-content .box.sales{border-top-color:#454545}html body #wrapper #page-content-wrapper #main-content .main-box-container .box{margin-top:0;padding-top:0}html body #wrapper #page-content-wrapper #main-content .main-box-container .box .box-head{border-bottom:1px solid #eaeaea;padding:0}html body #wrapper #page-content-wrapper #main-content .main-box-container .box .box-head h1{font-size:16px;font-weight:400;padding:17px 0 0 20px}html body #wrapper #page-content-wrapper #main-content .main-box-container .box .box-head .actions{padding:5px 15px}html body #wrapper #page-content-wrapper #main-content .main-box-container .box .box-head .actions a{text-transform:uppercase;padding-left:20px;padding-right:20px}html body #wrapper #page-content-wrapper #main-content .main-box-container .box .box-content .table-container{margin:0;padding:20px}html body #wrapper #page-content-wrapper #main-content .main-box-container .box .box-content .table-container table tbody tr td{padding:10px!important}html body #wrapper #page-content-wrapper #main-content .sidebar-container{margin:0}html body #wrapper #page-content-wrapper #main-content .sidebar{margin:0}html body #wrapper #page-content-wrapper #main-content .sidebar .box-head{padding:0}html body #wrapper #page-content-wrapper #main-content .sidebar h3{font-size:15px;padding:20px;margin:0;border-bottom:1px solid #eaeaea}html body #wrapper #page-content-wrapper #main-content .sidebar .item{padding:10px 20px}html body #wrapper #page-content-wrapper #main-content .sidebar .item .type{font-size:12px;text-transform:uppercase;color:#909090}html body #wrapper #page-content-wrapper #main-content .sidebar .item .amount{font-size:16px}html body .table-container{padding-left:20px}html body .table-container .table-controls{margin-bottom:10px}html body .table-container .table-controls .table-actions .separator{display:inline-block;padding:0 7px;border-left:1px solid #eaeaea}html body .table-container .table-controls .table-actions a{display:inline-block;margin:5px 7px}html body .table-container .table-controls .table-actions a.btn-maximize{width:17px;height:17px;background:url(../images/ico3.png) no-repeat}html body .table-container .table-controls .table-actions a.btn-minimize{width:17px;height:17px;background:url(../images/ico2.png) no-repeat}html body .table-container .table-controls .table-actions a.btn-print{width:21px;height:17px;background:url(../images/ico_print.png) no-repeat}html body .table-container .table-controls .table-actions a.btn-edit{width:16px;height:17px;background:url(../images/ico_edit.png) no-repeat}html body .table-container .table-controls .table-actions a.btn-delete{width:14px;height:18px;background:url(../images/ico_delete.png) no-repeat}html body .table-container .table-controls .table-actions a.btn-popout{width:16px;height:16px;background:url(../images/ico1.png) no-repeat}html body table:not(.table-condensed){margin-bottom:0!important}html body table:not(.table-condensed).is-datatable tfoot{display:table-row-group!important}html body table:not(.table-condensed).dataTable td.select-checkbox:after{width:20px!important;height:20px!important;margin-top:-6px!important;margin-left:-5px!important}html body table:not(.table-condensed).dataTable td.select-checkbox:before{border:1px solid #e0e0e0;width:20px!important;height:20px!important}html body table:not(.table-condensed).data-table{margin-top:20px}html body table:not(.table-condensed).data-table tbody{margin-bottom:1px solid #eaeaea}html body table:not(.table-condensed).data-table tbody tr td{padding:10px 20px!important}html body table:not(.table-condensed).data-table thead tr th,html body table:not(.table-condensed).data-table tfoot tr th,html body table:not(.table-condensed).data-table thead tr td,html body table:not(.table-condensed).data-table tfoot tr td{padding:10px 20px}html body table:not(.table-condensed) thead tr th{border-bottom:none!important;border-top:1px solid #eaeaea!important;background-color:#f9f9f9}html body table:not(.table-condensed) thead tr th.number{text-align:right}html body table:not(.table-condensed) tbody{border-top-color:#fff!important}html body table:not(.table-condensed) tbody tr td{padding:20px!important;border-top:1px solid #eaeaea!important}html body table:not(.table-condensed) tbody tr td:last-child,html body table:not(.table-condensed) tbody tr td.number{text-align:right}html body table:not(.table-condensed) tbody tr td.row-title{text-transform:uppercase}html body table:not(.table-condensed) tfoot tr td{font-weight:700}html body table:not(.table-condensed) tfoot tr td.number{text-align:right}html body .nav-tabs{border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;margin-top:10px}html body .nav-tabs li.active a{border-bottom:3px solid #55a4d3!important;color:#55a4d3!important}html body .nav-tabs li a{border:none!important;text-transform:uppercase;color:#727272;font-size:13px;margin-left:20px}html body .nav-tabs li a:hover{background-color:#fff}html body .modal .modal-dialog .modal-content{background-color:#f9f9f9}html body .modal .modal-dialog .modal-content .modal-header{color:#454545}html body .modal .modal-dialog .modal-content .modal-header .modal-title{padding-left:10px}html body .modal .modal-dialog .modal-content .modal-body .form-group label{text-transform:uppercase;font-weight:400;display:block;font-size:13px}html body .modal .modal-dialog .modal-content .modal-body .form-group label a{float:right;display:inline-block;padding-left:20px;color:#55a4d3;font-size:12px;background:url(../images/ico_plus.png) 0 0 no-repeat}html body .tab-content{padding:0 20px}html body h1{font-size:24px;font-weight:400;padding:0;margin:0}html body a.btn{background-color:#fcfcfc;border:1px solid #eaeaea;color:#666;padding:10px 15px}html body a.btn:hover{background-color:#666;color:#fcfcfc}

[hidden] { display: none; }

div.awesomplete {
	display: inline-block;
	position: relative;
}

div.awesomplete > input {
	display: block;
}

div.awesomplete > ul {
	position: absolute;
	left: 0;
	z-index: 999;
	min-width: 100%;
	box-sizing: border-box;
	list-style: none;
	padding: 0;
	border-radius: .3em;
	margin: .2em 0 0;
	background: hsla(0,0%,100%,.9);
	background: linear-gradient(to bottom right, white, hsla(0,0%,100%,.8));
	border: 1px solid rgba(0,0,0,.3);
	box-shadow: .05em .2em .6em rgba(0,0,0,.2);
	text-shadow: none;
}

div.awesomplete > ul[hidden],
div.awesomplete > ul:empty {
	display: none;
}

@supports (transform: scale(0)) {
	div.awesomplete > ul {
		transition: .3s cubic-bezier(.4,.2,.5,1.4);
		transform-origin: 1.43em -.43em;
	}

	div.awesomplete > ul[hidden],
	div.awesomplete > ul:empty {
		opacity: 0;
		transform: scale(0);
		display: block;
		transition-timing-function: ease;
	}
}

	// Pointer 
	div.awesomplete > ul:before {
		content: "";
		position: absolute;
		top: -.43em;
		left: 1em;
		width: 0; height: 0;
		padding: .4em;
		background: white;
		border: inherit;
		border-right: 0;
		border-bottom: 0;
		-webkit-transform: rotate(45deg);
		transform: rotate(45deg);
	}

	div.awesomplete > ul > li {
		position: relative;
		padding: .2em .5em;
		cursor: pointer;
	}

	div.awesomplete > ul > li:hover {
		background: hsl(200, 40%, 80%);
		color: black;
	}

	div.awesomplete > ul > li[aria-selected="true"] {
		background: hsl(205, 40%, 40%);
		color: white;
	}

		div.awesomplete mark {
			background: hsl(65, 100%, 50%);
		}

		div.awesomplete li:hover mark {
			background: hsl(68, 101%, 41%);
		}

		div.awesomplete li[aria-selected="true"] mark {
			background: hsl(86, 102%, 21%);
			color: inherit;
		}

/*====================ac_manage end====================*/

  </style>

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
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="myAc">Hello, <?php echo $_SESSION['nickname']; ?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="upload.php"><span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> Upload Item</a></li>
                  <li><a href="message.php"><span class="glyphicon glyphicon glyphicon-envelope" aria-hidden="true"></span> Message</a></li>
                  <li><a href="shopping_cart.php"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Shopping Cart</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="ac_manage.php"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Setting</a></li>
                  <li><a href="logout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Sign Out</a></li>
                </ul>
            </li>
        </ul>
    </div><!--bottombar end-->
    <!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
  <div class="CoverImage FlexEmbed FlexEmbed--3by1" style="background-image:url(img/bookCover.jpg)"></div>
  </nav>
