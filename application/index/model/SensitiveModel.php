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

class SensitiveModel extends Model
{

    use HelperTraits;
    protected $table = 'think_sensitive';




}