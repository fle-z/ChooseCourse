<?php
namespace Home\Controller;
use Think\Controller;

define("APPID", "wxeac48b26f2902b2d");
define("APPSECERT", "1779a55e61a977a6fd2267ccea520458");

class WeixinController extends Controller{
    function _initialize(){
      	header("Content-type:text/html;charset=utf-8");
     }

    public function index(){
        //获得参数signature nonce token timestamp echostr
        $nonce     = $_GET['nonce'];
        $token     = 'weixin';
        $timestamp = $_GET['timestamp'];
        $echostr   = $_GET['echostr'];
        $signature = $_GET['signature'];
        //形成数组，然后按字典序排序
        $array = array();
        $array = array($nonce, $timestamp, $token);
        //拼接成字符串，用啥sha1加密，然后与signature进行校验
        $str = sha1(implode($array));
        //第一次关注时(接入微信API)会传一个echostr，后面都没有
        if($str == $signature && $echostr){
            echo $echostr;
            exit;
        } else {
            $this->reponseMsg();
        }
    }

    //接收事件推送并回复
    public function reponseMsg(){
        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        $postObj = simplexml_load_string($postArr);
        $weixinModel = D('Weixin');
        $click = 1;//根据下面按钮的点击，控制该功能的执行与否；1表示开启第一个按钮的功能该功能，0表示开启第三个按钮的功能
        //接收事件
        if(strtolower($postObj->MsgType) == 'event'){
            if(strtolower($postObj->Event) == 'subscribe'){
                $content  = '无量天尊    哈利路亚    阿弥陀佛么么哒';
                $weixinModel->text($postObj, $content);
            }

            if(strtolower($postObj->Event) == 'click'){
                switch(strtolower($postObj->EventKey)){
                    case 'xms':
                        $content = '主人，你好！';
                        $click = 1;
                        break;
                    case 'tqcx':
                        $content = '请输入相应的城市名！';
                        $click = 0;
                        break;
                    default:
                        $content = '本系统还在完善当中...'."\n".'无量天尊    哈利路亚    阿弥陀佛么么哒';
                }
                $weixinModel->text($postObj, $content);
            }
        }

        //接收文本消息
        if(strtolower($postObj->MsgType) == 'text'){
            switch($click){
                case 1:
                        $url = 'http://apis.baidu.com/turing/turing/turing?key=5700b72879484653965cbe25b5643c20&info='.urlencode(trim($postObj->Content));
                    break;
                case 0:
                    $url = 'http://apis.baidu.com/apistore/weatherservice//cityname?cityname='.urlencode(trim($postObj->Content));
                    break;
            }
            $ch = curl_init();
            $header = array(
                'apikey: fcb896fb7bb914425d9d7ea0c57265a0',
            );
            // 添加apikey到header
            curl_setopt($ch, CURLOPT_HTTPHEADER , $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // 执行HTTP请求
            curl_setopt($ch , CURLOPT_URL, $url);
            $res = curl_exec($ch);

            $arr = json_decode($res, ture);

            if($arr['errMsg'] == "success"){
                if($click = 0){
                    $content = "城市名称：".$arr['retData']['city']."\n".
                               "日期：".$arr['retData']['date']."\n".
                               "海拔：".$arr['retData']['altitude']."\n".
                               "天气情况：".$arr['retData']['weather']."\n".
                               "最低气温：".$arr['retData']['l_tmp']."\n".
                               "最高气温：".$arr['retData']['h_tmp'];
                } else {
                    var_dump($arr);
                }
            }
            $weixinModel->text($postObj, $content);
        }

        //发送图文消息
        if(strtolower($postObj->MsgType) == 'voice'){
            $arr = array(
                array(
                    'title' => 'imooc',
                    'description' => "imooc is very good",
                    'picUrl' => 'http://www.imooc.com/static/img/common/logo.png',
                    'url' => "http://www.imooc.com"
                ),
            );
            $weixinModel->tuwen($postObj, $arr);
        }
    }//reponseMsg end


    /**
    *请求接口
    *$url 接口url string
    *$type 请求类型 string
    *$res 返回数据类型string
    *$arr post请求参数 string
    */
    function http_curl($url, $type='get', $res='json', $arr=''){
        //1.初始化curl
        $ch = curl_init();
        //2.设置curl参数
        curl_setopt($ch, CURLOPT_URL, $url);    //Set an option for a CURL transfer

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        if($type == 'post'){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr); // Pass a string containing the full data to post in an HTTP "POST" operation.
        }
        //3.采集
        $output = curl_exec($ch);
        //4.关闭
        curl_close($ch);

        if($res == 'json'){
            if(curl_errno($ch)){
                //请求失败返回错误信息
                return curl_error($ch);
            }else{
                //请求成功
                return json_decode($output, true);
            }
        } else {
            return $output;
        }
    }//http_curl end

    //获取access_token，并存在session中，也可以村在mysql中
    function getAccessToken(){
        if($_SESSION['access_token'] && $_SESSION['expire_time'] > time()){
            return $_SESSION['access_token'];
        } else {
            $appid = APPID;
            $appsecret = APPSECERT;
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;

            $res = $this->http_curl($url, 'get', 'json');
            $access_token = $res['access_token'];
            $_SESSION['access_token'] = $access_token;
            $_SESSION['expire_time'] = time()+7000;
            return $access_token;
        }
    }//getAccessToken end

    public function definedItem(){
        $accessToken = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$accessToken;
        $postArr = array(
            'button'=>array(
                array(
                    'type'=>'click',
                    'name'=>urlencode("小秘书"),
                    'key'=>'xms',
                ),    //第一个一级菜单
                array(
                    'name'=>urlencode('菜单'),
                    'sub_button'=>array(
                        array(
                            'type'=>'view',
                            'name'=>urlencode('搜索'),
                            'url'=>'http://www.soso.com/',
                        ),  //第一个二级菜单
                        array(
                            'type'=>'view',
                            'name'=>urlencode('视频'),
                            'url'=>'http://v.qq.com/',
                        ),  //第二个二级菜单
                        array(
                            'type'=>'click',
                            'name'=>urlencode('点赞'),
                            'key'=>'good',
                        ),  //第三个二级菜单
                    ),
                ),    //第二个一级菜单
                array(
                    'type'=>'click',
                    'name'=>urlencode('天气查询'),
                    'key'=>'tqcx',
                ),    //第三个一级菜单
            ),
        );
        //var_dump($postArr);
        $postJson = urldecode(json_encode($postArr));
        $res = $this->http_curl($url, 'post', 'json', $postJson);
        //var_dump($res);
    }//definedItem end

    public function sendMsgAll(){
        $accessToken = $this->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$accessToken;
        $arr = array(
            'touser'     => array('ozQWLv8Ofu_xIioDTRCrunJVM4l8', 'ozQWLvzI0IIE5nxfWeQ4hwdjY-Hk'),
            'text'     => array('content' =>urlencode('陈瑞，你在干嘛')),
            'msgtype'    => 'text'
        );
        $postJson = urldecode(json_encode($arr));
        //var_dump($postJson);
        $res = $this->http_curl($url, 'post', 'json', $postJson);
        //var_dump($res);
    }//sendMsgAll end

    //还没有实现的素材上传功能
    function uploadImage(){
        $accessToken = $this->getAccessToken();
        $type = 'image';
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$accessToken."&type=".$type;
        $file = "/var/www/html/ChooseCourse/Application/Home/View/Index/sun.png";
        $postArr = array(
            'media' => "@".$file,
        );
        echo $postJson = json_encode($postArr);
        $res = $this->http_curl($url, 'post', 'json', $postJson);
        var_dump($res);
    }//uploadImage

    function setIndustry(){
        $accessToken = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=".$accessToken;
        $Postarr = array(
            'industry_id1' => "1",
            'industry_id1' => "18"
        );
        $postJson = json_encode($postArr);
        $res = $this->http_curl($url, 'post', 'json', $postJson);
    }

    function sendTemplateMsg(){
        $accessToken = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$accessToken;
        $arr = array(
            'touser' => 'ozQWLv8Ofu_xIioDTRCrunJVM4l8',
            'template_id' => '_i5MDqZnAureL2dy-t8iQsU1xLvhMrxZ4cS0Plzyx9c',
            'url' => 'http://www.imooc.com',
            'data' => array(
                'name' => array('value'=>'hello', 'color'=>"#000000"),
                'money' => array('value'=>100,'color'=>"#000000"),
                'date' => array('value'=>date('Y-m-d H:i:s'), 'color'=>"#000000")
            )
        );
        $postJson = json_encode($arr);
        $res = $this->http_curl($url, 'post', 'json', $postJson);
        //var_dump($res);
    }

    //用户同意授权，获取code
    //可以将连接生成二维码，用微信扫描即可得到传回的数据
    function getCode(){
        $appId = APPID;
        $redirect_uri = urlencode("http://121.196.200.57/ChooseCourse/index.php/Weixin/getBaseInfo");
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appId."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
        header('location:'.$url);

    }

    //通过code换取网页授权access_token,并获取用户基本信息
    function getBaseInfo(){
        $appId = APPID;
        $appSecret = APPSECERT;
        $code = $_GET['code'];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appId."&secret=".$appSecret."&code=".$code."&grant_type=authorization_code";
        $res = $this->http_curl($url);
        //return $res['openid'];
        var_dump($res);
    }

    //用户同意授权，获取code
    function getDetailCode(){
        $appId = APPID;
        $redirect_uri = urlencode("http://121.196.200.57/ChooseCourse/index.php/Weixin/getDetailInfo");
        echo $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appId."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        //header('location:'.$url);
        echo '<script language="JavaScript" type="text/javascript">
           window.location.href="'.$url.'";
         </script>';
    }

    //拉取用户详细信息
    function getDetailInfo(){
        $appId = APPID;
        $appSecret = "1779a55e61a977a6fd2267ccea520458";
        $code = $_GET['code'];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appId."&secret=".$appSecret."&code=".$code."&grant_type=authorization_code";
        $res = $this->http_curl($url);
        var_dump($res);
        $accessToken = $res['access_token'];
        $openId = $res['openid'];

        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$accessToken."&openid=".$openId."&lang=zh_CN";
        $res = $this->http_curl($url);
        var_dump($res);
    }

    //获取jsapi_ticket,并用session保存
    function getJsapiTicket(){
        if($_SESSION['jsapi_ticket'] && $_SESSION['jsapi_ticket_expire_time']>time()){
            $jsapi_ticket = $_SESSION['jsapi_ticket'];
        } else {
            $accessToken = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$accessToken."&type=jsapi";
            $res = $this->http_curl($url);
            $jsapi_ticket = $res['ticket'];
            $_SESSION['jsapi_ticket'] = $jsapi_ticket;
            $_SESSION['jsapi_ticket_expire_time'] = time()+7000;
        }
        return $jsapi_ticket;
    }

    //获取16位随机码
    function getRandCode($num = 16){
        $array = array(
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
            '1','2','3','4','5','6','7','8','9','0'
        );
        $tmpstr = '';
        $max = count($array);
        for($i = 1; $i <= $num; $i++){
            $key = rand(0, $max-1);
            $tmpstr .= $array[$key];
        }
        return $tmpstr;
    }

    function shareWX(){
        $jsapi_ticket = $this->getJsapiTicket();
        $timestamp    = time();
        $nonceStr     = $this->getRandCode();
        //$openid       = $this->getCode();
        //$url = "http://121.196.200.57/ChooseCourse/index.php/Weixin/shareWX";
        $protocol     = (!empty($_SERVER[HTTPS]) && $_SERVER[HTTPS] !== off || $_SERVER[SERVER_PORT] == 443) ? "https://" : "http://";
        $url          = $protocol.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
        $string1      = "jsapi_ticket=".$jsapi_ticket."&noncestr=".$nonceStr."&timestamp=".$timestamp."&url=".$url;
        $signature    = sha1($string1);

        $mapjson = array(
            'appid'        => APPID,
            'signature'    => $signature,
            'nonceStr'     => $nonceStr,
            'timestamp'    => $timestamp,
            'open_id'       => 'ozQWLv8Ofu_xIioDTRCrunJVM4l8',
            'jsapi_ticket' => $jsapi_ticket,
            'access_token' => $this->getAccessToken()
        );

        $this->assign('mapjson', $mapjson);
        $this->display('Index/weixin');
    }

    function getServerIP(){
        $accessToken = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$accessToken;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $res = curl_exec($ch);
        curl_close($ch);

        if(curl_errno($ch)){
            var_dump(curl_error($ch));
        }
        $arr = json_decode($res, ture);
        var_dump($arr);
    }//getServerIP end

    //获取临时二维码
    function getQrCode(){
        $accessToken = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$accessToken;
        $postArr = array(
            'expire_second'=>604800,    //24*60*60*7
            'action_name'=>"QR_SCENE",
            'action_info'=>array(
                'scene'=>array('scene_id'=>2000),
            ),
        );
        $postJson = json_encode($postArr);
        $res = $this->http_curl($url, 'post', 'json', $postJson);
        $ticket = $res['ticket'];

        $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
        echo "<img src='".$url."'/>";
    }//getQrCode end

}//class end
 ?>
