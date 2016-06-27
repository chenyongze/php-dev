<!doctype html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <!-- Title and other stuffs -->
  <title>问吧--直播课</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="">


  <!-- Stylesheets -->
  <link href="/css/bootstrap.css" rel="stylesheet">
  <!-- Font awesome icon -->
  <link rel="stylesheet" href="/css/font-awesome.css"> 
  <!-- jQuery UI -->
  <link rel="stylesheet" href="/css/jquery-ui.css"> 
  <!-- Calendar -->
  <link rel="stylesheet" href="/css/fullcalendar.css">
  <!-- prettyPhoto -->
  <link rel="stylesheet" href="/css/prettyPhoto.css">  
  <!-- Star rating -->
  <link rel="stylesheet" href="/css/rateit.css">
  <!-- Date picker -->
  <link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css">
  <!-- CLEditor -->
  <link rel="stylesheet" href="/css/jquery.cleditor.css"> 
  <!-- Bootstrap toggle -->
  <link rel="stylesheet" href="/css/bootstrap-switch.css">
  <!-- Main stylesheet -->
  <link href="/css/style.css" rel="stylesheet">
  <!-- Widgets stylesheet -->
  <link href="/css/widgets.css" rel="stylesheet"> 
  <!-- 日历 --> 
  <link href=" /css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" media="all" href=" /css/daterangepicker-bs3.css" />
  <!-- self define -->
  <link href=" /css/common.css" rel="stylesheet">  

  <!--link rel="stylesheet" type="text/css" href="/css/bootstrap-tags.css" /-->
        <script src=" /js/jquery.js"></script>
        <script src=" /js/jquery.form.js"></script>
        <script src=" /js/bootstrap.js"></script>
        <script src=" /js/app/common.js"></script>
        <script src=" /js/jquery.validate.js"></script>
        <script src=" /js/jquery.validate.additional.js"></script>
        <script src=" /js/underscore.js"></script>
        <script src=" /js/backbone.js"></script>
        <script src=" /js/bootstrap-datepicker.js"></script>
        <script src="/js/ckeditor/ckeditor.js"></script>
        <script src="/js/ckfinder/ckfinder.js"></script>
        <!--script src='/js/bootstrap/bootstrap-tags.min.js'></script-->
  <!-- HTML5 Support for IE -->
  <!--[if lt IE 9]>
  <script src="{$homePath}/assets/js/html5shim.js"></script>
  <![endif]-->
  <{$username = ''}>
  <{if isset($userInfo)}>
  <{if !$userInfo['uid']}>
  <script type="text/javascript">
  window.location.href="/login";
  </script>
  <{/if}>
  <{$username=$userInfo['name']}>
  <{/if}>
  <!-- Favicon -->
  <link rel="shortcut icon" href="img/favicon/favicon.png">
</head>

<body>


<!-- Header starts -->
  <header>
    <div class="container">
      <div class="row">

        <!-- Logo section -->
        <div class="col-md-4">
          <!-- Logo. -->
          <div class="logo">
            <h1><a href="#">学霸君---直播课mis</a></h1>
            <p class="meta">课程管理、题库管理、学生管理、教师管理</p>
          </div>
          <!-- Logo ends -->
        </div>

        <!-- Button section -->
        <div class="col-md-4">

        </div>

        <!-- Data section -->

        <div class="col-md-4">
          <div class="header-data">
	        <ul class="nav navbar-nav pull-right">
	          <li class="dropdown pull-right">            
	            <a class="dropdown-toggle" href="#">
	              <i class="icon-user"></i> <{$username}> <b class="caret"></b>              
	            </a>
	            <!-- Dropdown menu -->
	            <ul class="dropdown-menu">
	              <li><a href="/passport/logout"><i class="icon-off"></i> Logout</a></li>
	            </ul>
	          </li>
	          
	        </ul>
          </div>
        </div>

      </div>
    </div>
    
  </header>

