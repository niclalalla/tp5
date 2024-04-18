<?php
/**
 * Description:
 * Created by PhpStorm
 * Author: nical
 * DateTime: 2024/4/17 19:01
 */

namespace app\index\traits;

trait ResponsTraits
{




    public static function success($data = [], $msg = 'success', $code = 200): \think\response\Json
    {
        return json([
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ]);
    }


    public static function error($msg = 'error', $code = 400)
    {
        return json([
            'code' => $code,
            'msg' => $msg,
            'data' => []
        ]);
    }




}