touch.on($("body"), 'touchmove', function(ev){
  console.log(ev.type);
	ev.preventDefault();
});

// 微信接收时间
var curDate = new Date();
var curMonth = curDate.getMonth() + 1; // 获取当前月份(0-11,0代表1月)
var curDay = curDate.getDate();  // 获取当前日(1-31)
var curWeek = curDate.getDay();  // 0-6对应为星期日到星期六
var curHour = curDate.getHours();      // 获取当前小时数(0-23)
var curMinute = curDate.getMinutes();   // 获取当前分钟数(0-59)
var realHour, realMinite;
if(curHour<10){
	realHour = '0' + curHour;
}else{
	realHour = curHour;
}

if(curMinute<10){
	realMinute = '0' + curMinute;
}else{
	realMinute = curMinute;
}

var realWeek;
switch(curWeek)
{
case 0:realWeek="星期日";break;
case 1:realWeek="星期一";break;
case 2:realWeek="星期二";break;
case 3:realWeek="星期三";break;
case 4:realWeek="星期四";break;
case 5:realWeek="星期五";break;
case 6:realWeek="星期六";break;
default:realWeek="星期一"
}

$(".time").html(realHour + ":" + realMinute); // 锁屏时间
$(".date").html(curMonth + "月" + curDay + "日" + "  " +realWeek );

// 首页动画开始
var notify = $('#notify')[0];
var unlock = new TimelineMax({paused: true, onComplete: function() {
  lightSlide.play();
}});
var lightSlide = new TimelineMax({paused: true, repeat: -1, repeatDelay: 0.5});
unlock.to($('#unlock'), 0.4, {autoAlpha: 1, ease: Power1.easeIn});
lightSlide.to($('#unlock-light'), 1, {x: 125, autoAlpha: 1, ease: Power0.easeNone })
          .to($('#unlock-light'), 1, {x: 250, autoAlpha: 0, ease: Power0.easeNone });
TweenMax.set([$('#msg'), $('#unlock'), $('#unlock-light')], {autoAlpha: 0});

$(document).ready(function(){
  console.log('ready');
  notify.play();
  //当通知音开始播放时出现
  function initShow(){
  	if (notify.currentTime){
      console.log('通知音开始播放');
      TweenMax.to($('#msg'), 0.5, {autoAlpha: 1, onComplete: function() {
        unlock.play();
      }});
  		notify.removeEventListener("timeupdate", initShow, false);
  	}
  }
  notify.addEventListener("timeupdate", initShow, false);
  // notify.addEventListener("timeupdate", function () {
  //      if(notify.currentTime>0){
  // 			console.log('通知音开始播放');
  //       TweenMax.from($('#msg'), 1, {autoAlpha: 0});
  // 		}
  //  }, false);
});

// 首页右滑退出
var spSlideout = new TimelineMax({paused: true, onStart: function() {
    wxShow.play();
}});
spSlideout.to($('#sp-content'), 0.5, {x: 640})
          .to($('#suoping'), 0.5, {autoAlpha: 0}, "-=0.2");
// 滑动page3
touch.on($("#sp-content"), 'swiperight', function(ev){
  console.log(ev.type);
	TweenMax.set($('#wx'), {autoAlpha: 1});
  spSlideout.play();
  $('#video').attr('preload','auto');
});
// 首页动画结束

// 微信列表动画
TweenMax.set($('#dialouge'), {left: 640}); // 初始在右侧
var wxShow = new TimelineMax({paused: true, onComplete: function() {
  TweenMax.to($('#touch-up'), 0.8, {y: '-=20', repeat: -1, yoyo: true});
}});

wxShow.from($('#wx'), 0.6, {scale: 1.5, ease: Circ.easeOut})
touch.on($("#msg-list"), 'tap', function(ev){
  console.log(ev.type);
  TweenMax.from($('#msg-touch'), 0.1, {autoAlpha: 0, onComplete: function() {
    // 对话列表
    TweenMax.to($('#dialouge'), 0.3, {left: 0});
    TweenMax.to($('#wx'), 1, {left: -640, onComplete: function() {
      TweenMax.set($('#wx'), {autoAlpha: 0}); //  结束后隐藏
    }});
    // 对话列表结束
  }});
  TweenMax.set($('#touch-up'), {autoAlpha: 0});
  TweenMax.set($('#dialouge'), {autoAlpha: 1});

});
// 微信列表结束

// 视频==========================================================================
TweenMax.set($('#video-container'), {autoAlpha: 0, scale: 0});
var video = $('#video')[0];
$('#video').attr("webkit-playsinline","webkit-playsinline");
touch.on($("#play-btn"), 'tap', function(ev){
  console.log(ev.type);
  TweenMax.to($('#video-container'), 0.6, {autoAlpha: 1, scale: 1, ease: Back.easeOut.config(1.7), transformOrigin:"250 225", onComplete: function() {
    TweenMax.set($('#dialouge'), {autoAlpha: 0});
    video.play();
    function initVideo(){
      if (video.currentTime){
        console.log('视频开始播放');
        TweenMax.set($('#poster'), {autoAlpha: 0});
        video.removeEventListener("timeupdate", initVideo, false);
      }
    }
    video.addEventListener("timeupdate", initVideo, false);
  }});

});

//视频播放完之后隐藏视频及结束按钮
video.addEventListener("ended",function(evt) {
  	console.log("video has ended");
		TweenMax.set($('#video-container'), {autoAlpha: 0});
		TweenMax.set($('#invite'), {autoAlpha: 1});
		showInvite.play();

});
// 视频结束======================================================================


// 邀请页========================================================================
// music-control------------------------------------------------------------------------------------------------------
var musicCtrl = new TimelineMax({repeat: -1, paused:true });
var musicRotation = new TimelineMax({repeat: -1, paused:true});
musicCtrl.to($(".music-control-icon"), 2, {rotation: 360, ease: Power0.easeNone});
musicRotation.to($(".music-control-icon:nth(1)"), 0.5, {x: "-=20",y: "-=20", autoAlpha:0, ease: Power0.easeNone})
              .to($(".music-control-icon:nth(2)"), 0.5, {x: "+=20", y: "-=20", autoAlpha:0, ease: Power0.easeNone})
              .to($(".music-control-icon:nth(3)"), 0.5, {x: "-=20", y: "+=20", autoAlpha:0, ease: Power0.easeNone})
              .to($(".music-control-icon:nth(4)"), 0.5, {x: "+=20", y: "+=20", autoAlpha:0, ease: Power0.easeNone})
// 音乐初始化
var bgAud = $("#bg-music")[0];
// 音乐控制
$("#music-control").click(function(){
  if(bgAud.paused){
    bgAud.play();
    musicCtrl.play();
    musicRotation.play();
  }else{
    bgAud.pause();
    musicCtrl.pause();
    musicRotation.pause();
  }
})
// music-control End----------------------------------------------------------------------------------------------------------


TweenMax.set($('#invite'), {autoAlpha: 0});
var showInvite = new TimelineMax({paused: true, onComplete: function() {
	scaleLight.play();
  }, onStart: function() {
    bgAud.play();
    function initAud(){
      if (bgAud.currentTime){
        console.log("背景音乐开始播放");
        musicCtrl.play();
        musicRotation.play();
        bgAud.removeEventListener("timeupdate", initAud, false); //只执行一次，防止控制按钮动画无法暂停
      }
    }

    bgAud.addEventListener("timeupdate", initAud, false);
  }});

var showMeteor = new TimelineMax({repeat: -1, repeatDelay: 0.5, paused: true});
var scaleLight = new TimelineMax({paused: true, onComplete: function() {
	showLight.play();
	showMeteor.play();
	starBlink.play();
}});
var showLight = new TimelineMax({repeat: -1, yoyo: true, paused: true});
var starBlink = new TimelineMax({repeat: -1, yoyo: true, paused: true});
starBlink.staggerFrom([$('#star1'), $('#star2')], 1, {autoAlpha: 0.5, ease: Power1.easeInOut}, 0.5);
scaleLight.from($('#light1'), 0.5, {scale: 0, autoAlpha:0, transformOrigin:"left top"})
					.addLabel("start", "-=0.5")
					.from($('#light2'), 0.5, {scale: 0, autoAlpha:0, transformOrigin:"right top"}, "start")


showLight.to($('#light1'), 1.5, {rotation: 25,  transformOrigin:"left top", ease: Power1.easeInOut})
					.addLabel("start", "-=1.5")
					.to($('#light2'), 1.5, {rotation: -25,  transformOrigin:"right top", ease: Power1.easeInOut}, "start")
showMeteor.to($('#meteor1'), 1.2, {left: -170, top: 480})
					.to($('#meteor2'), 1.2, {left: -170, top: 840}, "-=0.3")
					.to($('#meteor3'), 1.2, {left: -170, top: 920}, "-=0.4")
showInvite.from($('#logo'), 0.5, {autoAlpha: 0})
					.staggerFrom([$('#content1'), $('#content3'), $('#content4')], 0.8, {autoAlpha: 0, y: '+=20'}, 0.25)
					.from($('#content5'), 0.6, {x: 640, ease: Back.easeOut.config(1.7)}, '-=0.3');



// 邀请页结束=====================================================================
