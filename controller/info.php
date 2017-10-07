<?php
/**
 * Created by PhpStorm.
 * User: haier
 * Date: 2017-9-1
 * Time: 14:05
 */
require "../model/Thing.class.php";


function getList($database){
    $table = "checkform";
    $data = $database->select($table,[
        "name",
        "description",
        "otherInfo",
        "phone",
        "wechat"
    ],[
        "visible" => 1
    ]);
   // var_dump($data);
    if(!is_array($data)){
        return null;
    }else{
        unset($thingList);
        $thingList= array();
        foreach ($data as $d){
            $name = $d["name"];
            $description = $d["description"];
            $otherInfo = $d["otherInfo"];
            $phone = $d["phone"];
            $wechat = $d["wechat"];
            $thing = new Thing($name,$description,$otherInfo,$phone,$wechat);
            $thingList[] = $thing;
        }
        shuffle($thingList);
        $thingList = array_slice($thingList,0,10);
        return $thingList;
    }
}