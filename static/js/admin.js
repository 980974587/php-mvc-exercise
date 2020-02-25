$(document).ready(function () {

	//各类选框
	let hobbyList = [];
	let editedhobbyList = [];
	let hobby = $('#addForm input:checkbox[name=newhobby]');
	let edithobby = $('#editForm input:checkbox[name=hobby]');
	let newJob = $('#addForm input:radio[name="job"]');
	let editJob = $('#editForm input:radio[name="editJob"]');
	let searchJob='';
	const showSelect = ["用户名","角色", "姓名", "邮箱", "学校/公司", "兴趣爱好"];
	const trueSelect = ["username","role", "truename", "email", "schoolOrCompany", "hobby"];
	const tab = $(".jobKey");
	let selectedID = 0;

	tab.click(function () {
		let searchKey = "";
		let keyWord=$("#searchKey").val();
		if ($("#searchKey").val() != "") {
			if($("#searchKey").val()=='管理员')
			{
				keyWord='admin';
			}
			if($("#searchKey").val()=='成员')
			{
				keyWord='member';
			}
			searchKey = "&keyName=" + trueSelect[$.inArray($.trim($("#selectedKey").html()), showSelect)] + "&keyWord=" +
			keyWord;	
		}

		if ($(this).html() != "全部") {
			$(this).html()=="学生"?searchJob="student":searchJob="worker";
			window.location.href = "index.php?controller=user&action=index&jobKey=" +searchJob+searchKey;
		} else {
			window.location.href = "index.php?controller=user&action=index" + searchKey;
		}
	})

	//删除成功的警告框
	if (sessionStorage.getItem('deleted') && sessionStorage.getItem('deleted') == "yes") {
		let deleteMessage = $("<div class='alert alert-success alert-dismissible fade show mt-2 ' role='alert'>" +
			"删除成功<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
			"<span aria-hidden='true'>&times;</span>" +
			"</button>" +
			"</div>");
		$(".table").before(deleteMessage);
		sessionStorage.removeItem('deleted');
	}

	//权限的警告框
	if (sessionStorage.getItem('warn') && sessionStorage.getItem('warn') == "yes") {
		let deleteMessage = $("<div class='alert alert-success alert-dismissible fade show mt-2 ' role='alert'>" +
			sessionStorage.getItem('message')+"<button type='button' class='close' data-dismiss='alert' aria-label='Close'>" +
			"<span aria-hidden='true'>&times;</span>" +
			"</button>" +
			"</div>");
		$(".table").before(deleteMessage);
		sessionStorage.removeItem('warn');
		sessionStorage.removeItem('message');
	}


	//**新增模态框单选框的改变事件 */
	newJob.change(function (index, element) {
		newJob = $('#addForm input:radio[name="job"]:checked');
		if (newJob.val() == 'worker') {
			$('#addForm label[for=schoolOrCompany]').html("公司:");
		} else if (newJob.val() == 'student') {
			$('#addForm label[for=schoolOrCompany]').html("学校:");
		}
	});

	//**下拉选框的选中变化 */
	$('.dropdown-item').each(function () {
		$(this).click(function () {
			$('.btn-key').html($(this).html());
		});
	});


	//**用户点击了详情按钮 
	$('.detail').click(function () {
		$.get("index.php?controller=user&action=detailModal",
			{
				"id": $(this).val(),
			},
			function (data) {
				data.job=="student"?job="学生":job="上班族";
				data.role=='admin'?role="管理员":role="成员";
				$("#showUsername").html(data.username);
				$("#showRole").html(role);
				$("#showTrueName").html(data.truename);
				$("#showEmail").html(data.email);
				$("#showAge").html(data.age);
				$("#showJob").html(job);
				$("#showSchoolOrJob").html(data.schoolOrCompany);
				$("#showHobby").html(data.hobby);
			})
	});


	/** 搜索 */
	$("#search").click(function () {
		let keyWord=$("#searchKey").val();
		if($("#searchKey").val()=='管理员')
		{
			keyWord='admin';
		}
		if($("#searchKey").val()=='成员')
		{
			keyWord='member';
		}
		if ($("#searchKey").val() == "") {
			alert("请输入关键字！");
		}
		else if ($(".active").html() != "全部") {
			$(".active").html()=="学生"?searchJob="student":searchJob="worker";
			window.location.href = "index.php?controller=user&action=index&keyName=" +
				trueSelect[$.inArray($.trim($("#selectedKey").html()), showSelect)] + "&keyWord=" +
				keyWord + "&jobKey=" + searchJob;
		} else {
			window.location.href = "index.php?controller=user&action=index&keyName=" +
				trueSelect[$.inArray($.trim($("#selectedKey").html()), showSelect)] + "&keyWord=" +
				keyWord;
		}
	})


	//***添加用户模态框的复选框的改变事件：获取复选框的值*/
	hobby.change(function () {
		//选中就新增，否则遍历有重复就删除该元素
		if (hobbyList.length == 0 || $(this).is(":checked")) {
			hobbyList.push($(this).val());
		} else {
			hobbyList.splice($.inArray($(this).val(),hobbyList),1);
		}
	});

	/**添加用户的单选框改变事件 */
	$(".addJob").click(function(){
		$(this).find("input").prop("checked",true);
		newJob = $('#addForm input:radio[name="job"]:checked');
		if (newJob.val() == 'worker') {
			$('#addForm label[for=schoolOrCompany]').html("公司:");
		} else if (newJob.val() == 'student') {
			$('#addForm label[for=schoolOrCompany]').html("学校:");
		}
	})

	/**添加用户复选框文字的点击事件 */
	$(".addHobby").click(function(){
		if ($(this).prev('input').is(":checked")) {
			$(this).prev('input').prop("checked", false);
			hobbyList.splice($.inArray($(this).prev('input').val(),hobbyList),1);
		} else {
			$(this).prev('input').prop("checked", true);
			hobbyList.push($(this).prev('input').val());

		}
	})

	//** 用户点击了添加按钮*/
	$('.chooseAdd').click(function () {
		$.ajax(
			{
				type: "get",
				url: "index.php?controller=user&action=addModal",
				contentType: "application/x-www-form-urlencoded",
				dataType: "json",
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					alert(XMLHttpRequest.status);
					alert(XMLHttpRequest.readyState);
					alert(textStatus);
				},
				success: function (data) {
					if (data.status == "forbidden") {
						$(".modal-title").html("警告！");
						$(".modal-body").html("您无权操作！");
						$("#add").css("visibility", "hidden");
					}
				}
			});
	});

	//添加用户
	$('#add').click('hidden.bs.modal', function (e) {
		$("#addForm").submit();
	})


	//编辑用户模态框的复选框改变事件
	edithobby.change(function () {
		//选中就新增，否则遍历有重复就删除该元素
		if (editedhobbyList.length == 0 || $(this).is(":checked")) {
			editedhobbyList.push($(this).val());
		} else {
			editedhobbyList.splice($.inArray($(this).val(),editedhobbyList),1);
		}
	});

	//**单选框的改变事件 */
	editJob.change(function (index, element) {
		editJob = $('#editForm input:radio[name="editJob"]:checked');
		(job.val() == 'worker') ? $('#editForm label[for=schoolOrCompany]').html("公司：") : $('#editForm label[for=schoolOrCompany]').html("学校：");
	});

	$(".editJobRadio").click(function (index, element) {
		$(this).prev('input').prop("checked", true);
		job = $('input:radio[name="job"]:checked');
		(job.val() == 'worker') ? $('label[for=schoolOrCompany]').html("公司：") : $('label[for=schoolOrCompany]').html("学校：");
	});

	//**编辑模态框单选框的文字点击事件 */
	$(".editRoleRadio,.editJobRadio").click(function (index, element) {
		$(this).find('input').prop("checked", true);
		editJob = $('#editForm input:radio[name="editJob"]:checked');
		if (editJob.val() == 'worker') {
			$('#editForm label[for=schoolOrCompany]').html("公司:");
		} else if (newJob.val() == 'student') {
			$('#editForm label[for=schoolOrCompany]').html("学校:");
		}
	});




	/**编辑的复选框文字点击事件 */
	$(".editHobby").click(function () {
		if ($(this).prev('input').is(":checked")) {
			editedhobbyList.splice($.inArray($(this).prev('input').val(),editedhobbyList),1);
			$(this).prev('input').prop("checked", false);
		} else {
			$(this).prev('input').prop("checked", true);
				editedhobbyList.push($(this).prev('input').val());
		}
	})


	//保存编辑后的用户信息
	$('#edit').click('hidden.bs.modal', function (e) {
		$("#editForm").submit();
	})


	//**用户点击了编辑按钮 
	$(".edit").click(function () {

		$.ajax({
			type: "get",
			url: "index.php?controller=user&action=editModal",
			contentType: "application/x-www-form-urlencoded",
			dataType: "json",
			data: { "id": $(this).val() },
			error: function (xhr, textStatus, ) {
				alert("错误：\n" + "当前状态：" + xhr.readyState + "\n状态码：" + xhr.status + "," + xhr.responseText);
			},
			success: function (data) {
				if (data.status == "forbidden") {
					$("exampleModalLabel").html("警告");
					$("#editModal .modal-body").html("没有权限");
					$("#editModal .modal-body").css("visibility", "hidden");
				} else {
					selectedID=data.id;
					$("#editUsername").val(data.username);
					if (data.role == "admin") {
						$("#administator").prop("checked", true);
					} else {
						$("#member").prop("checked", true);
					}
					$("#editTrueName").val(data.truename);
					$("#editEmail").val(data.email);
					$("#editAge").val(data.age);
					if (data.job == "student") {
						$("#student").prop("checked", true);
						$('#editModal label[for=schoolOrCompany]').html("学校:");
					} else {
						$("#worker").prop("checked", true);
						$('#editModal label[for=schoolOrCompany]').html("公司:");
					}
					$("#editSchoolOrCompany").val(data.schoolOrCompany);
					editedhobbyList = data.hobby.split(',');
					//显示原有爱好
					edithobby.prop("checked", false);
					for (let i = 0; i < editedhobbyList.length; i++) {
						edithobby.each(function () {
							($(this).val() == editedhobbyList[i]) ? $(this).prop("checked", true)
								: $(this).attr("checked", false);
						});
					}
				}
			}
		});

	})


	/** 用户点击了删除*/
	$(".delete").click(function () {
		selectedID = $(this).val();
	})

	/**确认删除 */
	$("#delete").click(function () {
		$.ajax({
			type: "post",
			url: "index.php?controller=user&action=delete",
			// url:"test.php",
			contentType: "application/x-www-form-urlencoded",
			dataType: "json",
			data: { "id": selectedID },
			error: function (xhr, textStatus, ) {
				alert("错误：\n" + "当前状态：" + xhr.readyState + "\n状态码：" + xhr.status + "," + xhr.responseText);
			},
			success: function (data) {
				switch (data.status) {
					case "forbidden":
						sessionStorage.setItem('warn', 'yes');
						sessionStorage.setItem('message', '没有权限！');
						break;
					case "error":
						$("exampleModalLabel").html(data.message);
						break;
					default:
						$("#deleteModal").modal("hide");
						sessionStorage.setItem('deleted', 'yes');
						location.reload();
						break;
				}
			}
		});
	})

 	//编辑模态框的邮箱和用户名查重
 	$("#editForm input").not("#editUsername").blur(function () {

 		$.ajax({
 			type: "GET",
 			url: "index.php?controller=register&action=checkExisted",
 			contentType: "application/x-www-form-urlencoded",
 			dataType: "json",
 			data: 
 			{
				"id":selectedID,
 				"email": $("#editEmail").val(),
 			},
 			error: function (xhr) { alert("错误：" + xhr.responseText) },
 			success: function (data) 
 			{
				
				if (data.status == "error") {
					//注册失败的警告框
					$("#editModal #exampleModalLabel").html(data.message);
					$("#editModal #exampleModalLabel").css({"color":"red"});
				}else
				{
					$("#editModal #exampleModalLabel").html("编辑用户");
					$("#editModal #exampleModalLabel").css({"color":"black"});
				}
 			}
 		})
 	});


		//新增模态框的邮箱和用户名查重
		$("#addForm input").blur(function () {
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
						$("#exampleModal #exampleModalLabel").html(data.message);
						$("#exampleModal #exampleModalLabel").css({"color":"red"});
					}else
					{
						$("#exampleModal #exampleModalLabel").html("添加用户");
						$("#exampleModal #exampleModalLabel").css({"color":"black"});
					}
				}
			})
		});


	//**新增的表单验证 */															
	let Validator = $("#addForm").validate(
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
					rangelength: [6, 8],
					checkPsd: true
				},
				"confirm-password": {
					equalTo: "#password"
				},
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
				newhobby: {
					required: "请至少选择一项爱好",
				}
			},
			//** 表单提交事件*/
			submitHandler: function () {
				$.ajax({
					type: "POST",
					url: "index.php?controller=user&action=addModal",
					contentType: "application/x-www-form-urlencoded",
					dataType: "json",
					data: {
						"username": $("#username").val(),
						"password": $("#password").val(),
						"truename": $("#trueName").val(),
						"email": $("#email").val(),
						"age": $("#age").val(),
						"job": $('#exampleModal input:radio[name="job"]:checked').val(),
						"schoolOrCompany": $("#schoolOrCompany").val(),
						"hobby": hobbyList.join(","),
					},
					error: function (xhr) { alert("错误：" + xhr.responseText) },
					success: function (data) {
						$("#exampleModal").modal('hide');
						switch (data.status) {
							case "unlogin":
								window.location.href("index.php?controller=auth&action=login");
								break;
							case "forbidden":
								alert("没有权限！");
								break;
							case "error":
								$("#exampleModal #exampleModalLabel").html(data.message);
								break;
							default:
								location.reload();
								break;
						}
					}
				})
			},
			errorPlacement: function (error, element) {
				error.css({ "color": "red" });
				error.appendTo(element.parent());
			},
		});


	//**编辑保存的表单验证 */															
	Validator = $("#editForm").validate(
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
					rangelength: [6, 8],
					checkPsd: true
				},
				"confirm-password": {
					equalTo: "#password"
				},
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
				hobby: {
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
				hobby: {
					required: "请至少选择一项爱好",
				}
			},
			//** 表单提交事件*/
			submitHandler: function (e) {
				$.ajax({
					type: "POST",
					url: "index.php?controller=user&action=editModal",
					contentType: "application/x-www-form-urlencoded",
					data: {
						"username": $("#editUsername").val(),
						"role": $('#editModal input:radio[name="role"]:checked').val(),
						"truename": $("#editTrueName").val(),
						"email": $("#editEmail").val(),
						"age": $("#editAge").val(),
						"job": $('#editModal input:radio[name="editJob"]:checked').val(),
						"schoolOrCompany": $("#editSchoolOrCompany").val(),
						"hobby": editedhobbyList.join(","),
					},
					error: function (xhr, textStatus, errorThrown) {
						alert("错误：\n" + "当前状态：" + xhr.readyState + "\n状态码：" + xhr.status + "," + xhr.responseText);
					},
					success: function (data) {
						switch (data.status) {
							case "error":
								$("#exampleModalLabel").html(data.message);
								break;
							case "ok":
								$("#editModal").modal('hide');
								location.reload();
								break;
							default:
								alert(JSON.stringify(data));
								break;
						}
					}
				})
			},
			errorPlacement: function (error, element) {
				error.css({ "color": "red" });
				error.appendTo(element.parent());
			},
		});



	//** 检查用户名格式*/
	$.validator.addMethod("checkUser", function (value, element) {
		let username = /^[\u4E00-\u9FA5A-Za-z0-9]+$/;
		return this.optional(element) || username.test(value);
	}, "4-16个字符，只允许中文（1字算2个字符）、英文字母、数字");

	//**检查密码格式 */
	$.validator.addMethod("checkPsd", function (value, element) {
		let password = /^[A-Za-z0-9_`~!@#$%^&*()_+-=<>?:"{},.\/;'[\]·！#￥（——）：；“”‘、，|《。》？、【】[\]]+$/;
		return this.optional(element) || password.test(value);
	}, "要求6-18个字符，只允许英文字母、数字、符号");

	//**检查姓名 */
	$.validator.addMethod("realName", function (value, element) {
		let realName = /^[\u4E00-\u9FA5]{2,5}$/;
		return this.optional(element) || realName.test(value);
	}, "姓名只能为2-5个汉字");

	//**中文字符计为两个字符 */
	$.validator.addMethod("isChinese", function (value, element) {
		let length = value.length;
		for (let i = 0; i < value.length; i++) {
			let c = value.charAt(i);
			(c.match(/[^\x00-\xff]/ig) != null) ? length++ : "";
		}
		return this.optional(element) || (length <= 16 && length >= 4);
	}, "要求4-16个字符，只允许中文（1字算2个字符）、英文字母、数字");

});
