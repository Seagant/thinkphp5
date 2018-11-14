<?php

namespace app\main\controller;

use think\Controller;
use think\Session;
use app\main\model\Content;
use think\Db;

class Article extends Controller{
    

    // 检查是否有Session
    public function check (){
        if (!$this->sessionName()){
            $this->error('请先去登录','MessageBoard/public/main/Main/index');
        }
    }

    // 获取Session名字
    public function sessionName () {
        $name = Session::get('name');
        return $name;
    }

    // 添加文章页面
    public function index () {
        $this->check();
        $mysql = Db::name('admin')->where('username', $this->sessionName())->find();
        $userId = $mysql['id'];
        return $this->fetch('index', [
            'nick' => $mysql['nickname'],
            'uid' => $userId
        ]);
    }


    // 检查POST过来的标题和内容
    public function checkArticle () {
        $mysql = Db::name('admin')->where('username', $this->sessionName())->find();
        $author = $mysql['nickname'];
        $title = $_POST['title'];
        $content = $_POST['article'];
        $uId = $_POST['identity'];
        $callModel = model('Content');
        $completeCheck = $callModel->checkContent($title, $content, $uId, $author);
        if ($completeCheck['code'] === false) {
            $this->error($completeCheck['msg']);
        }else{
            $this->success($completeCheck['code']);
        }
    }


    // 退出
    public function logout () {
        Session::clear();
        $this->success(true);
    }
}