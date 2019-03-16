<?php
namespace Home\Controller;
use Think\Controller;

class CourseController extends Controller{
  function _initialize(){
    	header("Content-type:text/html;charset=utf-8");
    }
    //+-----------------------------------------------------------------------------
    //+列出全部课程
    //+-----------------------------------------------------------------------------
    public function listCourse(){
        R('User/checkStu_logined');
        R('index/category');
    	if($_POST['course'] != null){
    		$condition['number|coursename'] = array('like', "%{$_POST['course']}%");
    	}
        $chooseTime = Date("Y", time());
        $condition['cancel_year'] = array('egt',$chooseTime);
        $course=M("Course");
        //var_dump($condition);var_dump($condition);
    	$count=$course->where($condition)->count();
    	$listRows=10;
        $p=new  \Think\Page($count,$listRows);
        $limit_options=$p->firstRow.",".$p->listRows;
    	$course_info=$course->where($condition)->limit($limit_options)->select();
    	$displaypage=0;
    	if(count($course_info)>0) $displaypage=1;
    	$page=$p->show();
    	$this->assign("displaypage",$displaypage);
    	$this->assign("page",$page);
    	$this->assign("course_info",$course_info);
    	$this->display();
    }

    //+-----------------------------------------------------------------------------
    //+选课操作
    //+-----------------------------------------------------------------------------
    public function chooseCourse(){
        R('User/checkStu_logined');
    	session_start();
    	$checkbox=$_POST['checkbox'];
        if(count($checkbox) > 2) R('Index/askBack', array("每次最多只能选两门课程"));
        else if(count($checkbox) == 0) R('Index/askBack', array("请选择课程"));
        else{
            for($i = 0; $i < count($checkbox); $i++){
            	$data['userNumber']=$_SESSION['number'];
            	$selected=D("Choice");
            	if($selected->queryAll("coursenumber='".$checkbox[$i]."'and usernumber='".$_SESSION['number']."'")) $this->error("已经选过");
            	$course=M("Course");
            	$course_info=$course->where("number='".$checkbox[$i]."'")->find();
                $choice_info=$selected->where("usernumber=$_SESSION[number]")->select();
                //var_dump($choice_info);
                for($j = 0; $j < count($choice_info); $j++){
                	$course_id[$j]=$choice_info[$j]['coursenumber'];
                }
                //var_dump($course_info);
                for($j=0;$j<count($course_id);$j++){
                	$course_info2=$course->where("number='".$course_id[$j]."'")->find();
                    //var_dump($course_info2);
                	if($course_info['classtime']==$course_info2['classtime']) $this->error("上课时间有冲突");
                }
                //echo $checkbox[$i];
            	if($course_info['selectedman']>=$course_info['capacity']) $this->error("名额已满");
            	$data['courseNumber']=$checkbox[$i];
                $data['class_choose_year']=date("Y-m-d", time());
                //var_dump($data);
                //echo $selected->addChoice($data);
            	if(!$selected->addChoice($data)) $this->error("选课失败!");
            	if(!$course->where("number='".$checkbox[$i]."'")->setInc('selectedman')) $this->error("选课失败!!");
            	$this->success("选课成功");
            }
        }
    }

    //+-----------------------------------------------------------------------------
    //+管理学生已选课程信息
    //+-----------------------------------------------------------------------------
    public function manageCourse(){
        R('User/checkStu_logined');
        R('index/category');
        session_start();
    	$selected=M("Choice");
    	$choice_info=$selected->where("usernumber=$_SESSION[number]")->select();
        for($i=0;$i<count($choice_info);$i++)
             $course_id[$i]=$choice_info[$i]['coursenumber'];
        if(count($course_id) != 0){
            $course=M("Course");
            $condition['number']=array('in',$course_id);
            $course_info=$course->where($condition)->select();
        }
        $export=0;
        if(count($choice_info)>0) $export=1;
        $this->assign("export",$export);
        $this->assign("course_info",$course_info);
        $this->display();
    }

    //+-----------------------------------------------------------------------------
    //+学生退课操作
    //+-----------------------------------------------------------------------------
    function quitCourse(){
    	R('User/checkStu_logined');
    	$checkbox=$_POST['checkbox'];
        if(count($checkbox) == 0) R('Index/askBack', array("请选择课程"));
        else{
            for($i = 0; $i < count($checkbox); $i++){
            	$selected=D("Choice");
            	if(!$selected->del("coursenumber='".$checkbox[$i]."'and usernumber='".$_SESSION['number']."'")) $this->error("退课失败!");
            	$course=M("Course");
            	if(!$course->where("number='".$checkbox[$i]."'")->setDec('selectedman')) $this->error("退课失败!!");
                $this->success("退课成功");
            }
        }
    }

    //+-----------------------------------------------------------------------------
    //+学生查看成绩
    //+-----------------------------------------------------------------------------
    public function viewScore(){
        R('User/checkStu_logined');
        R('Index/category');
        session_start();
    	$selected=M("Choice");
    	$choice_info=$selected->where("userNumber=$_SESSION[number]")->field('coursenumber,score')->select();
        //var_dump($choice_info);
        for($i=0;$i<count($choice_info);$i++)
             $course_id[$i]=$choice_info[$i]['coursenumber'];
        if(count($course_id) != 0){
            $course=M("Course");
            $condition['number']=array('in',$course_id);
            $course_info=$course->where($condition)->getField('number,coursename,teacher_name,point');
        }
        $m = 0;
        $temparr[$m] = array();
        for($i=0; $i<count($choice_info); $i++){
            foreach($course_info as $key => $value){
                if($choice_info[$i]['coursenumber'] == $value['number']){
                    $temparr[$m] = $value;
                    $temparr[$m]['score'] = $choice_info[$i]['score'];
                    $m++;
                }
            }
        }
        for($i = 0; $i < count($temparr); $i++){
            $scoreAll += $temparr[$i]['score'] * $temparr[$i]['point'];
            $pointAll += $temparr[$i]['point'];
        }
        $jiaquan = $scoreAll / $pointAll;
        $export=0;
        if(count($temparr)>0) $export=1;
        $this->assign("export",$export);
        $this->assign("course_info",$temparr);
        $this->assign("jiaquan", $jiaquan);
        $this->display();
    }

    //+-----------------------------------------------------------------------------
    //+老师查看学生选课情况
    //+-----------------------------------------------------------------------------
    public function viewChoice(){
        R('User/checkTeac_logined');
        R('index/category');
        $this -> desc_viewChoice();
        $this -> display('viewChoice');
    }
    public function desc_viewChoice(){
        $tea['number'] = I('session.number');
        $teacher = D('teacher');
        $teacher_name = $teacher->where($tea)->field('teacher_name')->select();
        //var_dump($teacher_name);var_dump($teacher_name);var_dump($teacher_name);var_dump($teacher_name);
        $course = M("Course");
        $course_number = $course -> where($teacher_name)->field('number')->select();
        //var_dump($course_number);
        for($i = 0; $i < count($course_number); $i++) {
            $choice=M("Choice");
            $user_= $choice->where("courseNumber='".$course_number[$i]['number']."'")->field('usernumber, score')->select();
            if(count($user_) > 0) {
                for($i = 0; $i < count($user_); $i++)
                    $usernumber[$i] = $user_[$i]['usernumber'];
                $condition['number']=array('in',$usernumber);
            }
        }
        if($_POST['student'] != null){
            $condition['number|username'] = array('like', "%{$_POST['student']}%");
        }
        //var_dump($user_);
        //var_dump($condition);var_dump($condition);
        $user = M("user");
        $count=$user->where($condition)->count();
        $listRows=10;
        $p = new  \Think\Page($count,$listRows);
        $limit_options=$p->firstRow.",".$p->listRows;
        $user_info=$user->where($condition)->limit($limit_options)->select();
        for($i = 0; $i < count($user_info); $i++){
            for($j = 0; $j < count($user_); $j++){
                if($user_info[$i]['number'] == $user_[$j]['usernumber'])
                    $user_info[$i]['score'] = $user_[$j]['score'];
            }
        }
        //var_dump($user_info);
    	$displaypage=0;
    	if(count($user_info)>0) $displaypage=1;
    	$page=$p->show();
    	$this->assign("displaypage",$displaypage);
    	$this->assign("page",$page);
    	$this->assign("result",$user_info);
    }

    //+-----------------------------------------------------------------------------
    //+老师录入成绩
    //+-----------------------------------------------------------------------------
    public function inputScore(){
        R('User/checkTeac_logined');
        R('index/category');
        session_start();
        $this -> desc_viewChoice();
        $this -> display();
    }

    public function setScore(){
        R('User/checkTeac_logined');
        R('index/category');
        session_start();
        $score = I('post.');
        $choice = D('choice');
        foreach ($score as $key => $value) {
            $condition['userNumber'] = $key;
            $data['score'] = $value;
            $result = $choice->where($condition)->save($data);
        }
        $this->viewChoice();
    }

    //+-----------------------------------------------------------------------------
    //+老师修改分数
    //+-----------------------------------------------------------------------------
    public function updateScore(){
        R('User/checkTeac_logined');
        R('index/category');
        session_start();
        $score = I('post.');
        $choice = D('choice');
        $condition['userNumber'] = $score['number'];
        $data['score'] = $score['score'];
        $result = $choice->where($condition)->save($data);
        $this->viewChoice();
    }

    //+-----------------------------------------------------------------------------
    //+查询各个分数段的人数及平均分
    //+-----------------------------------------------------------------------------
    private function querysum($low, $high, $condition){
        $choice=M("Choice");
        $condition['coursenumber'] = $course_number;
        //var_dump($condition);
        $condition['score'] = array(array('egt',$low),array('lt',$high));
        $score = $choice->where($condition)->count('score');
        return $score;
    }

    public function checkScore(){
        R('User/checkTeac_logined');
        R('index/category');
        session_start();
        $tea['number'] = I('session.number');
        $teacher = D('teacher');
        $teacher_name = $teacher -> where($tea)->field('teacher_name')->select();
        $course = M("Course");
        //var_dump($teacher_name);
        $course_number = $course -> where($teacher_name)->field('number')->select();
        //var_dump($course_number);
        //var_dump($teacher_name);
        for($i = 0; $i < count($course_number); $i++) {
            $choice=M("Choice");
            $condition['courseNumber'] = $course_number[$i]['number'];
            //var_dump($condition);
            $avgScore = $choice->where($condition)->avg('score');
            $score[1] = $this->querysum(0, 60, $condition);
            $score[2] = $this->querysum(60, 70, $condition);
            $score[3] = $this->querysum(70, 80, $condition);
            $score[4] = $this->querysum(80, 90, $condition);
            $score[5] = $this->querysum(90, 100, $condition);
            $score[6] = $this->querysum(100, 200, $condition);
        }
        $this->assign('score', $score);
        $this->assign('avgScore', $avgScore);
        $this->display();
    }
}
