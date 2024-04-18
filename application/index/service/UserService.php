<?php
/**
 * Description:
 * Created by PhpStorm
 * Author: nical
 * DateTime: 2024/4/17 17:25
 */

namespace app\index\service;

use app\index\model\SensitiveModel;
use app\index\model\UserBlackModel;
use app\index\model\UserModel;
use app\index\traits\HelperTraits;
use app\index\traits\LogTraits;
use think\Exception;
use think\facade\Cache;

class UserService extends BaseService
{
    use HelperTraits,LogTraits;
    private $userTokenPrefix = 'tp5_';
    private $userTokenExpire = 3600;


    private $activeUserPrefix = 'tp5_activeUser';
    private $activeUserExpire = 60*60*24*30; //活跃用户缓存时间

    private $blackUserPrefix = 'tp5_blackUser';
    private $blackUserExpire = 60*60*24*30; //活跃用户缓存时间

    private $sensitiveWordsPrefix = 'tp5_sensitiveWords';

    public function __construct()
    {
    }

    public function register($username,$password)
    {

        try {

            $password = $this->hashPassword($password);
            $userId = (new UserModel())->insertGetId([
                'username' => $username,
                'password' => $password,
                'created_at' => date("Y-m-d H:i:s")
            ]);

        }catch (Exception $e){
            return $e->getMessage();
        }

        $usernameArray = Cache::store('redis')->get(UserModel::PREFIX_USERNAME);
        $usernameArray[] = $username;
        Cache::store('redis')->set(UserModel::PREFIX_USERNAME,$usernameArray);

        $this->record($userId ,'注册');

        return true;
    }





    /**
     * Description:获取用户token
     * DateTime:2024/4/18 11:06
     * Author:nical
     * @param $username
     * @return mixed|string
     */
    public function getToken($username)
    {
        if ($token = Cache::store('redis')->get($this->userTokenPrefix . $username)){
            return $token;
        }
        $token = $this->createToken($username);
        //存放缓存
        Cache::store('redis')->set($this->userTokenPrefix . $username, $token, $this->userTokenExpire);
        return $token;
    }

    public function login($username,$password): bool
    {

        $activeUser = Cache::store("redis")->get($this->activeUserPrefix.$username);
        if ($activeUser){
            return $this->hashPassword($password) == $activeUser->password;
        }
        $user = (new UserModel())->hasUser($username, $password);
        if (!$user){
            return false;
        }
        Cache::store("redis")->set($this->activeUserPrefix.$username,$user,$this->activeUserExpire);

        $content = date("Y-m-d H:i:s") . '      ' . "1" . '         ' . date("Y-m-d H:i:s") . "      " . date("Y-m-d H:i:s") . '              ' . "登录" . '                ' . $_SERVER['REMOTE_ADDR'];
        $this->record( $user->id ,'登录');

        return true;
    }



    //用户黑名单验证
    public function checkIsBlack($username)
    {
        return Cache::store("redis")->get($this->blackUserPrefix.$username);
    }


    public function initBlackList(): bool
    {
        $blackList = (new UserModel())->where("status",UserModel::STATUS_BANNED)->select();
        foreach ($blackList as $v){
            $expire = strtotime($v->ban_until) - time();
            if ($expire <= 0)
                continue;
            Cache::store("redis")->set($this->blackUserPrefix . $v->username,$v,$expire);
        }
        return true;
    }

    public function initSensitiveList(): bool
    {
        $data = SensitiveModel::all();
        $data = collection($data)->toArray();
        $data = array_column($data,'words');
        Cache::store("redis")->set($this->sensitiveWordsPrefix,$data);
        return true;
    }




}