<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<!-- head头部分开始 -->

<head>
    <!-- head头部分开始 -->
<meta charset="UTF-8">
<title>添加学生</title>
<meta name="keywords" content="添加学生" />
<meta name="description" content="" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="/ChooseCourse/Public/bootstrap-3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/ChooseCourse/Public/bootstrap-3.3.5/css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="/ChooseCourse/Public/font-awesome-4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="/ChooseCourse/Public/css/bjy.css">
<link rel="stylesheet" type="text/css" href="/ChooseCourse/Public/css/animate.css">
<script type="text/javascript">
    logoutUrl = "<?php echo U('Home/Login/logout');?>";
</script>
<link rel="stylesheet" type="text/css" href="/ChooseCourse/Application/Home/View/Public/css/index.css" />
<script type="text/javascript" src="Public/js/index.js"></script>
<!-- head头部分结束 -->

</head>
<!-- head头部分结束 -->

<body>
    <!-- 顶部导航开始 -->
    <!-- 顶部导航开始 -->
<header id="b-public-nav" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <div class="hidden-xs b-nav-background"></div>
                <p class="b-logo-word">布搭布搭学生选课系统</p>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav b-nav-parent">
                <li class="hidden-xs b-nav-mobile"></li>
                <li class="b-nav-cname " >
                    <a href="/ChooseCourse/index.php/Boss/index">首页</a>
                </li>
                <?php if(is_array($categorys)): $i = 0; $__LIST__ = $categorys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li class="b-nav-cname ">
                        <a href="<?php echo U('../..//ChooseCourse/index.php',array('Boss'=>$data['index']));?>"><?php echo ($data["categoryname"]); ?></a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <ul id="b-login-word" class="nav navbar-nav navbar-right">
                <li class="b-nav-cname <?php if(($cid) == "chat"): ?>b-nav-active<?php endif; ?> ">
                    <a href="<?php echo U('Boss/viewInfo');?>">查看个人信息</a>
                </li>
                <?php if(empty($_SESSION['number'])): ?><li class="b-nav-cname b-nav-login">
                        <div class="hidden-xs b-login-mobile"></div>
                        <a href="<?php echo U('Login/login');?>">登陆</a>
                    </li>
                <?php else: ?>
                    <li class="b-user-info">
                        <span class="b-nickname"><?php echo (session('number')); ?></span>
                        <span><a href="<?php echo U('Login/logout');?>">退出</a></span>
                    </li><?php endif; ?>
            </ul>
        </div>
    </div>
</header>
<!-- 顶部导航结束 -->

    <!-- 顶部导航结束 -->
    <div class="b-h-70"></div>
    <div class="row">
        <div class="col-xs-10 col-md-offset-1">
            <h2>添加学生</h2>
            <br> <br>
            <!--注册-->
            <div class="qlogin" id="qlogin">

                <div class="col-xs-4 col-md-offset-4">
                    <form class="form-signin reg_form" id="regUser" accept-charset="utf-8" action="<?php echo U('Boss/checkAddCourse');?>" method="post">
                        <div id="userCue" class="cue">添加课程请注意格式</div>
                        <label for="inputNumber" class="sr-only">课程编号</label>
                        <input type="username" id="inputUsername" class="form-control" name="number" placeholder="课程编号7位" required autofocus>
                        <label for="inputPassword" class="sr-only">课程名</label>
                        <input type="class" id="inputPassword" class="form-control" name="coursename" placeholder="课程名" required>
                        <label for="inputPassword" class="sr-only">教师名</label>
                        <input type="class" id="inputPassword" class="form-control" name="teacher_name" placeholder="教师名" required>
                        <label for="inputPassword" class="sr-only">学分</label>
                        <input type="class" id="inputPassword" class="form-control" name="point" placeholder="学分" required>
                        <label for="inputClass" class="sr-only">上课人数</label>
                        <input type="class" id="inputClass" class="form-control" name="capacity" placeholder="上课人数" required>
                        <label for="inputPassword" class="sr-only">上课地点</label>
                        <input type="class" id="inputPassword" class="form-control" name="classroom" placeholder="上课地点" required>
                        <label for="inputPassword" class="sr-only">上课时间</label>
                        <input type="class" id="inputPassword" class="form-control" name="classtime" placeholder="星期一1-2" required>
                        <label for="inputPassword" class="sr-only">开课年级</label>
                        <input type="class" id="inputPassword" class="form-control" name="grade" placeholder="开课年级2016" required>
                        <label for="inputPassword" class="sr-only">取消年份</label>
                        <input type="class" id="inputPassword" class="form-control" name="cancel_year" placeholder="2016-01-01" required>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">注册</button>
                    </form>

                </div>
            </div>
            <!--注册end-->
            <br>
        </div>
    </div>
    <script type="text/javascript" src="/ChooseCourse/Public/js/jquery.min.js"></script>
<script>
(function(){
		var basePath='/ChooseCourse/Public';
		window.jQuery || document.write('<script src="'+basePath+'/js/jquery-1.9.0.min.js"><\/script>');
})();
</script>
<script type="text/javascript" src="/ChooseCourse/Public/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="/ChooseCourse/Public/js/html5shiv.min.js"></script>
<script type="text/javascript" src="/ChooseCourse/Public/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript" src="/ChooseCourse/Public/pace/pace.min.js"></script>
</body>