<?php
/**
 * Created by IntelliJ IDEA.
 * User: philip.feldman
 * Date: 4/20/2018
 * Time: 10:23 AM
 */

/***************************** INFO FUNCTIONS ************************/
function getBrowserInfo(){
    $browserData = array();
    $ip = htmlentities($_SERVER['REMOTE_ADDR']);
    $browser = htmlentities($_SERVER['HTTP_USER_AGENT']);
    $referrer = "No Referrer";
    if(isset($_SERVER['HTTP_REFERER'])) {
        //do what you need to do here if it's set
        $referrer = htmlentities($_SERVER['HTTP_REFERER']);
        if($referrer == ""){
            $referrer = "No Referrer";
        }
    }
    $browserData["ipAddress"] = $ip;
    $browserData["browser"] = $browser;
    $browserData["referrer"] = $referrer;

    return $browserData;
}

function getPostInfo()
{
    $postInfo = array();
    $jsonBlob = json_decode(trim(file_get_contents("php://input")), true);
    if ($jsonBlob != null) {
        foreach ($jsonBlob as $key => $value) {
            if (strlen($value) < 10000) {
                $postInfo[$key] = $value;
            } else {
                $postInfo[$key] = "string too long";
            }
        }
    }
    return $postInfo;
}

function getGetInfo(){
    $getInfo = array();
    foreach($_GET as $key => $value) {
        if(strlen($value) < 10000) {
            $getInfo[$key] = $value;
        }else{
            $getInfo[$key] = "string too long";
        }
    }
    return $getInfo;
}

/**************************** MAIN ********************/
$toReturn = array();
$toReturn['getPostInfo'] = getPostInfo();
$toReturn['getGetInfo'] = getGetInfo();
$toReturn['browserInfo'] = getBrowserInfo();
$toReturn['time'] = date("h:i:sa");
$jstr =  json_encode($toReturn);
echo($jstr);