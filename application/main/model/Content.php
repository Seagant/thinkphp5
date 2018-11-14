<?php

namespace app\main\model;

use think\Model;
use think\Db;

class Content extends Model{
    
    // 检查标题和内容
    public function checkContent($title, $content, $id, $author) {
        if (empty($title) || empty($content)) {
            return ['code' => false, 'msg' => '不能为空'];
        }else if(mb_strlen($title) > 25){
            return ['code' => false, 'msg' => '标题不能超过25个字'];
        }else if(mb_strlen($content) < 10){
            return ['code' => false, 'msg' => '内容不能少于10个字'];
        }else if(mb_strlen($content) > 300){
            return ['code' => false, 'msg' => '内容不能超过300个字'];
        }else{
            $data = [
                'title' => $title,
                'content' => $content,
                'uid' => $id,
                'author' => $author,
                'create_time' => date("Y-m-d H:i:s")
            ];
            $saveInfo = Db::name('article')->insert($data);
            return ['code' => true, 'msg' => '发布成功'];
        }
    }
}