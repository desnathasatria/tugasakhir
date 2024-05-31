delete_1();
delete_2();
delete_3();

function previewImage(event, imageContainerId) {
	const imageInput = event.target;
	const imageContainer = document.getElementById(imageContainerId);

	if (imageInput.files && imageInput.files[0]) {
		const reader = new FileReader();

		reader.onload = function (e) {
			imageContainer.innerHTML = `<img src="${e.target.result}" alt="Preview Image" class="img-thumbnail" style="width: 100px; height: auto;">`;
		};

		reader.readAsDataURL(imageInput.files[0]);
	} else {
		imageContainer.innerHTML = "";
	}
}

function delete_2() {
	$("#error-ktp2").hide();
	$("#error-pengantar2").hide();
}

function delete_3() {
	$("#error-ktp3").hide();
	$("#error-pengantar3").hide();
}

function delete_1() {
	$("#error-kk1").hide();
	$("#error-kia1").hide();
	$("#error-akta1").hide();
	$("#error-pengantar1").hide();
}

function insert_1() {
	delete_1();
	var kiaInput = $("[name='kia1']")[0];
	var pengantarInput = $("[name='pengantar1']")[0];
	var kkInput = $("[name='kk1']")[0];
	var aktaInput = $("[name='akta1']")[0];

	var formData = new FormData();
	if (kiaInput.files.length > 0) {
		formData.append("kia", kiaInput.files[0]);
	}
	if (pengantarInput.files.length > 0) {
		formData.append("pengantar", pengantarInput.files[0]);
	}
	if (kkInput.files.length > 0) {
		formData.append("kk", kkInput.files[0]);
	}
	if (aktaInput.files.length > 0) {
		formData.append("akta", aktaInput.files[0]);
	}

	$.ajax({
		type: "POST",
		url: base_url + _controller + "/insert_1",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			delete_1();
			if (response.errors) {
				for (var fieldName in response.errors) {
					$("#error-" + fieldName).show();
					$("#error-" + fieldName).html(response.errors[fieldName]);
				}
			} else if (response.success) {
				$("#modalAjukan_1").modal("hide");
				window.location.href = "history";
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
			console.log("Response Text:", xhr.responseText);
		},
	});
}

function insert_2() {
	delete_2();
	var ktpInput = $("[name='ktp2']")[0];
	var pengantarInput = $("[name='pengantar2']")[0];

	var formData = new FormData();
	if (ktpInput.files.length > 0) {
		formData.append("ktp", ktpInput.files[0]);
	}
	if (pengantarInput.files.length > 0) {
		formData.append("pengantar", pengantarInput.files[0]);
	}

	$.ajax({
		type: "POST",
		url: base_url + _controller + "/insert_2",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			delete_2();
			if (response.errors) {
				for (var fieldName in response.errors) {
					$("#error-" + fieldName).show();
					$("#error-" + fieldName).html(response.errors[fieldName]);
				}
			} else if (response.success) {
				$("#modalAjukan_2").modal("hide");
				window.location.href = "history";
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
			console.log("Response Text:", xhr.responseText);
		},
	});
}

function insert_3() {
	delete_3();
	var ktpInput = $("[name='ktp3']")[0];
	var pengantarInput = $("[name='pengantar3']")[0];

	var formData = new FormData();
	if (ktpInput.files.length > 0) {
		formData.append("ktp", ktpInput.files[0]);
	}
	if (pengantarInput.files.length > 0) {
		formData.append("pengantar", pengantarInput.files[0]);
	}

	$.ajax({
		type: "POST",
		url: base_url + _controller + "/insert_3",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			delete_3();
			if (response.errors) {
				for (var fieldName in response.errors) {
					$("#error-" + fieldName).show();
					$("#error-" + fieldName).html(response.errors[fieldName]);
				}
			} else if (response.success) {
				$("#modalAjukan_3").modal("hide");
				window.location.href = "history";
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
			console.log("Response Text:", xhr.responseText);
		},
	});
}
