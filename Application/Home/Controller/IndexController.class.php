<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
  function _initialize(){
    	header("Content-type:text/html;charset=utf-8");
    }

    public function index(){
        if(I('session.flag') == 1)
            R('Login/checkStu_logined');
        else if(I('session.flag') == 2)
            R('Login/checkTeac_logined');
        $this->category();
        $this->display();
    }

    public function viewInfo(){    //查看个人信息
        if(I('session.flag') == 1){
            R('Login/checkStu_logined');
            $user=M("User");
        }
        else{
            R('Login/checkTeac_logined');
            $user = M("teacher");
        }
        $this->category();
    	$result=$user->where("number=$_SESSION[number]")->select();
    	$this->assign("result",$result);
    	$this->display();
    }

    public function drop(){
        $this->alertMes("你确定要退学？退学操作不可恢复！！！");
        $condition['number'] = I('get.number');
        //var_dump($condition);var_dump($condition);var_dump($condition);var_dump($condition);
        $choice = D('choice');
        $chooseCourse = $choice -> where($condition) -> getField('courseNumber');
        $course = D('course');
        if($course->where($chooseCourse)->setDec('selectedman')) $this->error("选课失败!!");
        $user = D('user');
        $user->del($condition);
        R('Login/logout');
    }

    public function category(){
        $flag = I('session.flag');
        $categorys = M('category')->where("flag='".$flag."'")->select();
        $this->assign('categorys',$categorys);
    }

    public function askBack($text) {
        echo "<script>if(confirm('$text'))window.history.go(-1)</script>" ;
    }

    public function alertMes($message) {
        echo "<script>alert('".$message."');</script>";
    }

    function query($text, $target1, $target2) {
        echo "<script>
                if(confirm('$text'))
                    window.location.href = '$target1';
                else
                    window.location.href = '$target2';
            </script>" ;
    }
}
