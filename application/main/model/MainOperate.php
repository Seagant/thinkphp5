<?php

namespace app\main\model;

use think\Model;
use think\Session;
use think\Db;

class MainOperate extends Model{

    
    // 通过Session获取该用户的信息
    public function getUserInfo($getSessionName) {
        $info = Db::name('admin')->where('username', $getSessionName)->field('nickname,username')->find();
        return $info;
    }

    // 获取所有有效的文章进行分页
    public function getArticle() {
        $article = Db::name('article')->where('status', 1)->order('create_time desc')->paginate(9);
        return $article;
    }


    // 显示选中文章的内容
    public function getCheckPage($id) {
        $findPage = Db::name('article')->where('id', $id)->find();
        return $findPage;
    }


    // 删除文章
    public function delArticle($id) {
        $change = Db::name('article')->where('id', $id)->update(['status' => 0]);
        if (!$change) {
            return ['code' => false, 'msg' => '删除失败'];
        }else{
            return ['code' => true, 'msg' => '删除成功'];
        }
    }
}