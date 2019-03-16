<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<!-- head头部分开始 -->

<head>
    <!-- head头部分开始 -->
<meta charset="UTF-8">
<title>查看成绩</title>
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

    <script type="text/javascript" src="/ChooseCourse/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/ChooseCourse/Public/js/highcharts.js"></script>
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
            <h2>查看学生成绩分布</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>60分以下</th>
                        <th>60-70</th>
                        <th>70-80</th>
                        <th>80-90</th>
                        <th>90-100</th>
                        <th>100</th>
                        <th>平均分</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php if(is_array($score)): foreach($score as $key=>$data): ?><td><?php echo ($data["name"]); ?></td><?php endforeach; endif; ?>
                        <td><?php echo ($avgScore); ?></td>
                    </tr>
                </tbody>
            </table>
            <div id="chart" style="width: 550px; height: 400px; margin: 0 auto"></div>

        </div>
    </div>
    <script language="JavaScript">
        $(document).ready(function() {
            var title = {
                text: '学生成绩分布'
            };
            var subtitle = {
                text: ''
            };
            var xAxis = {
                categories: ['60以下', '60-70', '70-80', '80-90', '90-100', '100']
            };
            var yAxis = {
                title: {
                    text: '人数(人)'
                }
            };
            var plotOptions = {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            };
            var series = [{
                name: '成绩分布',
                data: [0, 0, 0, 1, 1, 0]
            }];

            var json = {};

            json.title = title;
            json.subtitle = subtitle;
            json.xAxis = xAxis;
            json.yAxis = yAxis;
            json.series = series;
            json.plotOptions = plotOptions;
            $('#chart').highcharts(json);

        });
    </script>
</body>

</html>