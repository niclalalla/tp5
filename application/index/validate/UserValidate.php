<?php
/**
 * Description:
 * Created by PhpStorm
 * Author: nical
 * DateTime: 2024/4/17 17:32
 */

namespace app\index\validate;
use app\index\model\UserModel;
use think\Cache;
use think\Validate;

/**
 * 用户验证
 */
class UserValidate extends Validate
{
    protected $rule = [
        'username'  =>['require','length'=>'5,25'],
        'password' =>  'require',
    ];

    protected $message = [
        'username.require'  =>  '用户名必须',
        'username.length'  =>  '用户名长度必须在5-25个字符之间',
        'password.require' =>  '密码必须',
        'password.length' =>  '密码长度必须在10-20个字符之间',
    ];

    protected $scene = [
        'register'  =>  ['username'=>'checkSensitiveWords|checkUserNameUnique','password'=>'require|length:10,20'],
        'login' =>  ['username','password'],
    ];


    //检测敏感词
    protected function checkSensitiveWords($value,$rule,$data)
    {
        $sensitiveWords = Cache::store("redis")->get("sensitiveWords");
        if (!$sensitiveWords)
            return true;

        foreach ($sensitiveWords as $sensitiveWord){
            if (strpos($value,$sensitiveWord) !== false)
                return '用户名包涵敏感词,请重新注册';
        }

        return true;
    }


    protected function checkUserNameUnique($value,$rule,$data)
    {
        //检测用户名重复
        $usernameList = Cache::store("redis")->get(UserModel::PREFIX_USERNAME);
        if (!$usernameList)
            return true;

        if (in_array($value,$usernameList))
            return '用户名已存在';
        return true;

    }




}