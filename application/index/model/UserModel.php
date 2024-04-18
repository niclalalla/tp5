<?php
/**
 * Description:
 * Created by PhpStorm
 * Author: nical
 * DateTime: 2024/4/18 11:18
 */

namespace app\index\model;

use app\index\traits\HelperTraits;
use think\Model;

class UserModel extends Model
{

    use HelperTraits;
    protected $table = 'think_user';


    const PREFIX_USERNAME = 'usernameArray';

    const STATUS_NORMAL = 0;
    const STATUS_BANNED = 1;

    public function hasUser($username,$password)
    {
        //
        return self::where("username", "=", $username)
            ->where("password", "=", $this->hashPassword($password))
            ->find();
    }

}