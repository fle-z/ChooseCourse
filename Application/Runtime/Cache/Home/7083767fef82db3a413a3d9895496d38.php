<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<!-- head头部分开始 -->

<head>
    <!-- head头部分开始 -->
<meta charset="UTF-8">
<title>查看学生信息</title>
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
            <h2>学生信息</h2>
            <form class="form-search" style="float:right; width:20em; margin: 0.5em 2em;" method="POST" action="/ChooseCourse/index.php/Home/Boss/viewStudents">
                <div class="input-group">
                    <input type="text" class="form-control" name="student" placeholder="查询" required>
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search"> </span>
                        </button>
                    </div>
                </div>
            </form>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>姓名</th>
                        <th>学号</th>
                        <th>性别</th>
                        <th>入学年龄</th>
                        <th>入学年份</th>
                        <th>班级</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo ($data["username"]); ?></td>
                            <td><?php echo ($data["number"]); ?></td>
                            <td><?php echo ($data["sex"]); ?></td>
                            <td><?php echo ($data["age_school"]); ?></td>
                            <td><?php echo ($data["year_school"]); ?></td>
                            <td><?php echo ($data["class_name"]); ?></td>
                            <td>
                                <a href="javascript:void(0)" onclick="update(this);">修改</a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
            <br>
            <?php if(($displaypage) > "0"): ?><!-- 列表分页开始 -->
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12 b-page">
                        <?php echo ($page); ?>
                    </div>
                </div>
                <!-- 列表分页结束 -->
                <?php else: ?> 没有学生信息<?php endif; ?>
        </div>
    </div>

    <!-- 模态框（Modal） -->
    <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
              修改学生信息
            </h4>
                </div>
                <form name="form" accept-charset="utf-8" id="form" class="form" action="<?php echo U('Boss/updateStudents');?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">姓名</label>
                            <div class="col-sm-10" style="margin-bottom:10px;">
                                <input type="text" class="form-control" id="username" name="username" placeholder="请输入姓名">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">学号</label>
                            <div class="col-sm-10" style="margin-bottom:10px;">
                                <input type="text" class="form-control" id="number" name="number" readOnly="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="score" class="col-sm-2 control-label">性别</label>
                            <center>
                                <input type="radio" name="sex" class="type" value="男" checked/>男
                                <input type="radio" name="sex" class="type" value="女" />女
                            </center>
                        </div>
                        <div class="form-group">
                            <label for="score" class="col-sm-2 control-label">入学年龄</label>
                            <div class="col-sm-10" style="margin-bottom:10px;">
                                <input type="text" class="form-control" id="age_school" name="age_school" placeholder="请输入入学年龄">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="score" class="col-sm-2 control-label">入学年份</label>
                            <div class="col-sm-10" style="margin-bottom:10px;">
                                <input type="text" class="form-control" id="year_school" name="year_school" placeholder="请输入入学年份">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="score" class="col-sm-2 control-label">班级</label>
                            <div class="col-sm-10" style="margin-bottom:10px;">
                                <input type="text" class="form-control" id="class_name" name="class_name" placeholder="请输入班级">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                        </button>
                        <button type="submit" class="btn btn-primary">
                            提交
                        </button>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <script>
            function update(obj) {
                var tds = $(obj).parent().parent().find('td');
                $('#username').val(tds.eq(0).text());
                $('#number').val(tds.eq(1).text());
                $('#age_school').val(tds.eq(3).text());
                $('#year_school').val(tds.eq(4).text());
                $('#class_name').val(tds.eq(5).text());
                $('#update').modal('show');
            }
        </script>
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