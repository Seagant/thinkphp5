<?php

namespace app\main\controller;

use think\Controller;
use app\main\model\AdminModel;

class Register extends Controller{

    // 注册界面
    public function index () {
        return $this->fetch('register');
    }

    // 检查POST过来的值
    public function checkRegister () {
        $username = $_POST['username'];
        $nickname = $_POST['nickname'];
        $pass = $_POST['password'];
        $resPass = $_POST['resPass'];
        $phone = $_POST['phone'];
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $transferModel = model('AdminModel');
        $info = $transferModel->checkRegInfo($username, $nickname, $pass, $resPass, $phone, $age, $sex);
        if ($info['status'] === false) {
            $this->error($info['msg']);
        }else{
            $this->success($info['status']);
        }
    }
}