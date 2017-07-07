
Zepto(function($){
  $("#get_vcode").click(function(){
    alert('yes');
    $.ajax({type:'POST',
      url:'/home/index/send_vcode',
      success: function(data){

      }
    })

  });
  weui.form.checkIfBlur('.js__form');
  $('#submit_btn').click(function () {

    weui.form.validate('#member_form', function (error) {
      if (!error) {
          var loading = weui.loading('提交中...');
          setTimeout(function () {
              loading.hide();
              weui.toast('提交成功', 3000);
          }, 1500);
      }
        // return true; // 当return true时，不会显示错误
    }, {
        regexp: {
            IDNUM: /(?:^\d{15}$)|(?:^\d{18}$)|^\d{17}[\dXx]$/,
            VCODE: /^.{4}$/
        }
    });
  });
})
