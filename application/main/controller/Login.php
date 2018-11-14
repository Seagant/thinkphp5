<?php

namespace app\main\controller;

use think\Controller;
use think\captcha\Captcha;
use app\model\AdminModel;
use think\Session;

class Login extends Controller{
    // 登录界面
    public function login () {
        return $this->fetch('login');
    }

    // 验证码
    public function verify () {
        $config = [
            // 验证码字体大小
            'fontSize' => 30,
            // 验证码位数
            'length' => 4,
            // 验证成功是否重置
            'reset' => false
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    // 检查登录信息
    public function checkInfo () {
        $username = $_POST['username'];
        $token = $_POST['__token__'];
        $pass = $_POST['password'];
        $verify = $_POST['verify'];
        $transferModel = model('AdminModel');
        $result = $transferModel->checkLoginInfo($username, $pass, $verify);
        if ($result['status'] === false) {
            $this->error($result['msg']);
        }else{
            Session::set('name', $result['msg']);
            $this->success($result['status']);
        }
    }
}