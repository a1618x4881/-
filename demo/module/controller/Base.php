<?php
namespace controller;
// +----------------------------------------------------------------------
// | Albafica [ It is not easy to meet each other in such a big world. ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017-2027 http://www.annphp.com All rights reserved.
// +----------------------------------------------------------------------
// | Website ( http://www.annphp.com )
// +----------------------------------------------------------------------
// | Author: Albafica <281291514@qq.com>
// +----------------------------------------------------------------------

// [ 模板处理文件 ]


class Base
{
     function  __construct()
    {

    }

    /**
    * 方法
    * 此方法由@Albafica 提供
    * @date 2017-2-20
    */
    public function config()
    {
       return include '../config.php';
    }

}
// $p1 = new Base();
// print_r($p1 -> config());