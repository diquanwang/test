<?php

/**

  * wechat php test

  */

//define your token
header("Content-type:text/html;charset=utf-8");
define("TOKEN", "diquanwang");

$wechatObj = new wechatCallbackapiTest();

//$wechatObj->valid();
$wechatObj->responseMsg();

class wechatCallbackapiTest

{

public function valid()

    {

        $echoStr = $_GET["echostr"];

        //valid signature , option

        if($this->checkSignature()){

        echo $echoStr;

        exit;

        }

    }

    public function responseMsg()

    {

//get post data, May be due to the different environments

$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      //extract post data

if (!empty($postStr)){

                

              $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

                $fromUsername = $postObj->FromUserName;

                $toUsername = $postObj->ToUserName;

                $keyword = trim($postObj->Content);

                $time = time();

                $textTpl = "<xml>

<ToUserName><![CDATA[%s]]></ToUserName>

<FromUserName><![CDATA[%s]]></FromUserName>

<CreateTime>%s</CreateTime>

<MsgType><![CDATA[%s]]></MsgType>

<Content><![CDATA[%s]]></Content>

<FuncFlag>0</FuncFlag>

</xml>";             

if(!empty( $keyword ))
{

              $msgType = "text";
              	/*switch($keyword){
              		case "你是":
              			$contentStr = "我是测试号(╥╯^╰╥)";
              			break;
              		case "abc":
              			$contentStr = "wertyu2qwertfg";
              			break;
              		default:
              			$contentStr ="欢迎来到测试号!!!!!!!!!!!!";
              	}*/
              	include_once "dytl.php";
              	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
               

                }else{

                echo "Input something...";

                }

        }else {

        echo "";

        exit;

        }

    }

private function checkSignature()

{

        $signature = $_GET["signature"];

        $timestamp = $_GET["timestamp"];

        $nonce = $_GET["nonce"];

       

$token = TOKEN;

$tmpArr = array($token, $timestamp, $nonce);

sort($tmpArr);

$tmpStr = implode( $tmpArr );

$tmpStr = sha1( $tmpStr );

if( $tmpStr == $signature ){

return true;

}else{

return false;

}

}

}

?>