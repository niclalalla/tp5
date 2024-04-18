<?php
/**
 * Description:
 * Created by PhpStorm
 * Author: nical
 * DateTime: 2024/4/17 19:01
 */

namespace app\index\traits;

trait HelperTraits
{

    private $secretKey = 'tp5_user_key';


    public function createToken($username): string
    {
        //使用JWT创建token
//        $token = \Firebase\JWT\JWT::encode($username, $this->secretKey);
        return hash_hmac('sha256', $username.microtime(), $this->secretKey); // 使用HMAC-SHA256生成签名
    }


    public function hashPassword($password)
    {
        return hash_hmac('sha256', $password, $this->secretKey); // 使用HMAC-SHA256生成签名
    }




}