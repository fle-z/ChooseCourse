<?php

namespace Common\Tag;
use Think\Template\TagLib;

class My extends TagLib {
		// 定义标签
		protected $tags=array(
				'jquery'=>array('attr'=>'','close'=>0),
				'animate'=>array('attr'=>'','close'=>0),
				'bootstrapcss'=>array('','close'=>0),
				'bootstrapjs'=>array('','close'=>0),
				'icheckcss'=>array('','close'=>0),
				'icheckjs'=>array('attr'=>'icheck','close'=>0),
				'ueditor'=> array('attr'=>'name,content','close'=>0),
				'recommend'=>array('attr'=>'limit','level'=>1)
				);

		//引入jquery
		public function _jquery(){
				return '<script type="text/javascript" src="__PUBLIC__/js/jquery-1.9.0.min.js"></script>';
		}

		//引入animate
		public function _animate(){
				return '<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/animate.css">';
		}

		/**
		* bootstrap的css部分
		*/
		public function _bootstrapcss($tag){
				$icheck=isset($tag['icheck']) ? $tag['icheck'] : 'blue';
				$link=<<<php
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/bootstrap-3.3.5/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/bootstrap-3.3.5/css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/font-awesome-4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="__PUBLIC__/css/bjy.css">
php;
				return $link;
		}

		/**
		* 引入jquery、bootstrap的js部分
		*/
		public function _bootstrapjs(){
				$link=<<<php
<script type="text/javascript" src="__PUBLIC__/js/jquery.min.js"></script>
<script>
(function(){
		var basePath='__PUBLIC__';
		window.jQuery || document.write('<script src="'+basePath+'/js/jquery-1.9.0.min.js"><\/script>');
})();
</script>
<script type="text/javascript" src="__PUBLIC__/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script type="text/javascript" src="__PUBLIC__/js/html5shiv.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript" src="__PUBLIC__/pace/pace.min.js"></script>
php;
				return $link;
		}

		/**
		* 引入ickeck的css部分
		*/
		public function _icheckcss(){
				$link=<<<php
		<link rel="stylesheet" href="__PUBLIC__/static/iCheck-1.0.2/skins/all.css">
php;
				return $link;
		}

		/**
		* 引入ickeck的js部分
		* @param string $tag	颜色主题
		*/
		public function _icheckjs($tag){
				$color=isset($tag['color']) ? $tag['color'] : 'blue';
				$link=<<<php
<script type="text/javascript" src="__PUBLIC__/static/iCheck-1.0.2/icheck.min.js"></script>
<script>
$(document).ready(function(){
		$('.icheck').iCheck({
				checkboxClass: "icheckbox_square-$color",
				radioClass: "iradio_square-$color",
				increaseArea: "20%"
		});
});
</script>
php;
				return $link;
		}

		/**
		* 引入ueidter编辑器
		* @param string $tag	name:表单name content：编辑器初始化后 默认内容
		*/
		public function _ueditor($tag){
				$name=isset($tag['name']) ? $tag['name'] : 'content';
				$content=isset($tag['content']) ? $tag['content'] : '';
				$link=<<<php
<script id="container" name="$name" type="text/plain">$content</script>
<script type="text/javascript" src="__PUBLIC__/static/ueditor1_4_3/ueditor.config.js"></script>
<script type="text/javascript" src="__PUBLIC__/static/ueditor1_4_3/ueditor.all.js"></script>
<script type="text/javascript">
		var ue = UE.getEditor('container');
</script>
php;
				return $link;
		}

		// 置顶推荐文章标签 cid为空时则抓取全部分类下的推荐文章
		public function _recommend($tag,$content){
				if(empty($tag['cid'])){
						$where="is_show=1 and is_delete=0 and is_top=1";
				}else{
						$where='is_show=1 and is_delete=0 and is_top=1 and cid='.$tag['cid'];
				}
				$limit=$tag['limit'];
				// p($recommend);
				$php=<<<php
<?php
						\$recommend=M('Article')->field('aid,title')->where("$where")->limit($limit)->select();
						foreach (\$recommend as \$k => \$field) {
								\$url=U('Home/Index/article',array('aid'=>\$field['aid']));
?>
php;
				$php.=$content;
				$php.='<?php } ?>';//foreach的回扩;
				return $php;
		 }



}
