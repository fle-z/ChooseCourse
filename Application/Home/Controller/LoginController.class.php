<?php
namespace Home\Controller;
use Think\Controller;

class LoginController extends Controller {
    /**
       * 创建验证码
    */
    public function verify(){
        //见thinkPHP参考手册
        $Verify = new \Think\Verify();
        $Verify->entry();
    }

    // 检测输入的验证码是否正确，$code为用户输入的验证码字符串
    function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    function check_login(){  //判断是否登录成功
        if(!$this->check_verify($_POST['verify'])){
            $this->error('验证码错误！');
        } else {
          session_start();
          if($_POST['type']=="stu")
    	      $user=D('User');
    	else
    	      $user=D('Teacher');
          switch($_POST['type']){                 //根据是学生登录还是教师登录跳转到不同的页面
            case "stu":
                    $url=U("Index/index");
                    break;
            case "teac":
                    $url=U("Teacher/teacher");
                    break;
          }
          $condition['number']=I('post.number');
          $result=$user->queryAll($condition);
          if(!$result){ $this->error("没有该用户！！");}
            if($result['flag'] == 3) $url = U("Boss/index");
            if($result['password'] == md5(I("post.password"))){
                if($_POST['$remember']) {
                         setcookie("number", $result['number'], time()+7*24*3600);
                         setcookie("flag", $result['flag'], time()+7*24*3600);
                     }
                $_SESSION['number'] = $result['number'];
                $_SESSION['flag'] = $result['flag'];
                $this->assign("jumpUrl",$url);
                $this->success("登录成功");
            }else{
                $this->error("用户名或者密码错误！！");
            }
        }
    }

    /**
      *注册新用户
     **/
    public function addUser(){
        session_start();
        $condition = I('post.');
        $DBuser = D('User');
        $result = $DBuser->create($condition);
        if ($result) {
            if ($DBuser->add()) {
                $this->success('注册成功，请返回首页登录', U('Login/login'));
            } else {
                $this->error('注册失败', U('Login/login'));
            }
        } else {
            $this->error($DBuser->getError(), U('Login/login'));
              }
    }

    /**
       *注销用户
    */
    public function logout(){
        $_SESSION = array();
        if(isset($_COOKIE[session_name()])) {
            setcookie(session_name(), "", time()-1);
        }
        if(isset($_COOKIE['number'])) {
            setcookie("number", "", time()-1);
        }
        if(isset($_COOKIE['flag'])) {
            setcookie("flag", "", -1);
        }
        session_destroy();
        $this->success('退出成功，返回首页',U('Login/login'));
    }

    function checkStu_logined(){       //检测学生是否已经登录
        session_start();
        $user=M('User');
        $condition['number']=$_SESSION['number'];
        $condition['flag']=$_SESSION['flag'];
        $us=$user->where($condition)->find();
        if(!$us){$url=U('Login/login');$this->assign("jumpUrl",$url);$this->error("还没有登录！！");}
    }

    function checkTeac_logined(){       //检测教师是否已经登录
        session_start();
        $user=D('teacher');
        $condition['number']=$_SESSION['number'];
        $condition['flag']=$_SESSION['flag'];
        $us=$user->where($condition)->find();
        if(!$us){$url=U('Login/login');$this->assign("jumpUrl",$url);$this->error("还没有登录！！");}
    }


}
