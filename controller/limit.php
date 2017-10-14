<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-9-18
 * Time: 11:27
 */
define("LIMIT", 35);
define("TIME",15);
date_default_timezone_set('Asia/Shanghai');

function accessLimit($stu_id, $username, $token,$ip,$database)
{
    $table = "kcb_user";
    $md5_openid = tokenDecrypt($token, $database);
    if(is_null($md5_openid)){
        return false;
    }

    $num = $database->count($table, [
        "AND" => [
            "md5_openid" => $md5_openid,
            "time[>]" => date("Y-m-d H:i:s", time()-TIME*60),
            "visible" => 1
        ]
    ]);

    $num2 = $database->count("login_log", [
        "AND" => [
            "ip" => $ip,
            "time[>]" => time() - TIME*60,
        ]
    ]);

    $insert = $database->insert($table, [
        "md5_openid" => $md5_openid,
        "stu_id" => $stu_id,
        "username" => $username,
        "time" => date("Y-m-d H:i:s", time()),
        "visible" => 1
    ]);
   // return $num;
//    var_dump($num);
    return ($num < LIMIT && $num2 < LIMIT)? true : false;
}
