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

include_once("base.php") ;
class Index extends Base
{
    /**
    * 截取子级模板标签内的字符串替换父级模板生成新模板文件
    * @access public
    * @param string $template        子模板名称
    * @return string                  打印生成的文本内容
    * 此方法由@Albafica 提供
    * @date 2017-2-20
    * @页面需要加载JS
    * <script src="http://cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
    * <script src="assets/plugins/master.js"></script>
    */
    public function master($template)
    {
        $p1 = new Base();
        $config = $p1 -> config();
        $son_path = $config['sub_template'].$template;
        $son_file = file_get_contents($son_path);
        preg_match_all("#\{\S*(extend)([ ]+)(name=)([ ]*)([\"']?)([ ]*)(\w+)([ ]*)([\"']?)([ ]*)(\/)\}#",$son_file,$extend);
        $master_path = $config['root_directory'].'master/'.strtolower($extend[7][0]).'.'.$config['view_suffix'];
        if (!file_exists($master_path)) {
            echo '选择的父级模板文件不存在';exit;
        } else {
            $master_file = file_get_contents($master_path);
            preg_match_all("/\{\S*(".$config['view_label'].")([ ]+)(name=)([ ]*)([\"']?)([ ]*)(\w+)([ ]*)([\"']?)([ ]*)\}/",$master_file,$matchs);
            $master_arr=[];
            foreach ($matchs[0] as $v) {
                $con_str = strstr($master_file, $v);
                $block_num = strpos($con_str,$v);
                $block_end_num = strpos($con_str,'{/'.$config['view_label'].'}');
                $master_arr[]= substr($con_str,$block_num+strlen($v),$block_end_num-$block_num-strlen($v));
            }
            $arr=array_combine($matchs[7],$master_arr);
            $fileName = $config['root_directory'].'temp/'.$template;
            file_put_contents($fileName, $master_file);
            foreach ($arr as $k=> $v) {
                if (empty(strpos($son_file,$k))) {
                    echo '';
                } else {
                    preg_match_all("#\{\S*(".$config['view_label'].")([ ]+)(name=)([ ]*)([\"']?)([ ]*)(".$k.")([ ]*)([\"']?)([ ]*)\}.*?\{\/block\}#ism",$son_file,$son);
                    foreach ($son[0] as  $value) {
                        if ($son[7][0]==$k) {
                            $tem_file = file_get_contents($fileName);
                            $msg = preg_replace("#\{\S*(".$config['view_label'].")([ ]+)(name=)([ ]*)([\"']?)([ ]*)(".$k.")([ ]*)([\"']?)([ ]*)\}.*?\{\/block\}#ism",$value,$tem_file);
                            file_put_contents($fileName, $msg);
                        }
                    }
                }
            }
            //去掉多余标签
            $con_file = file_get_contents($fileName);
            $msgb = preg_replace("/\{\S*(".$config['view_label'].")([ ]+)(name=)([ ]*)([\"']?)([ ]*)(\w+)([ ]*)([\"']?)([ ]*)\}/",'',$con_file);
            file_put_contents($fileName, $msgb);
            $con_file2 = file_get_contents($fileName);
            $msgc = preg_replace("/\{\S*(\/)(".$config['view_label'].")\}/",'',$con_file2);
            file_put_contents($fileName, $msgc);
            echo  file_get_contents($fileName);
        }
    }
}
$p1 =new Index();
if (empty($_GET['temp'])) {
    echo '页面访问出错';
} else {
    $p1 -> master($_GET['temp']);
}