<?php
/**
 * Description:
 * Created by PhpStorm
 * Author: nical
 * DateTime: 2024/4/17 19:01
 */

namespace app\index\traits;

trait LogTraits
{

    public $logPath;

    public function __construct(){


    }


    /**
     * Description:日志记录格式
     * DateTime:2024/4/18 15:46
     * Author:nical
     * @param $account
     * @param $type
     * @return string
     */
    private function _format($account,$type='')
    {
        $title = "\r\n       当前时间       |  账户ID  |       账户创建时间       |        账户登陆时间        |        操作类型        |        IP        \r\n";
        $content =
            date("Y-m-d H:i:s") .
            '      ' .
            $account .
            '         ' .
            date("Y-m-d H:i:s") .
            "      " .
            date("Y-m-d H:i:s") .
            '              ' .
            "$type" .
            '                ' .
            $_SERVER['REMOTE_ADDR'];

        return $title . $content . "\r\n------------------------ --------------------------\r\n";
    }

    /**
     * Description:日志记录
     * DateTime:2024/4/18 15:46
     * Author:nical
     * @param $account
     * @param $type
     * @param $dir 设定目录
     * @return void
     */
    public function record($account,$type,$dir='tlogs') {
        $max_size = 30000000;
        $logPath = RUNTIME_PATH . $dir . '/' . date('Ym') . '/';
        createDirectoryRecursively($logPath);
        $log_filename = $logPath . date('d') . ".log";

        if (file_exists($log_filename) && (abs(filesize($log_filename)) > $max_size)) {
            rename($log_filename, dirname($log_filename) . DS . date('Ym-d-His') . '_'.rand(0,100000)  . ".log");
        }
        file_put_contents($log_filename, $this->_format($account,$type), FILE_APPEND);
    }


}