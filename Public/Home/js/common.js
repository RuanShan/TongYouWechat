"use strict";
(function(window) {

	var _ = { //通用的方法类
			verify: function(obj, reg, sendHint) {
				return function() {
					/*
			$data_empty:空内容的提示
			$data_error:错误后的提示
			reg : 正则表达式
			obj : this的指向
			sendHint : 发送短信验证码的提示
			*/
					var $val = $(this).val();
					var $data_empty = $(this).data("empty");
					var $data_error = $(this).data("error");
					var that_errorTxt = $(this).addClass("txt_error").siblings('p').removeClass("hidden").find(".error-txt");
					try {
						sendHint && sendHint.hide();
						if (reg.test($val)) {
							$(this).removeClass("txt_error").siblings('p').addClass('hidden');
							return true;
						} else if ($val === "") {
							that_errorTxt.text($data_empty);
						} else {
							that_errorTxt.text($data_error);
						}
						return false;
					} catch (e) {
						that_errorTxt.text($data_error);
						return false;
					}
				}.apply(obj);
			},
			trim:function(that){//简单的换行和空格显示
				that.html(that.text().replace(/[\s]+$/g, "").replace(/\n/g, "<br>").replace(/[\x20]/g, "&nbsp"));
			},
			//获取焦点提示
			getDataHint:function(dataHint,that){
				if(that.next("span").length === 0){
					that.after("<span class='dataHint'>"+ dataHint +"</span>");
				}
				that
				.removeClass("txt_error")
				.next(".dataHint")
				.css("display","inline-block")
				.siblings('p')
				.addClass("hidden");
			},
			//验证密码通用
			getPwd: function(newPassword, newPasswordRepeat) {
				$(this).next(".dataHint").hide();
				
				var verifies = hal.verify(this, /^[\da-z\!\@\#\$\%\^\&\*\(\)\_\+\~\`\-\=]{8,30}$/i);
				if (verifies && !!newPassword && !!newPasswordRepeat) {
					if (newPassword.val() === newPasswordRepeat.val()) {
						newPasswordRepeat
							.removeClass("txt_error")
							.siblings('p')
							.addClass('hidden');
						return true;
					} else if (newPasswordRepeat.val() !== "") {
						newPasswordRepeat
							.addClass("txt_error")
							.siblings('p')
							.removeClass("hidden")
							.find(".error-txt")
							.text(newPasswordRepeat.data("error"));
						return false;
					}
				}
				return verifies;
			},
			//支付页面的弹出框
			getPriceChange: function(url, msg, status) {
				status = status && status !== "error" ? status : "error";//更换图片
				
				var priceChange = $('<div class="keep_out error-keep_out">' +
					'<div class="keep_content pa">' +
					'<a class="pa quit" title="关闭" href='+ url +'></a>' +
					'<div class="tc">' +
					'<p class="content_text"><span class='+ status +'>'+ msg +'</span></p>' +
					'<a href='+ url +' class="submit inline_block">确定</a>' +
					'</div>' +
					'</div>' +
					'</div>'),
					quit = priceChange.find(".quit"),
					submit = priceChange.find(".submit");
				if(url === "javascript:;"){
					var Quit = function(){
						priceChange.remove();
					}
					
					quit.on('click',Quit);
					submit.on('click',Quit);
				}
				
				priceChange.appendTo("body");
				$("head").append('<link rel="stylesheet" type="text/css" href="' + ctx + '/css/dist/pay_accomplish.css">');
			},
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
			//换图 验证码
			getCode: function(obj) {
				obj.attr("src", ctx + "/validate/code?" + Date.now());
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
			getNoAuthCode: function($code, obj, prevAll) {
				/*
				验证码的验证&获取手机激活码     
				prevAll : 判断是否在验证码之前的全部必须进行的判断完成 ; 
				$code 验证码的标示 ; 
				obj : 验证码的ajax; 
				*/
				prevAll = prevAll == null ? true : prevAll;
				obj.sendHint = obj.sendHint ? obj.sendHint : false;

				if (prevAll) {
					if (hal.verify($code, /^[a-z0-9]{4}$/i)) {
						// 验证码验证
						$.ajax({
							url: obj.url ? obj.url : null,
							type: "POST",
							dataType: "JSON",
							async:obj.async ? obj.async : true,
							data: obj.data ? obj.data : null,
							success: function(data) {
								!data ? (
									$code
									.val("")
									.addClass("txt_error")
									.siblings('p')
									.removeClass("hidden")
									.find(".error-txt")
									.text($code.data("error")),

									_.getCode($("#verification-code"))
								) : (function() {
									$(obj.context)
										.html("<span class='time'></span>s后" + obj.disabled + "")
										.prop("disabled", true);
									
									obj.sendHint && $(".sendHint")
														.text(obj.sendText)
														.show()
														.siblings('p')
														.addClass("hidden");
//														.css("marginTop","10px");
									
									hal.getTime(obj.time, $(".time"), function() {
										$(obj.context).html(obj.text).prop("disabled", false);
									});

									$.post(obj.auth.url, obj.auth.data, "JSON");
								})();
							}
						});
					}else {
						hal.getCode(obj.code);
						$code.val("");
					}
				} 

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
			},
			/*显示省略*/
			truncation:function(that, Height, obj, fn){
				var thatLen = that.length;
				if(thatLen > 1){
					$.each(that, function(index, elem){
						addTruncation($(elem), index);
					});
				}else if(thatLen === 1){
					addTruncation(that, 0);
				}
				
				function addTruncation(that, index){
					var thatHeight = that.height(),
						_br;
					if(thatHeight > Height){
						obj = obj ? obj : "";
						$.isFunction(fn) && fn.call(that, index);//执行不同的方法
						that
						.css("height", Height)
						.attr("title", that.text())
						.dotdotdot(obj);//调用插件
						
						_br = that.find("br");
						
						if(_br.length > 1){//防止换行
							_br.last().remove();
						}
						
					}
				}
			},
			//汉字为三个字符
			setName : function(nameNum){
			  var num = 0,
			  	_val = $(this).val();
			  
			    for (var i=0, len=_val.length; i<len; i++) {    
			        if (_val.charCodeAt(i) > 127 || _val.charCodeAt(i) === 94) {    
			        	num += 3;    
			         }else{
			        	 num += 1;
			         } 
			        
			        if(num >= nameNum){
			        	i+=1;
			        	$(this).val(_val.slice(0,i)); 
			        	break;
			        }
			     }    
			},
			/*检查登录状态*/
			isLogin:function(fn){
				var isLogin;
				$.ajax({
					url: ctx + '/user/checklogin',
					type: 'POST',
					context: this,
					cache:false,
					async:false,
					dataType: "JSON",
					success: function(data) {
						if (data.status !== 0) {
							location.reload(true);
//							addBuyLog(collectId, type);
						}else{
							fn();
						}
					},
					error:function(xhr, error, msg){
						console.log(msg);
					}
				});
				return isLogin;
			}
//			// 增加意向用户数据收取
//			addBuyLog:function (collectId,type){
//				$.ajax({
//					url: ctx + '/myorder/addBuyLog',
//					data: {
//						contentId: collectId,
//						type : type
//					},
//					type: 'POST',
//					cache:false
//				});
//			}
		},
		hal = _;
	window._ = _;
	
	//简单的富文本显示
	var trim = $(".trim");
	if(trim.length){
		$.each(trim, function(index, elem){
			_.trim($(elem));
		});
	}
})(window);