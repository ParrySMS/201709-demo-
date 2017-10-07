<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-9-1
 * Time: 13:34
 */


require "../config/database_info_local.php";//数据库配置
require "../controller/json.php";//发送json模块
require "../controller/safe.php";//安全检查模块
require "../controller/decrypt.php";
require "../controller/info.php";
require "../model/medoo.php";//数据库框架

date_default_timezone_set('Asia/Shanghai');
$database = new medoo(array("database_name" => DATABASE_NAME));

if ($_GET == null || !is_array($_GET)) {
    JsonPrint(400, "get null", null);
} else {
    $token = isset($_GET["token"]) ? $_GET["token"] : null;
    $token = safe_check($token);
    if(!isVaildToken($token)){
        JsonPrint(400, "token is not vaild", null);
    }else{
        $list = getList($database);
        if(is_null($list)){
            JsonPrint(500, "get list error", null);
        }else{
            JsonPrint(200, null,$list);
        }

    }
}
