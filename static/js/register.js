$(document).ready(function () {

	//各类选框
	let job = $('input:radio[name="job"]');
	let hobbyList = [];
	let hobby = $('#registerForm input:checkbox[name=newhobby]');

	$("input").blur(function () {
		$.ajax({
			type: "GET",
			url: "index.php?controller=register&action=checkExisted",
			contentType: "application/x-www-form-urlencoded",
			dataType: "json",
			data: 
			{
				"username": $("#username").val(),
				"email": $("#email").val(),
			},
			error: function (xhr) { alert("错误：" + xhr.responseText) },
			success: function (data) 
			{
				if (data.status == "error") {
					//注册失败的警告框
					$(".showErrorMessage").html(data.message);
					$("#errorMessageDiv").show(); 
					setTimeout('$("#errorMessageDiv").hide("slow")',3000);
				}
			}
		}) 
	})


	//**单选框的改变事件 */
	job.change(function (index, element) {
		job = $('input:radio[name="job"]:checked');
		if (job.val() == 'worker') {
			$('.schoolOrCompany').html("公司:");
		} else if (job.val() == 'student') {
			$('.schoolOrCompany').html("学校:");
		}
	});

	/**单选框文字点击事件 */
	$(".jobRadio").click(function () {
		$(this).find("input").prop("checked", true);
		if ($('input:radio[name="job"]:checked').val() == 'worker') {
			$('.schoolOrCompany').html("公司:");
			$("#errorMessageDiv").show(); 
		} else if ($('input:radio[name="job"]:checked').val() == 'student') {
			$('.schoolOrCompany').html("学校:");
			$("#errorMessageDiv").hide("slow"); 
		}
	})


	/**复选框文字的点击事件 */
	$(".addHobby").click(function () {
		if ($(this).prev('input').is(":checked")) {
			$(this).prev('input').prop("checked", false);
		} else {
			$(this).prev('input').prop("checked", true);
		}
		if (hobbyList.length == 0 || $(this).prev('input').is(":checked")) {
			hobbyList.push($(this).prev('input').val());
		} else {
			for (let i = 0; i < hobbyList.length; i++) {
				//再次选中时删除
				if(hobbyList[i] == $(this).prev('input').val()){
					hobbyList.splice(i, 1);
				}
			}
		}
		console.log(hobbyList.length);
		
	})


 	//***添加用户模态框的复选框的改变事件：获取复选框的值*/
	
	hobby.change(function () {
		console.log($(this).val());
		//选中就新增，否则遍历有重复就删除该元素
		if (hobbyList.length == 0 || $(this).is(":checked")) {
			hobbyList.push($(this).val());
		} else {
			for (let i = 0; i < hobbyList.length; i++) {
				//再次选中时删除
				if(hobbyList[i] == $(this).val()){
					hobbyList.splice(i, 1);
				}
			}
		}
		
	}); 


	//**注册和新增的表单验证 */															
	var Validator = $("#registerForm").validate(
		{
 		 	rules:
			{
				//username和password是对应的name
				username: {
					required: true,
					checkUser: true,
					isChinese: true
				},
				password: {
					required: true,
					rangelength: [6, 18],
					checkPsd: true
				},
				"confirm-password": {
					equalTo: "#password"
				},
				email: {
					required: true,
				},
				truename: {
					required: true,
					realName: true
				},
				age: {
					required: true,
					digits: true,
					range: [1, 100]
				},
				schoolOrCompany: {
					required: true,
					maxlength: 100
				},
				newhobby: {
					required: true,
				},
			},
			messages:
			{
				username: {
					required: "必须填写用户名",
				},
				password: {
					required: "必须填写密码",
					rangelength: "请输入6-18个字符，只允许英文字母、数字、符号"
				},
				"confirm-password": {
					equalTo: "请重复输入密码",
				},
				email: {
					required: "请填写电子邮箱",
					email: "请输入正确邮箱地址"
				},
				truename: {
					required: "请填写真实姓名",
				},
				age: {
					required: "请填写真实年龄",
					digits: "请输入整数",
					range: "请输入1-100之间的整数"
				},
				schoolOrCompany: {
					required: "请填写学校或者单位名称",
					maxlength: "请输入不超过100字符的名称"
				},
				newhobby: {
					required: "请至少选择一项爱好",
				}
			},
			//** 表单提交事件*/
			submitHandler: function () 
			{	
				$.ajax({
					type: "POST",
					url: "index.php?controller=register&action=index",
					contentType: "application/x-www-form-urlencoded",
					// dataType: "json", 
					data: 
					{
						"username": $("#username").val(),
						"password": $("#password").val(),
						"truename": $("#truename").val(),
						"email": $("#email").val(),
						"age": $("#age").val(),
						"job": $('input:radio[name="job"]:checked').val(),
						"schoolOrCompany": $("#schoolOrCompany").val(),
						"hobby": hobbyList.join(","),
					},
					error: function (xhr) { alert("错误：" + xhr.responseText) },
					success: function (data) 
					{
 						if (data.ok == false||data.status=="dataError") {
							//注册失败的警告框
							$(".showErrorMessage").html(data.message);
							$("#errorMessageDiv").show(); 
							setTimeout('$("#errorMessageDiv").hide("slow")',5000);
						}else {
							window.location.href="index.php?controller=user&action=index";
							form.reset();
							hobbyList.splice(0, hobbyList.length);
							$('input[type=text],[type=email],[type=password]').val("");
							$('input[name="newhobby[]"]').prop("checked", false); 
						} 
					}
				})
			},
			errorPlacement: function (error, element) {
				error.css({ "color": "red" });
				error.appendTo(element.parent());
			}
		});


	//** 检查用户名格式*/
	$.validator.addMethod("checkUser", function (value, element) {
		let username = /^[\u4E00-\u9FA5A-Za-z0-9]+$/;
		return this.optional(element) || username.test(value);
	}, "4-16个字符，只允许中文（1字算2个字符）、英文字母、数字");

	//**检查密码格式 */
	$.validator.addMethod("checkPsd", function (value, element) {
		let password = /^[A-Za-z0-9_`~!@#$%^&*()_+-=<>?:"{},.\/;'[\]·！#￥（——）：；“”‘、，《。》？、【】[\]]+$/;
		return this.optional(element) || password.test(value);
	}, "要求6-18个字符，只允许英文字母、数字、符号");

	//**检查姓名 */
	$.validator.addMethod("realName", function (value, element) {
		let realName = /^[\u4E00-\u9FA5]{2,5}$/;
		return this.optional(element) || realName.test(value);
	}, "姓名只能为2-5个汉字");

	//**中文计为两个字符 */
	$.validator.addMethod("isChinese", function (value, element) {
		let length = value.length;
		for (let i = 0; i < value.length; i++) {
			let c = value.charAt(i);
			(c.match(/[^\x00-\xff]/ig) != null) ? length++ : "";
		}
		return this.optional(element) || (length <= 16 && length >= 4);
	}, "要求4-16个字符，只允许中文（1字算2个字符）、英文字母、数字");

});
