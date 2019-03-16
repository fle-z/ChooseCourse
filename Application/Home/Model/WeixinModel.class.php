<?php
namespace Home\Model;
use Think\Model;

class WeixinModel extends Model{
    public function reponseMsg(){

    }

    public function tuwen($postObj, $arr){
        $toUser   = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;
        $time  = time();
        $msgType = 'news';
        $template = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <ArticleCount>".count($arr)."</ArticleCount>
                        <Articles>";
        foreach($arr as $k => $v){
        $template .=    "<item>
                            <Title><![CDATA[".$v['title']."]]></Title>
                            <Description><![CDATA[".$v['description']."]]></Description>
                            <PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>
                            <Url><![CDATA[".$v['url']."]]></Url>
                        </item>";
        }
        $template .=    "</Articles>
                    </xml>";

        echo sprintf($template, $toUser, $fromUser, $time, $msgType);
    }//tuwen end

    public function text($postObj, $content){
        $toUser   = $postObj->FromUserName;
        $fromUser = $postObj->ToUserName;
        $time  = time();
        $msgType = 'text';
        $template = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                    </xml>";
        echo sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
    }

}
?>
