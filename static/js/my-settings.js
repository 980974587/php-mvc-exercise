//var hobby=localStorage.getItem("hobby").split(',');
$(document).ready(function () {
	var job = $('input:radio[name="job"]');
	($('input:radio[name="job"]:checked').val() == '上班族') ? $('label[for=schoolOrCompany]').html("公司：") : $('label[for=schoolOrCompany]').html("学校：");
	const edithobby = $('#editForm input:checkbox[name=hobby]');
	const save = $('#save');


	//**单选框的改变事件 */
	job.change(function (index, element) {
		job = $('input:radio[name="job"]:checked');
		(job.val() == 'worker') ? $('label[for=schoolOrCompany]').html("公司：") : $('label[for=schoolOrCompany]').html("学校：");
	});

	$(".editJobRadio").click(function (index, element) {
		$(this).prev('input').prop("checked", true);
		job = $('input:radio[name="job"]:checked');
		(job.val() == 'worker') ? $('label[for=schoolOrCompany]').html("公司：") : $('label[for=schoolOrCompany]').html("学校：");
	});

	/**编辑的复选框文字点击事件 */
	$(".editHobby").click(function () {
		if ($(this).prev('input').is(":checked")) {
			editedhobbyList.splice($.inArray($(this).prev('input').val(), editedhobbyList), 1);
			$(this).prev('input').prop("checked", false);
		} else {
			$(this).prev('input').prop("checked", true);
			editedhobbyList.push($(this).prev('input').val());
		}
	})

	//**修改信息的表单验证 */														
	var Validator = $("#editForm").validate(
		{
			rules:
			{
				//username和password是对应的name
				email: {
					required: true,
				},
				trueName: {
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
				"hobby[]": {
					required: true,
				}
			},
			messages:
			{
				email: {
					required: "请填写电子邮箱",
					email: "请输入正确邮箱地址"
				},
				trueName: {
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
				"hobby[]": {
					required: "请至少选择一项爱好",
				}
			},
			//**表单提交事件 */
			submitHandler: function () {
				form.submit();
				form.reset();
			},
			errorPlacement: function (error, element) {
				error.css({ "color": "red" });
				error.appendTo(element.parent());
			},
		});


	//** 检查用户名格式*/
	$.validator.addMethod("checkUser", function (value, element) {
		var username = /^[\u4E00-\u9FA5A-Za-z0-9]+$/;
		return this.optional(element) || username.test(value);
	}, "4-16个字符，只允许中文（1字算2个字符）、英文字母、数字");

	//**检查密码格式 */
	$.validator.addMethod("checkPsd", function (value, element) {
		var password = /^[A-Za-z0-9_`~!@#$%^&*()_+-=<>?:"{},.\/;'[\]·！#￥（——）：；“”‘、，|《。》？、【】[\]]+$/;
		return this.optional(element) || password.test(value);
	}, "要求6-18个字符，只允许英文字母、数字、符号");

	//**检查姓名 */
	$.validator.addMethod("realName", function (value, element) {
		var realName = /^[\u4E00-\u9FA5]{2,5}$/;
		return this.optional(element) || realName.test(value);
	}, "姓名只能为2-5个汉字");

	//**中文字符计为两个字符 */
	$.validator.addMethod("isChinese", function (value, element) {
		var length = value.length;
		for (let i = 0; i < value.length; i++) {
			var c = value.charAt(i);
			(c.match(/[^\x00-\xff]/ig) != null) ? length++ : "";
		}
		return this.optional(element) || (length <= 16 && length >= 4);
	}, "要求4-16个字符，只允许中文（1字算2个字符）、英文字母、数字");

})

