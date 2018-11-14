<?php

namespace app\main\controller;

use think\Controller;
use think\Session;
use app\main\model\MainOperate;
use think\Db;

class Main extends Controller{

    // 检查是否有Session
    public function check() {
        if (!$this->getSessionName()){
            $this->error('请先去登录','MessageBoard/public/main/Main/index');
        }
    }

    // 获取Session的存储
    public function getSessionName() {
        $name = Session::get('name');
        return $name;
    }

    // 主界面
    public function index() {
        $callModel = model('MainOperate');
        $info = $callModel->getUserInfo($this->getSessionName());
        $article = $callModel->getArticle();
        $page = $article->render();
        $this->assign('list', $article);
        $this->assign('page', $page);
        return $this->fetch('main', [
            'nickname' => $info['nickname']
        ]);
    }

    // 浏览界面
    public function browse() {
        $this->check();
        $id = $_GET['id'];
        if (empty($id)) {
            $this->error("页面错误", 'MessageBoard/public/main/Main/index');
        }else{
            $checkId = Db::name('article')->where('id', $id)->field('id')->find();
            if (!$checkId) {
                $this->error("错误", 'MessageBoard/public/main/Main/index');
            }
        }
        $callModel = model('MainOperate');
        $info = $callModel->getUserInfo($this->getSessionName());
        $findPage = $callModel->getCheckPage($id);
        $this->assign('article', $findPage);
        return $this->fetch('browse', [
            'nick' => $info['nickname'],
            'name' => $info['username']
        ]);
    }


    // 删除文章
    public function delPage() {
        $getPid = $_SERVER["QUERY_STRING"];
        $pid = substr($getPid, 3);
        $callModel = model('MainOperate');
        $info = $callModel->delArticle($pid);
        if ($info['code'] === false) {
            $this->error($info['msg']);
        }else{
            $this->success($info['msg']);
        }
    }


    // 退出
    public function logout() {
        Session::clear();
        $this->success(true);
    }
}