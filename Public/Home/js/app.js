(function(window) {
	var _ = { //通用的方法类
    //倒计时
    getTime: function(i, that, fn, num) { // i : 从哪个时间开始倒计时, that : 哪个对象进行显示时间 , fn : 倒计时要执行的函数, num: 延时
      that.text(i);
      var time = setInterval(function() {
        that.text(--i);
        i <= 0 ? (
          $.isFunction(fn) ? fn() : null,
          clearInterval(time),
          time = null
        ) : null;
      }, num || 1000);

      time;
    },
    validataSmsCode:function(obj) {//验证手机验证码
        var data = {
            "activate": obj.activate,
            "type": obj.type,
            "phone": obj.phone
          };

      $.ajax({
        url: ctx + "/sms/validataSmsCode",
        data: data,
        type: "POST",
        dataType: "JSON",
        success: function(data){
          obj.fn(data);
        },
        error:function(xhr, error, msg){
          console.info(msg);
        }
      });
    },
    getVerifyCode:function( obj ){
      $(obj.ctx)
        .html("<span class='time'></span>s后" + obj.disabled + "")
        .prop("disabled", true);

      hal.getTime(obj.time, $(".time"), function() {
        $(obj.ctx).html(obj.text).prop("disabled", false);
      });

      $.post(obj.auth.url, obj.auth.data, function(response){
				console.debug(response );
				if( response.status ==1 )
				{
					weui.toast('验证短信已发送！',2000);
				}	else{
					weui.alert('短信发送失败，请联系客服！');
				}
			},"json");
    },
    //倒计时
    setInterval:function(time, fn, num){
      var count_Down,
        times;
      setTimeout(function(){
        count_Down = $.isFunction(fn) && fn();
      },1000);
      times = setInterval(function(){
          var leftTime = hal.countDown(time, count_Down);
          if(!leftTime){
            clearInterval(times);
          }
      }, num||1000);
    },
    countDown:function(time, count_Down){
      var EndTime= new Date(parseInt(time, 10)),
          NowTime = new Date(),
          leftTime = EndTime.getTime() - NowTime.getTime(),
          leftsecond = parseInt(leftTime/1000, 10),
          day = hal.day(leftsecond),
          hour = hal.hour(leftsecond),
          minute = hal.minute(leftsecond),
          second = hal.second(leftsecond),
          getTime = day + hour + minute + second;

        getTime ? count_Down.html(getTime) : count_down.parent().remove() ;

          return leftTime;
    },
    checkTime : function(time){//1-9的时候前面加0
      if(time < 10){
        time = "0" + time;
      }
      return time;
    },
    day:function(time){
       var day = parseInt(time / 60 / 60 / 24, 10);//计算剩余的天数
               if(day > 0){
                 day = day + "天";
               }else{
                 day = "";
               }
               return day;
    },
    hour:function(time){
       var hour = parseInt(time / 60 / 60 % 24, 10);//计算剩余的小时数
       if(hour > 0){
                hour = hal.checkTime(hour) + "小时";
       }else{
         hour = "";
               }
               return hour;
    },
    minute:function(time){
        var minute = parseInt(time / 60 % 60, 10);//计算剩余的分钟数
        if(minute > 0){
          minute = hal.checkTime(minute) + "分钟";
        }else{
          minute = "";
            }
               return minute;
    },
    second:function(time){
       var second = parseInt(time % 60, 10);//计算剩余的秒数
       if(second > 0){
                 second = hal.checkTime(second) + "秒";
       }else{
         second = "";
            }
               return second;
    }
  },
  hal = _;
	window._ = _;
})(window);

Zepto(function($){
  $("#get_vcode").click(function(){
    var node = this;
    //发短信按键
     		var	$mobile = $("input[name=telephone]");
        weui.form.validate('.telephone_wrapper', function (error) {
          if (!error) {
        		_.getVerifyCode({
        									disabled:"重新获取",
        									text:"重新发送",
        									time:60,
        									sendHint:true,
        									sendText:"动态验证码已发送到您的手机，10分钟内有效",
         									ctx: node,
        									auth:{
        										url: TongYou.routes.send_vcode_url,
        										data:{
        											"mobile": $mobile.val(),

        										}
        									}
        								});
                      }
                    });
    $('#submit_btn').removeClass('weui-btn_disabled');
  });
  var all_regexp = {
      IDNUM: /(?:^\d{15}$)|(?:^\d{18}$)|^\d{17}[\dXx]$/,
      MOBILE: /^1[0-9]{10}$/,
      VCODE: /^.{4}$/,
      PASSWORD: /[0-9a-zA-Z#@!~%^&*]{6,16}/
  };
  weui.form.checkIfBlur('.js__form', { regexp:all_regexp });
  $('#submit_btn').click(function () {
    weui.form.validate('.js__form', function (error) {
      if (!error) {
          var loading = weui.loading('提交中...');
					$.post(TongYou.routes.login_url, $('.js__form').serialize(),function(response){
						loading.hide();
						console.log( response);
						if( response.status == 1)
						{
						  weui.toast('注册成功', {
								duration: 4000,
								callback: function(){ wx.closeWindow(); }
							});
					  }else {
							weui.topTips(response.msg);
					  }
					})
      }else {
        //alert( error);
      }
    }, {
        regexp:all_regexp
    });
		return false;
  });

	//临时激活
	$('#tactivate_btn').click(function () {
		$.ajax({
			url: TongYou.routes.jihuo2t_url,
			type: "POST",
			dataType: "JSON",
			success: function(data){
				weui.toast('临时激活成功', {
				    duration: 5000,
				    callback: function(){ window.history.go(-1);
						}
				});
			},
			error:function(xhr, error, msg){
				console.info(msg);
			}
		});
	});
	//永久激活
	$('#pactivate_btn').click(function () {
		$.ajax({
			url: TongYou.routes.jihuo2p_url,
			type: "POST",
			dataType: "JSON",
			success: function(data){
				weui.toast('永久激活成功', {
						duration: 5000,
						callback: function(){ window.history.go(-1);
						}
				});
			},
			error:function(xhr, error, msg){
				console.info(msg);
			}
		});
	});


	//删除产品注册信息
	$('#delete_btn').click(function () {
		$.ajax({
			url: TongYou.routes.delete_machine_url,
			type: "POST",
			dataType: "JSON",
			success: function(data){
				weui.toast('设备删除成功', {
						duration: 3000,
						callback: function(){ window.history.go(-1);
						}
				});
			},
			error:function(xhr, error, msg){
				console.info(msg);
			}
		});
	});
	//关闭窗口
	$('#close_btn').click(function () {
		wx.closeWindow();
	});
	//返回上一页
	$('#back_btn').click(function () {
		window.history.go(-1);
	});

})
