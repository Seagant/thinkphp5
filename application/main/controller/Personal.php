<?php

namespace app\main\controller;

use think\Controller;
use think\Session;
use app\main\model\Person;

class Personal extends Controller{

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
    
    // 个人中心界面
    public function index() {
        $this->check();
        $callModel = model('Person');
        $info = $callModel->getUserInfo($this->getSessionName());
        $this->assign('infoList', $info);
        return $this->fetch('person/index', [
            'nick' => $info['nickname'],
            'name' => $info['username'],
            'infoTitle' => '个人信息'
        ]);
    }

    // 修改个人信息页面
    public function editPerson() {
        $this->check();
        $callModel = model('Person');
        $info = $callModel->getUserInfo($this->getSessionName());
        return $this->fetch('person/editPerson', [
            'nick' => $info['nickname'],
            'name' => $info['username'],
            'infoTitle' => '修改信息'
        ]);
    }

    // 检查传过来的旧密码
    public function oldPass() {
        $pass = $_POST['oldPass'];
        $callModel = model('Person');
        $result = $callModel->checkOldPass($pass);
        if ($result['code'] === false) {
            return $this->error($result['msg']);
        }else{
            return $this->success($result['code']);
        }
    }


    // post个人修改的信息
    public function referInfo() {
        $nick = $_POST['nickname'];
        $newPass = $_POST['newPass'];
        $resPass = $_POST['reNewPass'];
        $oldPass = $_POST['oldPass'];
        $callModel = model('Person');
        $result = $callModel->checkReferInfo($nick,$newPass,$resPass,$oldPass);
        if ($result['code'] === false) {
            $this->error($result['msg']);
        }else{
            $this->success($result['msg']);
        }
    }

    // 所有用户界面
    public function everybody() {
        $this->check();
        $callModel = model('Person');
        $info = $callModel->getUserInfo($this->getSessionName());
        $adminInfo = $callModel->getAdminList();
        $page = $adminInfo->render();
        $this->assign('list', $adminInfo);
        $this->assign('page', $page);
        return $this->fetch('person/every', [
            'nick' => $info['nickname'],
            'name' => $info['username'],
            'infoTitle' => '所有用户'
        ]);
    }

    // 拉黑
    public function adminDisable() {
        $id = $_POST['uid'];
        $callModel = model('Person');
        $result = $callModel->disableAdmin($id);
        if ($result['code'] === false) {
            $this->error($result['msg']);
        }else{
            $this->success($result['msg']);
        }
    }


    // 启用用户
    public function startAdmin() {
        $id = $_POST['uid'];
        $callModel = model('Person');
        $result = $callModel->start($id);
        if ($result['code'] === false) {
            $this->error($result['msg']);
        }else{
            $this->success($result['msg']);
        }
    }

    // 退出
    public function logout() {
        Session::clear();
        $this->success(true);
    }
}