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
switch(curDay)
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
  // $('#video').attr('preload','auto');
});
// 首页动画结束

// 微信列表动画
var wxShow = new TimelineMax({paused: true, onComplete: function() {
  TweenMax.to($('#touch-up'), 0.8, {y: '-=20', repeat: -1, yoyo: true});
}});

wxShow.from($('#wx'), 0.6, {scale: 1.5, ease: Circ.easeOut})
touch.on($("#msg-list"), 'tap', function(ev){
  console.log(ev.type);
  TweenMax.from($('#msg-touch'), 0.1, {autoAlpha: 0});
  TweenMax.set($('#touch-up'), {autoAlpha: 0});
});
// 微信列表结束

// 快递包裹
var showPackage = new TimelineMax({paused: true});
var hidePackage = new TimelineMax({paused: true, onComplete: function() {
  TweenMax.set($('#package-content'), {autoAlpha: 0});
  showVideo.play();
}});
var showVideo = new TimelineMax({paused: true});
showPackage.from($('#package'), 0.4, {scale: 1.5, ease: Circ.easeOut}, "-=0.1")
            .from($('#bag'), 0.8, {y: -400, autoAlpha: 0, ease: Bounce.easeOut})
            .from($('#reminder'), 0.5, {autoAlpha: 0, ease: Power1.easeIn}, '-=0.8')
            .from($('#tap-guide'), 0.5, {autoAlpha: 0, ease: Power1.easeIn})
            .to($('#tap-guide'), 0.5, {y: '+=30', ease: Power0.easeNone, repeat: -1, yoyo: true}, '-=0.5');

hidePackage.to($('#bag'), 0.8, {x: 640, autoAlpha: 0, ease: Back.easeIn.config(1.7)})
            .to([$('#tap-guide'), $('#reminder')], 0.5, {autoAlpha: 0}, '-=0.5');

touch.on($("#bag"), 'tap', function(ev){
  console.log(ev.type);
  hidePackage.play();
});

showVideo.from($('#video-container'), 0.3, {x: -640, autoAlpha: 0});

var video = $('#video')[0];
$('#video').attr("webkit-playsinline","webkit-playsinline");
touch.on($("#play-btn"), 'tap', function(ev){
  console.log(ev.type);
  video.play();
  // 视频播放隐藏播放按钮
  function initVideo(){
    if (video.currentTime){
      console.log('视频开始播放');
      TweenMax.to($('#play-btn'), 0.5, {autoAlpha: 0, scale: 2});
      TweenMax.set($('#poster'), {autoAlpha: 0});
      video.removeEventListener("timeupdate", initVideo, false);
    }
  }
  video.addEventListener("timeupdate", initVideo, false);
});

//视频播放完之后隐藏视频及结束按钮
video.addEventListener("ended",function(evt) {
  	console.log("video has ended");
		TweenMax.set($('#package'), {autoAlpha: 0});
		TweenMax.set($('#invite'), {autoAlpha: 1});
		showInvite.play();

});

// 快递包裹结束

// 邀请页========================================================================
TweenMax.set($('#invite'), {autoAlpha: 0});
var showInvite = new TimelineMax({paused: true, onComplete: function() {
	scaleLight.play();
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
					.staggerFrom([$('#content1'), $('#content2'), $('#content3'), $('#content4')], 0.8, {autoAlpha: 0, y: '+=20'}, 0.25)
					.from($('#content5'), 0.6, {x: 640, ease: Back.easeOut.config(1.7)}, '-=0.3');



// 邀请页结束=====================================================================
