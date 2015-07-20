<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link type="text/css" rel="stylesheet" href="<?php echo LINK_ROOT; ?>/css/jquery-ui.min.css" />
<link type="text/css" rel="stylesheet" href="<?php echo LINK_ROOT; ?>/css/bootstrap.min.css" />
<link type="text/css" rel="stylesheet" href="<?php echo LINK_ROOT; ?>/css/pop_loading.css" />

<script type="text/javascript" src="<?php echo LINK_ROOT; ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo LINK_ROOT; ?>/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo LINK_ROOT; ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo LINK_ROOT; ?>/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo LINK_ROOT; ?>/js/url.js"></script>
<script type="text/javascript" src="<?php echo LINK_ROOT; ?>/js/pop_div.js"></script>
<script type="text/javascript" src="<?php echo LINK_ROOT; ?>/js/pop_loading.js"></script>

<title><?php echo $title; ?> - DCB</title>
</head>

<body>
<!--头部-->

<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo LINK_ROOT; ?>">DCB</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li <?php if($view=='default'){ ?>class="active"<?php } ?>><a href="<?php echo LINK_ROOT; ?>">历史记录</a></li>
        <li <?php if($view=='trend'){ ?>class="active"<?php } ?>><a href="<?php echo LINK_ROOT; ?>/index.php?controller=view&view=trend">走势</a></li>
        <!--<li <?php if($view=='red'){ ?>class="active"<?php } ?>><a href="<?php echo LINK_ROOT; ?>/index.php?controller=view&view=red">红球</a></li>-->
        <li <?php if($view=='blue'){ ?>class="active"<?php } ?>><a href="<?php echo LINK_ROOT; ?>/index.php?controller=view&view=blue">蓝球</a></li>
        <li <?php if($view=='sales'){ ?>class="active"<?php } ?>><a href="<?php echo LINK_ROOT; ?>/index.php?controller=view&view=sales">销售额</a></li>
        <!--<li <?php if($view=='first'){ ?>class="active"<?php } ?>><a href="<?php echo LINK_ROOT; ?>/index.php?controller=view&view=first">一等奖</a></li>-->
        <!--<li <?php if($view=='second'){ ?>class="active"<?php } ?>><a href="<?php echo LINK_ROOT; ?>/index.php?controller=view&view=second">二等奖</a></li>-->
        <li><a href="http://kaijiang.zhcw.com/zhcw/html/ssq/list_1.html" target="_blank">数据源</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
