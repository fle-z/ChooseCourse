<?php
namespace Home\Controller;
use Think\Controller;

class BossController extends Controller {
  function _initialize(){
    	header("Content-type:text/html;charset=utf-8");
    }

    public function index(){
      R('Login/checkTeac_logined');
      R('Index/category');
      $this->display();
    }

    public function viewInfo(){    //查看个人信息
        R('Login/checkTeac_logined');
        R('Index/category');
        $user = M("teacher");
    	$result=$user->where("number=$_SESSION[number]")->select();
    	$this->assign("result",$result);
    	$this->display();
    }

    public function viewStudents(){
        R('Login/checkTeac_logined');
        R('Index/category');
        if($_POST['student']){
    		$condition['number|username'] = array('like', "%{$_POST['student']}%");
    	}
        $user = M("user");
        $count=$user->count();
    	$listRows=10;
        $p=new  \Think\Page($count,$listRows);
        $limit_options=$p->firstRow.",".$p->listRows;
        $result = $user->where($condition)->limit($limit_options)->select();
        $this->assign('result', $result);
        $displaypage = 0;
        if(count($result) > 0) $displaypage = 1;
        $page=$p->show();
    	$this->assign("displaypage",$displaypage);
    	$this->assign("page",$page);
        $this->display('viewStudents');
    }

    public function viewTeachers(){
        R('Login/checkTeac_logined');
        R('Index/category');
        if($_POST['student']){
    		$condition['number|teacher_name'] = array('like', "%{$_POST['teacher']}%");
    	}
        $user = M("teacher");
        $count=$user->count();
    	$listRows=10;
        $p=new  \Think\Page($count,$listRows);
        $limit_options=$p->firstRow.",".$p->listRows;
        $result = $user->where($condition)->limit($limit_options)->select();
        $this->assign('result', $result);
        $displaypage = 0;
        if(count($result) > 0) $displaypage = 1;
        $page=$p->show();
    	$this->assign("displaypage",$displaypage);
    	$this->assign("page",$page);
        $this->display('viewTeachers');
    }

    public function viewCourse(){
        R('User/checkTeac_logined');
        R('index/category');
        session_start();
        R('Course/listCourse');
    }

    public function updateStudents(){
        R('User/checkTeac_logined');
        R('index/category');
        session_start();
        $update = I('post.');
        $user = D('user');
        if($update['username'] != null) $data['username'] = $update['username'];
        if($update['sex'] != null) $data['sex'] = $update['sex'];
        if($update['year_shool'] != null) $data['year_shool'] = $update['year_shool'];
        if($update['age_school'] != null) $data['age_school'] = $update['age_school'];
        if($update['class_name'] != null) $data['class_name'] = $update['class_name'];
        $condition['number'] = $update['number'];
        $result = $user->where($condition)->save($data);
        $this->viewStudents();
    }

    public function updateTeachers(){
        R('User/checkTeac_logined');
        R('index/category');
        session_start();
        $update = I('post.');
        $user = D('teacher');
        if($update['teacher_name'] != null) $data['teacher_name'] = $update['teacher_name'];
        if($update['sex'] != null) $data['sex'] = $update['sex'];
        $condition['number'] = $update['number'];
        $result = $user->where($condition)->save($data);
        $this->viewTeachers();
    }

    public function updateCourse(){
        R('User/checkTeac_logined');
        R('index/category');
        session_start();
        $update = I('post.');
        $user = D('course');
        if($update['coursename'] != null) $data['coursename'] = $update['coursename'];
        if($update['teacher_name'] != null) $data['teacher_name'] = $update['teacher_name'];
        if($update['classroom'] != null) $data['classroom'] = $update['classroom'];
        if($update['classtime'] != null) $data['classtime'] = $update['classtime'];
        if($update['point'] != null) $data['point'] = $update['point'];
        $condition['number'] = $update['number'];
        $result = $user->where($condition)->save($data);
        $this->viewCourse();
    }

    public function delCourse(){
        R('User/checkTeac_logined');
        R('index/category');
        session_start();
        $checkbox=$_POST['checkbox'];
        if(count($checkbox) == 0) R('Index/askBack', array("请选择课程"));
        else{
            R('Index/alertMes', array("您确认要删除？"));
            for($i = 0; $i < count($checkbox); $i++){
            	$course=D("course");
            	if(!$selected->del("number='".$checkbox[$i]."'")) $this->error("删除课程失败失败!");
                $this->success("删除课程成功");
            }
        }
    }

    public function addStudent(){
        R('User/checkTeac_logined');
        R('index/category');
        session_start();
        $this->display();
    }

    public function checkAddStudent(){
        R('User/checkTeac_logined');
        R('index/category');
        session_start();
        $condition = I('post.');
        $DBuser = D('User');
        $result = $DBuser->create($condition);
        if ($result) {
            if ($DBuser->add()) {
                $this->success('添加成功', U('Boss/viewStudents'));
            } else {
                $this->error('添加失败', U('Boss/addStudent'));
            }
        } else {
            $this->error($DBuser->getError(), U('Boss/addStudent'));
        }
    }

    public function addCourse(){
        R('User/checkTeac_logined');
        R('index/category');
        session_start();
        $this->display();
    }

    public function checkAddCourse(){
        R('User/checkTeac_logined');
        R('index/category');
        session_start();
        $condition = I('post.');
        $course = D('course');
        $result = $course->create($condition);
        if ($result) {
            if ($course->add()) {
                $this->success('添加成功', U('Boss/viewCourse'));
            } else {
                $this->error('添加失败', U('Boss/addCourse'));
            }
        } else {
            $this->error($DBuser->getError(), U('Boss/addCourse'));
        }
    }
}
