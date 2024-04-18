<?php
/**
 * Description:
 * Created by PhpStorm
 * Author: nical
 * DateTime: 2024/4/17 17:34
 */

namespace app\index\controller;

use app\index\service\UserService;
use app\index\traits\ResponsTraits;
use think\Cache;
use think\Loader;
class UserController extends BaseController
{

    use ResponsTraits;




    public function register()
    {
        $username = input("post.username");
        $password = input("post.password");



        $validate = Loader::validate('UserValidate');

        if(!$validate->scene("register")->check([
            'username' => $username,
            'password' => $password
        ])){
            return $this->error($validate->getError());
        }

        if ((new UserService())->register($username, $password) !== true) {
            return $this->error('注册失败');
        }

        $token = (new UserService())->getToken($username);
        return $this->success(array('token' => $token));

    }



    public function login(){
        $username = input("post.username");
        $password = input("post.password");

        $validate = Loader::validate('UserValidate');

        if(!$validate->scene("login")->check([
            'username' => $username,
            'password' => $password
        ])){
            return $this->error($validate->getError());
        }
        if ($black = (new UserService())->checkIsBlack($username))
            return $this->error('您的账号已被禁用至' . $black->ban_until);

        if (!(new UserService())->login($username,$password))
            return $this->error('用户名或密码错误');


        $token = (new UserService())->getToken($username);
        return $this->success(array('token' => $token));
    }

    public function setblack(){

        (new UserService())->initBlackList();
        return $this->success();
    }

    public function setsensitiveWords(){

        (new UserService())->initSensitiveList();
        return $this->success();
    }


}