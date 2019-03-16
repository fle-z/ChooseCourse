<?php
namespace Home\Model;
use Think\Model;
/**
 * @function 用户模型 类UserModel.class.php
 */

class CourseModel extends BaseModel{
    /**
     * 添加数据
    * @param    array    $data    数据
     * @return   integer           新增数据的id
     */
    public function addCourse($data){
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
        $result = $this->editData($map,$data);
        return $result;
    }

    /**
     * 删除数据
     * @param    array    $map    where语句数组形式
     * @return   boolean          操作是否成功
     */
    public function del($map){
        $result = $this->deleteData($map);
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
