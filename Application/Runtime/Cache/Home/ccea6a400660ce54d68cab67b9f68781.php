<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>布搭布搭选课系统</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="/ChooseCourse/Public/js/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="/ChooseCourse/Application/Home/Public/js/login.js"></script>
    <script src="/ChooseCourse/Public/js/ie8-responsive-file-warning.js"></script>
    <script src="/ChooseCourse/Public/js/ie-emulation-modes-warning.js"></script>
    <link href="/ChooseCourse/Public/css/bootstrap.min.css" rel="stylesheet">
    <link href="/ChooseCourse/Application/Home/Public/css/signin.css" rel="stylesheet">
    <link href="/ChooseCourse/Application/Home/Public/css/login2.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="../../favicon.ico">
</head>

<body>
    <h1>登&nbsp;&nbsp;&nbsp;&nbsp;入</h1>

    <div class="login" style="margin-top:50px;">

        <div class="header">
            <div class="switch" id="switch"><a class="switch_btn_focus" id="switch_qlogin" href="javascript:void(0);" tabindex="7">快速登录</a>
                <a class="switch_btn" id="switch_login" href="javascript:void(0);" tabindex="8">快速注册</a>
                <div class="switch_bottom" id="switch_bottom" style="position: absolute; width: 64px; left: 0px;"></div>
            </div>
        </div>


        <div class="web_qr_login" id="web_qr_login" style="display: block; height: 235px;">

            <!--登录-->
            <div class="web_login" id="web_login">


                <div class="login-box">


                    <div class="login_form">
                        <form name="form" accept-charset="utf-8" id="form" class="form-signin"  action="<?php echo U('Login/check_login');?>"method="post">
                            <label for="inputUsername" class="sr-only">Username</label>
                            <input type="username" id="inputUsername" class="form-control" name="number" placeholder="学号-10位" required autofocus>
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input type="password" id="inputPassword" class="form-control" name="password" placeholder="密码" required>
                            <center>
                                <input type="radio" name="type" class="type" value="stu" checked/>学生
                                <input type="radio" name="type" class="type" value="teac" />教师
                            </center>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="remember-me"> 记住我一周
                                </label>
                            </div>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">登入</button>
                        </form>
                    </div>

                </div>

            </div>
            <!--登录end-->
        </div>

        <!--注册-->
        <div class="qlogin" id="qlogin" style="display: none; ">

            <div class="web_login">
                <form class="form-signin reg_form" id="regUser" accept-charset="utf-8" action="<?php echo U('Login/addUser');?>" method="post">
                    <div id="userCue" class="cue">快速注册请注意格式</div>
                    <label for="inputNumber" class="sr-only">学号</label>
                    <input type="username" id="inputUsername" class="form-control" name="number" placeholder="学号-10位" required autofocus>
                    <label for="inputPassword" class="sr-only">密码</label>
                    <input type="password" id="inputPassword" class="form-control" name="password" placeholder="密码" required>
                    <label for="inputPassword" class="sr-only">确认密码</label>
                    <input type="password" id="inputPassword" class="form-control" name="repassword" placeholder="确认密码" required>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">注册</button>
                </form>


            </div>


        </div>
        <!--注册end-->
    </div>
    <div class="jianyi">*推荐使用ie8或以上版本ie浏览器或Chrome内核浏览器访问本站</div>
    <script src="/ChooseCourse/Public/js/ie10-viewport-bug-workaround.js"></script>
</body>

</html>