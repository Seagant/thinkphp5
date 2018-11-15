<?php

namespace app\main\model;

use think\Model;
use think\Db;
use think\Session;

class Person extends Model{

    // 获取用户信息
    public function getUserInfo($username) {
        $data = Db::name('admin')->where('username', $username)->find();
        if (!$data) {
            return false;
        }else{
            return $data;
        }
    }

    // 检查旧密码
    public function checkOldPass($pass) {
        $name = Session::get('name');
        $getPass = Db::name('admin')->where('username', $name)->field('pass')-> find();
        if (md5($pass) !== $getPass['pass']) {
            return ['code' => false, 'msg' => '原密码错误'];
        }else{
            return ['code' => true];
        }
    }

    // 检查传过来的值并更新
    public function checkReferInfo($name,$pass,$resPass,$oldPass) {
        $username = Session::get('name');
        $getUserId = Db::name('admin')->where('username', $username)->field('id')-> find();
        $old = $this->checkOldPass($oldPass);
        if ($name == '' || $pass == '' || $resPass == '') {
            return ['code' => false, 'msg' => '不能为空'];
        }

        if (!$this->checkName($name)) {
            return ['code' => false, 'msg' => '昵称格式不正确'];
        }else if(!$this->checkPass($pass)){
            return ['code' => false, 'msg' => '密码格式不正确'];
        }else if($pass !== $resPass){
            return ['code' => false, 'msg' => '两次密码不一致'];
        }else if($old['code'] === false){
            return ['code' => $old['code'], 'msg' => $old['msg']];
        }else{
            $data = [
                'nickname' => $name,
                'pass' => md5($pass)
            ];

            $author = [
                'author' => $name,
                'update_time' => date("Y-m-d H:i:s")
            ];

            $mysql = Db::name('admin')->where('id', $getUserId['id'])->update($data);
            $auth = Db::name('article')->where('uid', $getUserId['id'])->update($author);
            
            if (!$mysql) {
                return ['code' => false, 'msg' => '用户表错误'];
            }else if(!$auth){
                return ['code' => false, 'msg' => '文章表错误'];
            }else{
                return ['code' => true, 'msg' => '修改成功'];
            }
        }
    }

    // 检查昵称
    public function checkName($nick) {
        $result = preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9]+$/u", $nick);
        return $result;
    }

    // 检查密码
    public function checkPass($pass) {
        $result = preg_match('/^(?=.*\d)[a-zA-Z0-9]{6,12}$/', $pass);
        return $result;
    }

    // 获取所有用户的列表
    public function getAdminList() {
        $admin = Db::name('admin')->where('id','>',1)->field('id,username,nickname,phone,sex,age,status')->paginate(12);
        return $admin;
    }

    // 拉黑用户
    public function disableAdmin($id) {
        $status = 0;
        $mysql = Db::name('admin')->where('id', $id)->update(['status' => $status]);
        $art = Db::name('article')->where('uid', $id)->update(['status' => $status]);
        if (!$mysql && !$art) {
            return ['code' => false, 'msg' => '已经拉黑'];
        }else{
            return ['code' => true, 'msg' => '拉黑成功'];
        }
    }


    // 启用用户
    public function start($id) {
        $status = 1;
        $mysql = Db::name('admin')->where('id', $id)->update(['status' => $status]);
        $art = Db::name('article')->where('uid', $id)->update(['status' => $status]);
        if (!$mysql && !$art) {
            return ['code' => false, 'msg' => '已经启用'];
        }else{
            return ['code' => true, 'msg' => '启用成功'];
        }
    }
}