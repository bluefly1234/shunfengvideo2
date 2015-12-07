<?php

class F1Data {
	// 基础数据

	private $titleid=0;
	private $uuid=0;
	private $safeid=0;
	private $indexflag=0;
	private $shareid=0;
	
	function __construct($data) {
		if (!isset($data)){
			echo "no data";die;
		}
		// 初始化变量
		if (!isset($data['name'])){
			echo "no name";die;
		}
		
		$title='';
		if (isset($data['title'])){
			$title = $data['title'];
		}
		
		$projname = $data['name'];
		
		// 构造主表
		include_once dirname(__FILE__)."/config_data.php";
		include_once dirname(__FILE__)."/api_data.php";
		$sql = "select * from proj where projname='".$projname."';";
		$data = DATA_ExecSelectOne($sql);
		
		if ($data == null){
			$sql = "insert into proj (title, projname, create_tm) values ('".$title."', '$projname', ".time().");";
			//echo $sql;die;
			$this->titleid = DATA_ExecSqlNeedInc($sql);
			// echo $this->titleid;die;
		}else{
			$this->titleid = $data['id'];	
		}
		// 设置用户信息
		if (isset($_COOKIE['F1DATA_UUID'])){
			$this->uuid = $_COOKIE['F1DATA_UUID'];
		}else{
			$this->uuid = rand(100,999).time().rand(10,99);
			setcookie('F1DATA_UUID', $this->uuid, time()+999999, "/");
		}
		
		if (isset($_GET['safe'])){
			$this->safeid = $_GET['safe'];
		}
		
		// 是否首页 0 是首页 非0不是
		if (isset($data['indexflag'])){
			$this->indexflag = $data['indexflag'];
		}
		
		// 如果有shareid 则记录 这个ID是进入的时候记录的
		if (isset($_COOKIE['F1DATA_SHAREID'])){
			$this->shareid = $_COOKIE['F1DATA_SHAREID'];
		}
	}
	
	// 记录访问函数
	public function doView(){
		include_once dirname(__FILE__)."/config_data.php";
		include_once dirname(__FILE__)."/api_data.php";
		date_default_timezone_set('Asia/Shanghai');
		// 记录分享ID
		if (isset($_GET['shareid'])){
			$this->shareid=$_GET['shareid'];
			setcookie('F1DATA_SHAREID', $this->shareid, time()+86400, "/");
		}
		
		// 获得必要数据
		$domain = $_SERVER['HTTP_HOST'];
		$url = $_SERVER['REQUEST_URI'];
		$device = $_SERVER['HTTP_USER_AGENT'];
		$ip=DATA_getip();
		$sql = "insert into access (uuid, safeid, titleid, domain, url, device, ip, shareid, indexflag, create_tm) values ( ".$this->uuid.", ".$this->safeid.", ".$this->titleid.", '$domain', '$url', '$device', '$ip',  ".$this->shareid.",  ".$this->indexflag.", ".time()." );";
		return DATA_ExecSqlNeedInc($sql);
	}
	
	// 输出分享代码函数
	public function outputShare($sharedata){
		if (!class_exists( 'JSSDK' ) ){
			include dirname(__FILE__)."/jssdk.php";
		}
		$jssdk_data = new JSSDK("wx92a798c69ae2c8b2", "07dfd943eef04574b261a475b9f24019");
		$signPackage_data = $jssdk_data->GetSignPackage();
		$url='';
		$shareid=time().rand(1000,9999);
		if (isset($sharedata['url'])){
			$url = $sharedata['url'];

			if (strpos($url, "?")==false){
				$url =$url.'?shareid='.$shareid;
			}else{
				$url =$url.'&shareid='.$shareid;
			}
		}else{
			$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$_SERVER['REQUEST_URI'].'?shareid='.$shareid;
		}
		
		if (isset($_GET['shareid'])){
			$this->shareid=$_GET['shareid'];
			setcookie('F1DATA_SHAREID', $this->shareid, time()+86400, "/");
		}
		?>
        
        <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 如有问题请通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
   
var dataForWeixin={
	appId:	"",
	img:'<?php echo $sharedata['img'];?>',
    url:'<?php echo $url;?>',
	title:	"<?php echo $sharedata['title'];?>",
	desc:	"<?php echo $sharedata['desc'];?>",
	fakeid:	"",
};

 wx.config({
	// debug: true, 
    appId: '<?php echo $signPackage_data["appId"];?>',
    timestamp: <?php echo $signPackage_data["timestamp"];?>,
    nonceStr: '<?php echo $signPackage_data["nonceStr"];?>',
    signature: '<?php echo $signPackage_data["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
	  'onMenuShareTimeline','onMenuShareAppMessage'		<?php 
		if (isset($sharedata['extrafunctionname'])){
			echo ','.$sharedata['extrafunctionname'];
		}
		?>
    ]
  });
  
  wx.ready(function () {
      wx.showOptionMenu();
    // alert('ee');
    // 在这里调用 API
    wx.onMenuShareTimeline({
    title: dataForWeixin.title, // 分享标题
    link: dataForWeixin.url, // 分享链接
    imgUrl: dataForWeixin.img, // 分享图标
    success: function () { 
		$.get('f1data/doshare.php?titleid=<?php echo $this->titleid;?>&uuid=<?php echo $this->uuid;?>&shareid=<?php echo $this->shareid;?>&state=1', function(data){ });
		<?php 
		if (isset($sharedata['sharesuccesscode'])){
			echo $sharedata['sharesuccesscode'];
		}
		?>
    },
    cancel: function () { 
        $.get('f1data/doshare.php?titleid=<?php echo $this->titleid;?>&uuid=<?php echo $this->uuid;?>&shareid=<?php echo $this->shareid;?>&state=2', function(data){ });
    }
    });


wx.onMenuShareAppMessage({
    title: dataForWeixin.title, // 分享标题
    desc: dataForWeixin.desc, // 分享描述
    link: dataForWeixin.url, // 分享链接
    imgUrl: dataForWeixin.img, // 分享图标
    type: '', // 分享类型,music、video或link，不填默认为link
    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
    success: function () { 
        // 用户确认分享后执行的回调函数
        //alert('efd');
        $.get('f1data/doshare.php?titleid=<?php echo $this->titleid;?>&uuid=<?php echo $this->uuid;?>&shareid=<?php echo $this->shareid;?>&state=3', function(data){ });
		<?php 
		if (isset($sharedata['sharesuccesscode'])){
			echo $sharedata['sharesuccesscode'];
		}
		?>
    },
    cancel: function () { 
        // 用户取消分享后执行的回调函数
		$.get('f1data/doshare.php?titleid=<?php echo $this->titleid;?>&uuid=<?php echo $this->uuid;?>&shareid=<?php echo $this->shareid;?>&state=4', function(data){ });
    }
});


  });
  
  
</script>

        <?php
	}

}

?>