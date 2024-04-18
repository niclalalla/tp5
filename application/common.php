<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


//判断目录是否存在 不存在则创建
function createDirectoryRecursively($dirPath, $permissions = 0755) {
    // Check if the directory already exists
    if (is_dir($dirPath)) {
        // Directory exists; no need to create it
        return true;
    }
    // Attempt to create the directory
    if (mkdir($dirPath, $permissions, true)) {
        // Directory created successfully
        return true;
    } else {
        // Failed to create the directory
        return false;
    }
}