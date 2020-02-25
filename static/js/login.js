$(document).ready(function () {

	$("#rememberMe").click(function(){
		if ($(this).prev().is(":checked")) {
			$(this).prev().prop("checked", false);
		} else {
			$(this).prev().prop("checked", true);
		}
	})

	var Validator = $("#loginForm").validate(
		{
			rules: {
				//username和password是对应的name
				username: {
					required: true,
					checkUser: true,
					isChinese: true,
				},
				password: {
					required: true,
					rangelength: [6, 18],
					checkPsd: true,
				},
				"confirm-password": {
					equalTo: "#password"
				}
			},
			messages: {
				username: {
					required: "必须填写用户名",
				},
				password: {
					required: "必须填写密码",
					rangelength: "请输入6-18个字符，只允许英文字母、数字、符号"
				},
			},

			errorPlacement: function (error, element) {
				element.parent().css({ 'margin': '20px 0 0' });
				error.css({ "color": "red" });
				error.appendTo(element.parent());
			},
			submitHandler: function () {
				//同时传递对应用户名并查询对应信息
				form.submit();
			},

		});

	//检查用户名格式
	$.validator.addMethod("checkUser", function (value, element) {
		var username = /^[\u4E00-\u9FA5A-Za-z0-9]+$/;
		return this.optional(element) || username.test(value);
	}, "4-16个字符，只允许中文（1字算2个字符）、英文字母、数字");

	//中文字符计为两个字符
	$.validator.addMethod("isChinese", function (value, element) {
		var length = value.length;
		for (let i = 0; i < value.length; i++) {
			var c = value.charAt(i);
			(c.match(/[^\x00-\xff]/ig) != null) ? length++ : "";
		}
		return this.optional(element) || (length <= 16 && length >= 4);
	}, "要求4-16个字符，只允许中文（1字算2个字符）、英文字母、数字");

	//检查密码格式
	$.validator.addMethod("checkPsd", function (value, element) {
		//测试
		var password = /^[A-Za-z0-9_`~!@#$%^&*()_+-=<>?:"{},.\/;'[\]·！#￥（——）：；“”‘、，|《。》？、【】[\]]+$/;
		return this.optional(element) || password.test(value);
	}, "要求6-18个字符，只允许英文字母、数字、符号");

});