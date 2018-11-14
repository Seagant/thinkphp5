<?php

namespace app\main\model;

use think\Model;
use think\Db;

class AdminModel extends Model{
    
    // 检查登录信息是否正确
    public function checkLoginInfo($username, $pass, $verify) {
        if ($username == "" || $pass == "" || $username == NULL || $pass == NULL) {
            return ['status' => false, 'msg' => "用户名或密码不能为空"];
        }
        if ($verify == "") {
            return ['status' => false, 'msg' => '验证码不能为空'];
        }
        if (!captcha_check($verify)) {
            return ['status' => false, 'msg' => '验证码错误'];
        }else{
            $mysql = Db::name('admin')->where('username', $username)->find();
            if ($mysql === NULL) {
                return ['status' => false, 'msg' => "该用户不存在"];
            }else if($mysql['status'] == 0){
                return ['status' => false, 'msg' => "用户已经被禁用"];
            }else if($mysql['username'] !== $username){
                return ['status' => false, 'msg' => "用户名不正确"];
            }else if($mysql['pass'] !== md5($pass)){
                return ['status' =>false, 'msg' => '密码不正确'];
            }else{
                $dateTime = date("Y-m-d H:i:s");
                $time = Db::name('admin')->where('username', $username)->update(['lastLogin_time' => $dateTime]);
                return ['status' =>true, 'msg' => $mysql['username']];
            }
        }
    }

    // 检查注册信息
    public function checkRegInfo ($name, $nick, $pass, $resPass, $phone, $age, $sex) {
        if (empty($name) || empty($nick) || empty($pass) || empty($resPass) || empty($phone) || empty($age) || empty($sex)) {
            return ['status' => false, 'msg' => '所填写的信息不能为空'];
        }else{
            $mysql = Db::name('admin')->where('username', $name)->find();
            if ($mysql['username'] == $name){
                return ['status' => false, 'msg' => '用户名已存在'];
            }else if(!$this->checkUsername($name)){
                return ['status' => false, 'msg' => '用户名不正确'];
            }else if($mysql['nickname'] == $nick){
                return ['status' => false, 'msg' => '昵称已经存在'];
            }else if(!$this->checkName($nick)){
                return ['status' => false, 'msg' => '昵称不正确'];
            }else if(!$this->checkPass($pass)){
                return ['status' => false, 'msg' => '密码不正确'];
            }else if($resPass !== $pass){
                return ['status' => false, 'msg' => '两次密码不一样'];
            }else if(!$this->checkPhone($phone)){
                return ['status' => false, 'msg' => '手机号不正确'];
            }else if($age < 12 || $age > 99){
                return ['status' => false, 'msg' => '年龄不符合'];
            }else{
                $data = [
                    'username' => $name,
                    'nickname' => $nick,
                    'pass' => md5($pass),
                    'phone' => $phone,
                    'age' => $age,
                    'sex' => $sex,
                    'create_time' => date("Y-m-d H:i:s")
                ];
                $saveInfo = Db::name('admin')->insert($data);
                return ['status' => true, 'msg' => '注册成功'];
            }
        }
    }

    // 检查用户名
    public function checkUsername ($name) {
        $result = preg_match('/^[a-zA-Z0-9]{5,10}$/', $name);
        return $result;
    }

    // 检查昵称
    public function checkName ($nick) {
        $result = preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9]+$/u", $nick);
        return $result;
    }

    // 检查密码
    public function checkPass ($pass) {
        $result = preg_match('/^(?=.*\d)[a-zA-Z0-9]{6,12}$/', $pass);
        return $result;
    }

    // 检查手机号
    public function checkPhone ($phone) {
        $result = preg_match('/^1[3|4|5|8][0-9]\d{4,8}$/', $phone);
        return $result;
    }
}