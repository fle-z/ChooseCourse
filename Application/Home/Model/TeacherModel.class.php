<?php
namespace Home\Model;
use Think\Model;
/**
 * @function 用户模型 类UserModel.class.php
 */

class TeacherModel extends BaseModel{
// +----------------------------------------------------------------------
// | $_validate表单自动验证
// +----------------------------------------------------------------------

     protected $_validate = array(
            array('verify','require','验证码必须！'), //默认情况下用正则进行验证
            array('number','','帐号名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
            array('number',10,'学号长度不正确！',2,'length'), // 当值不为空的时候判断是否在一个范围内
            array('repassword','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
            array('password','checkPwd','密码格式不正确',0,'function'), // 自定义函数验证密码格式
          );
// +----------------------------------------------------------------------
// | $_auto表单自动填充
// +----------------------------------------------------------------------

        protected $_auto=array(
            array('username','getName',3,'callback'), // 对name字段在新增和编辑的时候回调getName方法
            array('password','md5',3,'function') , // 对password字段在新增和编辑的时候使md5函数处理
                   );

        public function getName(){
            return $username = "teacher";
        }

// +----------------------------------------------------------------------
// | 对数据库的基本操作
// +----------------------------------------------------------------------

        /**
         * 添加数据
         * @param    array    $data    数据
         * @return   integer           新增数据的id
         */
        public function addTeacher($data){
            $id = $this->addData($data);
            return $id;
        }

        /**
         * 修改数据
         * @param    array    $map    where语句数组形式
         * @param    array    $data   修改的数据
         * @return    boolean         操作是否成功
         */
        public function update($map,$data){
            $result = editData($map,$data);
            return $result;
        }

        /**
         * 删除数据
         * @param    array    $map    where语句数组形式
         * @return   boolean          操作是否成功
         */
        public function del($map){
            $result = deleteData($map);
            return $result;
        }

        /**
         * 删除数据
         * @param    array    $map    where语句数组形式
         * @param    string    $field    字符串形式
         * @return   array          操作返回结果
         */
        public function query($map, $field){
            $result = $this->where($map)->getField($field);
            return $result;
        }

        /**
         * 删除数据
         * @param    array    $map    where语句数组形式
         * @return   array          操作返回结果
         */
        public function queryAll($map){
            $result = $this->where($map)->find();
            return $result;
        }
      }
?>
