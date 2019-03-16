<?php
namespace Home\Controller;
use Think\Controller;

class TeacherController extends Controller {
  function _initialize(){
    	header("Content-type:text/html;charset=utf-8");
    }

    public function teacher(){
      R('Login/checkTeac_logined');
      R('Index/category');
      $this->display();
    }

}
