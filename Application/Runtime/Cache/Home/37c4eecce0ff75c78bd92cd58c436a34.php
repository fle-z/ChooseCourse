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
            <h2>查看课程</h2>
            <form class="form-search" style="float:right; width:20em; margin: 0.5em 2em;" method="POST" action="/ChooseCourse/index.php/Home/Boss/listCourse">
                <div class="input-group">
                    <input type="text" class="form-control" name="course" placeholder="查询" required>
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search"> </span>
                        </button>
                    </div>
                </div>
            </form>
            <form action="/ChooseCourse/index.php/Home/Boss/delCourse" method="post">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>课程编号</th>
                            <th>课程名</th>
                            <th>指导教师</th>
                            <th>已选/容量</th>
                            <th>上课教室</th>
                            <th>上课时间</th>
                            <th>学分</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(is_array($course_info)): $i = 0; $__LIST__ = $course_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
                                <td><input type="checkbox" id="c1" class="check" name="checkbox[]" value="<?php echo ($data["number"]); ?>"><?php echo ($data["number"]); ?></td>
                                <td><?php echo ($data["coursename"]); ?></td>
                                <td><?php echo ($data["teacher_name"]); ?></td>
                                <td><?php echo ($data["selectedman"]); ?>/<?php echo ($data["capacity"]); ?></td>
                                <td><?php echo ($data["classroom"]); ?></td>
                                <td><?php echo ($data["classtime"]); ?>节</td>
                                <td><?php echo ($data["point"]); ?></td>
                                <td>
                                    <a href="javascript:void(0)" onclick="update(this);">修改</a>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-sm" style="font-size:12px;float:right;">&nbsp;&nbsp;提交&nbsp;&nbsp;</button>
            </form>
            <br>
            <?php if(($displaypage) > "0"): ?><!-- 列表分页开始 -->
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12 b-page">
                        <?php echo ($page); ?>
                    </div>
                </div>
                <!-- 列表分页结束 -->
                <?php else: ?> 没有课程信息<?php endif; ?>
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
              修改课程信息
            </h4>
                </div>
                <form name="form" accept-charset="utf-8" id="form" class="form" action="<?php echo U('Boss/updateCourse');?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="number" class="col-sm-2 control-label">课程编号</label>
                            <div class="col-sm-10" style="margin-bottom:10px;">
                                <input type="text" class="form-control" id="number" name="number" readOnly="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">课程名</label>
                            <div class="col-sm-10" style="margin-bottom:10px;">
                                <input type="text" class="form-control" id="coursename" name="coursename" placeholder="请输入姓名">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="score" class="col-sm-2 control-label">指导老师</label>
                            <div class="col-sm-10" style="margin-bottom:10px;">
                                <input type="text" class="form-control" id="teacher_name" name="teacher_name" placeholder="请输入指导老师">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="score" class="col-sm-2 control-label">上课教室</label>
                            <div class="col-sm-10" style="margin-bottom:10px;">
                                <input type="text" class="form-control" id="classroom" name="classroom" placeholder="请输入入学上课教室">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="score" class="col-sm-2 control-label">上课时间</label>
                            <div class="col-sm-10" style="margin-bottom:10px;">
                                <input type="text" class="form-control" id="classtime" name="classtime" placeholder="请输入上课时间">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="score" class="col-sm-2 control-label">学分</label>
                            <div class="col-sm-10" style="margin-bottom:10px;">
                                <input type="text" class="form-control" id="point" name="point" placeholder="请输入学分">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                            </button>
                            <button type="submit" class="btn btn-primary">
                                提交
                            </button>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                </form>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <script>
                function update(obj) {
                    var tds = $(obj).parent().parent().find('td');
                    $('#number').val(tds.eq(0).text());
                    $('#coursename').val(tds.eq(1).text());
                    $('#teacher_name').val(tds.eq(2).text());
                    $('#classroom').val(tds.eq(4).text());
                    $('#classtime').val(tds.eq(5).text());
                    $('#point').val(tds.eq(6).text());
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