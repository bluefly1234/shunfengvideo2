<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="author" content="Kale Chao | FakeCityMan |  http://kalechao87.github.io/">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="pragram" content="no-cache">  <!--禁止浏览器从本地计算机缓存访问页面内容，这样设定，访问者将无法脱机浏览-->
    <meta http-equiv="Cache-Control" content="no-siteapp" />  <!--禁止百度转码-->
    <meta http-equiv="X-UA-Compatible" content="IE=Edge, chrome=1"/>  <!--优先使用IE最新版和Chrome，避免IE使用兼容模式-->
    <meta name="apple-mobile-web-app-capable" content="yes" /> <!-- 启用 WebApp 全屏模式，伪装App离线应用，删除苹果默认的工具栏和菜单栏 -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" /> <!--隐藏状态栏/设置状态栏颜色：只有在开启WebApp全屏模式时才生效。content的值为default | black | black-translucent 。-->
    <meta name="format-detection" content="telephone=no" /> <!--忽略数字自动识别为电话号码-->
    <meta name="format-detection" content="email=no" /> <!--忽略识别邮箱-->
    <title>大咖邀请信</title>
    <!-- build:css css/main.min.css -->
    <link rel="stylesheet" href="css/main.css">
    <!-- endbuild -->
    <script type="text/javascript">
      var showSb, hideSb;
      if(/Android (\d+\.\d+)/.test(navigator.userAgent)){
          var version = parseFloat(RegExp.$1);
          if(version>2.3){
              var phoneScale = parseInt(window.screen.width)/640;
              document.write('<meta name="viewport" content="width=640, minimum-scale = '+ phoneScale +', maximum-scale = '+ phoneScale +', target-densitydpi=device-dpi">');
          }else{
              document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi">');
          }
      }else{
          document.write('<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">');
      }
      //微信去掉下方刷新栏
      if(navigator.userAgent.indexOf('MicroMessenger') >= 0){
          document.addEventListener('WeixinJSBridgeReady', function() {
              WeixinJSBridge.call('hideToolbar');
          });
      }
    </script><!--适配强制640width-->
  </head>
  <body>
    <div class="container">
      <div id="suoping">
        <audio src="media/notify.mp3" preload="auto" id="notify">

        </audio>
        <div id="sp-content">
          <div id="date-time">
            <p class="time" id="sptime"></p>
            <p class="date"></p>
            <img src="images/msg.png" alt="" id="msg">
          </div>
          <div id="unlock">
            <img src="images/unlock.png" alt="">
            <div id="unlock-light"></div>
          </div>
        </div>

      </div><!--suoping-->

      <div id="wx">
        <div id="search">
          <img src="images/search_bar.png" alt="" id="search-bar">
        </div>

        <div id="msg-list">
          <div id="msg-touch"></div>
          <div id="avatar">
            <div id="msg-num">1</div>
          </div>
          <p id="name">神秘大咖</p>
          <p id="tag">[视频]</p>
          <p id="list-time" class="time"></p>

        </div>
        <div id="line"></div>
        <img src="images/touch_up.png" alt="" id="touch-up">

      </div><!--wx-->

      <div id="dialouge">
        <div id="dialouge-time" class="time"></div>
        <div id="video-msg">
          <div id="avatar2"></div>
          <p id="name2">神秘大咖</p>
          <img src="images/video_icon.png" alt="" id="video-icon">
          <img src="images/playbtn.png" alt="" id="play-btn">
        </div>

        <img src="images/bottom_toolbar.png" alt="" id="bottom-toolbar">
      </div><!--dialouge-->

      <div id="video-container">
        <video src="media/video.mp4"  id="video">
        </video>
        <img src="images/poster.jpg" alt="" id="poster">
      </div>

      <div id="invite">
        <audio src="media/bgmusic.mp3" id="bg-music" preload="auto" loop="loop">
        </audio>
        <div id="music-control">
          <img src="images/music_bg.png" alt="" id="music-control-main">
          <img src="images/music_icon.png" alt="" class="music-control-icon hvcenter">
          <img src="images/music_icon.png" alt="" class="music-control-icon hvcenter">
          <img src="images/music_icon.png" alt="" class="music-control-icon hvcenter">
          <img src="images/music_icon.png" alt="" class="music-control-icon hvcenter">
          <img src="images/music_icon.png" alt="" class="music-control-icon hvcenter">
        </div><!--/music-control-->

        
        <img src="images/logo.png" alt="" id="logo" >
        <div id="content">
          <img src="images/content1.png" alt="" id="content1" >
          <img src="images/content3.png" alt="" id="content3" >
          <img src="images/content4.png" alt="" id="content4" >
        </div>
        <img src="images/star.png"  id="star1">
        <img src="images/star.png"  id="star2">
        <img src="images/planet.png" alt="" id="planet">
        <img src="images/content5.png" alt="" id="content5">
        <img src="images/light.png" id="light1" />
        <img src="images/light2.png" id="light2" />
      </div><!--invite-->

      <!-- <div id="cankao"><img src="images/wxck1.jpg" alt="" /></div> -->

    </div><!--container-->

    <!-- build:js js/vendor/jquery.min.js -->
    <script src="js/vendor/jquery.min.js"></script>
    <!-- endbuild -->
    <!-- build:js js/vendor/TweenMax.min.js -->
    <script src="js/vendor/TweenMax.min.js"></script>
    <!-- endbuild -->
    <!-- build:js js/vendor/touch.min.js -->
    <script src="js/vendor/touch-0.2.14.min.js"></script>
    <!-- endbuild -->
    <!-- build:js js/main.min.js -->
    <script src="js/main.js"></script>
    <!-- endbuild -->

  </body>
</html>

<?php
// *************************梵一数据平台对接 【仅允许梵一旗下域名】********************************************
// 必要数据
$basedata = array(
	'title' => '顺丰视频H5',  		// 项目标题 一个项目所有页面都用一样的
	'name' => 'SFVideo2',		// 项目唯一标识
	'indexflag' => 0,			// 入口标识  如果是首页 或者单页H5 则设置成0  其他页面可以随意设置为非0数字
);
$viewid=0;
include_once 'f1data/f1data.php';
$obj = new F1Data($basedata);
$viewid = $obj->doView(); // 记录访问

// 分享数据
$sharedata = array(
	'img' => 'http://'.$_SERVER['HTTP_HOST'].'/video2/images/icon.jpg?111',		// 分享图标地址 页面不让分享的时候 无需
    'url' => 'http://'.$_SERVER['HTTP_HOST'].'/video2/index.php',	// 分享图标地址 页面不让分享的时候 无需
	'title' =>	"主要看气质，神秘女大咖颜值爆表",	// 分享图标地址 页面不让分享的时候 无需
	'desc' =>	"主要看气质，神秘女大咖颜值爆表",	// 分享图标地址 页面不让分享的时候 无需
);
$obj->outputShare($sharedata); // 输出分享
?>
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
<script>
var scr=document.body.clientWidth.toString()+'*'+document.body.clientHeight.toString()+'-'+window.screen.width.toString()+'*'+window.screen.height.toString()+'-'+window.screen.availWidth.toString()+'*'+window.screen.availHeight.toString();
$.get('f1data/doView.php?id=<?php echo $viewid;?>&screen='+scr, function (data){} );
</script>
<?php
// *******************************************结束 END********************************************************
?>
