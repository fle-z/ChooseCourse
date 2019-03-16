<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<!-- head头部分开始 -->

<head>
    <!-- head头部分开始 -->
<meta charset="UTF-8">
<title>选择课程</title>
<meta name="keywords" content="<?php echo (C("WEB_KEYWORDS")); ?>" />
<meta name="description" content="<?php echo (C("WEB_DESCRIPTION")); ?>" />
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
                    <a href="/ChooseCourse/index.php/Index/index">首页</a>
                </li>
                <?php if(is_array($categorys)): $i = 0; $__LIST__ = $categorys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li class="b-nav-cname ">
                        <a href="<?php echo U('../..//ChooseCourse/index.php',array('Course'=>$data['index']));?>"><?php echo ($data["categoryname"]); ?></a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <ul id="b-login-word" class="nav navbar-nav navbar-right">
                <li class="b-nav-cname <?php if(($cid) == "chat"): ?>b-nav-active<?php endif; ?> ">
                    <a href="<?php echo U('Index/viewInfo');?>">查看个人信息</a>
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
            <h2>查看成绩</h2>
            <br> <br>
            <form action="/ChooseCourse/index.php/Home/Course/quitCourse" method="post">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>课程编号</th>
                            <th>课程名</th>
                            <th>指导教师</th>
                            <th>学分</th>
                            <th>成绩</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($course_info)): $i = 0; $__LIST__ = $course_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                                <td><?php echo ($data["number"]); ?></td>
                                <td><?php echo ($data["coursename"]); ?></td>
                                <td><?php echo ($data["teacher_name"]); ?></td>
                                <td><?php echo ($data["point"]); ?></td>
                                <td><?php if($data["score"] != null): echo ($data["score"]); else: ?>还没有成绩<?php endif; ?></td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <label>加权：<label>
                <label><?php echo ($jiaquan); ?><label>
            </form>
            <br>
            <?php if(($export) > "0"): else: ?> 还没有选课<?php endif; ?>
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