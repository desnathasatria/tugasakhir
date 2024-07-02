get_data();

$(function () {
	bsCustomFileInput.init();
});

$(".akses").select2({
	theme: "bootstrap4",
});

$(".akses").on("change", function () {
	filterData();
});

function filterData() {
	$("#example").DataTable().search($(".akses").val()).draw();
}

document.addEventListener("DOMContentLoaded", function () {
	var showPasswordCheckbox = document.getElementById("showPasswordCheckbox");
	var passwordInput = document.getElementById("password");
	var passwordInput1 = document.getElementById("password1");

	showPasswordCheckbox.addEventListener("change", function () {
		if (showPasswordCheckbox.checked) {
			passwordInput.type = "text";
			passwordInput1.type = "text";
		} else {
			passwordInput.type = "password";
			passwordInput1.type = "password";
		}
	});
});

function previewImage(event) {
	const imageInput = event.target;
	const imagePreview = document.getElementById("imagePreview");

	if (imageInput.files && imageInput.files[0]) {
		const reader = new FileReader();

		reader.onload = function (e) {
			imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview Image" class="img-thumbnail" style="width: 100px; height: auto;">`;
		};
		$("#error-image").html("");

		reader.readAsDataURL(imageInput.files[0]);
	} else {
		imagePreview.innerHTML = "";
	}
}

function delete_form() {
	const imagePreview = document.getElementById("imagePreview");
	const imagePreview1 = document.getElementById("imagePreviewCard");
	$("[name='id']").val("");
	$("[name='nama']").val("");
	$("[name='email']").val("");
	$("[name='telepon']").val("");
	$("[name='alamat']").val("");
	$("#akses").val("").trigger("change");
	$("[name='image']").val("");
	$("[name='username']").val("");
	$("[name='password']").val("");
	$("[name='password1']").val("");
	imagePreview.innerHTML = "";
}

function delete_error() {
	$("#error-nama").hide();
	$("#error-email").hide();
	$("#error-telepon").hide();
	$("#error-alamat").hide();
	$("#error-image").hide();
	$("#error-akses").hide();
	$("#error-username").hide();
	$("#error-password").hide();
	$("#error-password1").hide();
}

$("#hapusAdmin").on("show.bs.modal", function (e) {
	var button = $(e.relatedTarget);
	var id = button.data("id");
	var modalButton = $(this).find("#btn-hapus");
	modalButton.attr("onclick", "delete_data(" + id + ")");
});

function get_data() {
	delete_error();
	$.ajax({
		url: base_url + _controller + "/get_data",
		method: "GET",
		dataType: "json",
		success: function (data) {
			var table = $("#example").DataTable({
				destroy: true,
				data: data,
				columns: [
					{
						data: null,
						className: "text-center",
						render: function (data, type, row, meta) {
							return meta.row + 1;
						},
					},
					{ data: "name" },
					{ data: "email" },
					{ data: "address" },
					{ data: "akses" },
					{
						data: "image",
						className: "text-center",
						render: function (data, type, row) {
							var imageUrl = base_url + "assets/image/user/" + data;
							return (
								'<img src="' +
								imageUrl +
								'" style="max-width: 100px; max-height: 400px;">'
							);
						},
					},
					{
						data: null,
						className: "text-center",
						render: function (data, type, row) {
							return (
								'<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" title="edit" onclick="submit(' +
								row.id +
								')"><i class="fa-solid fa-pen-to-square"></i></button> ' +
								'<button class="btn btn-warning" data-toggle="modal" data-target="#hapusAdmin" title="hapus" data-id="' +
								row.id +
								'"><i class="fa-solid fa-trash-can"></i></button>'
							);
						},
					},
				],
				initComplete: function () {
					// Set column titles alignment to center
					$("th").css("text-align", "center");
				},
				drawCallback: function (settings) {
					var api = this.api();
					api
						.column(0, { search: "applied", order: "applied" })
						.nodes()
						.each(function (cell, i) {
							cell.innerHTML = i + 1;
						});
				},
			});
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(xhr.statusText);
		},
	});
}

function submit(x) {
	var label = document.getElementById("passwordLabel");
	var label1 = document.getElementById("passwordLabel1");
	var input = document.getElementById("password");
	var input1 = document.getElementById("password1");
	const imagePreview = document.getElementById("imagePreview");

	if (x == "tambah") {
		$("#btn-tambah").show();
		$("#btn-ubah").hide();
		input.readOnly = false;
		label.textContent = "Password";
		label1.textContent = "Ulangi";
		input1.placeholder = "Ulangi Password";
	} else {
		$("#btn-tambah").hide();
		$("#btn-ubah").show();
		input.readOnly = true;
		label.textContent = "Password Hash";
		label1.textContent = "Password Baru";
		input1.placeholder = "Masukkan Password Baru";

		$.ajax({
			type: "POST",
			data: "id=" + x,
			url: base_url + "/" + _controller + "/get_data_id",
			dataType: "json",
			success: function (hasil) {
				$("[name='id']").val(hasil[0].id);
				$("[name='nama']").val(hasil[0].name);
				$("[name='email']").val(hasil[0].email);
				$("[name='telepon']").val(hasil[0].phone_number);
				$("[name='alamat']").val(hasil[0].address);
				$("#akses").val(hasil[0].id_credential).trigger("change");
				var profil = hasil[0].image;
				imagePreview.innerHTML = `<img src="${base_url}assets/image/user/${profil}" class="img-thumbnail" alt="Preview Image" style="width: 100px; height: auto;">`;
				$("[name='username']").val(hasil[0].username);
				$("[name='password']").val(hasil[0].password);
			},
		});
	}
	delete_form();
	delete_error();
}

function insert_data() {
	var formData = new FormData();
	formData.append("nama", $("[name='nama']").val());
	formData.append("email", $("[name='email']").val());
	formData.append("telepon", $("[name='telepon']").val());
	formData.append("alamat", $("[name='alamat']").val());
	formData.append("akses", $("#akses").val());
	formData.append("username", $("[name='username']").val());
	formData.append("password", $("[name='password']").val());
	formData.append("password1", $("[name='password1']").val());

	var imageInput = $("[name='image']")[0];
	if (imageInput.files.length > 0) {
		formData.append("image", imageInput.files[0]);
	}

	$.ajax({
		type: "POST",
		url: base_url + "/" + _controller + "/insert_data",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			delete_error();
			if (response.errors) {
				for (var fieldName in response.errors) {
					$("#error-" + fieldName).show();
					$("#error-" + fieldName).html(response.errors[fieldName]);
				}
			} else if (response.success) {
				$("#exampleModal").modal("hide");
				$("body").append(response.success);
				get_data();
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}

function edit_data() {
	var formData = new FormData();
	formData.append("id", $("[name='id']").val());
	formData.append("nama", $("[name='nama']").val());
	formData.append("email", $("[name='email']").val());
	formData.append("telepon", $("[name='telepon']").val());
	formData.append("alamat", $("[name='alamat']").val());
	formData.append("akses", $("#akses").val());
	formData.append("username", $("[name='username']").val());
	formData.append("password1", $("[name='password1']").val());

	var imageInput = $("[name='image']")[0];
	if (imageInput.files.length > 0) {
		formData.append("image", imageInput.files[0]);
	}

	$.ajax({
		type: "POST",
		url: base_url + _controller + "/edit_data",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			if (response.errors) {
				delete_error();
				for (var fieldName in response.errors) {
					$("#error-" + fieldName).show();
					$("#error-" + fieldName).html(response.errors[fieldName]);
				}
			} else if (response.success) {
				$("#exampleModal").modal("hide");
				$("body").append(response.success);
				get_data();
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}

function delete_data(x) {
	$.ajax({
		type: "POST",
		data: "id=" + x,
		url: base_url + _controller + "/delete_data",
		success: function (response) {
			console.log(response);
			$("body").append(response.success);
			get_data();
		},
	});
}

// get_profil();

function get_profil() {
	delete_error();
	$.ajax({
		url: base_url + "/" + _controller + "/get_profil",
		method: "GET",
		dataType: "json",
		success: function (data) {
			$("[name='id']").val(data[0].id);
			$("[name='nama']").val(data[0].name);
			$("[name='email']").val(data[0].email);
			$("[name='telepon']").val(data[0].phone_number);
			$("[name='akses']").val(data[0].akses);
			$("[name='alamat']").val(data[0].address);
			var nama = data[0].image;
			imageProfil.innerHTML = `<img src="${base_url}assets/image/user/${nama}" class="img-thumbnail" alt="Preview Image" style="width: 100px; height: auto;">`;
			$("[name='username']").val(data[0].username);
			$("[name='password']").val(data[0].password);
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(xhr.statusText);
		},
	});
}

function edit_profil() {
	var formData = new FormData();
	formData.append("id", $("[name='id']").val());
	formData.append("nama", $("[name='nama']").val());
	formData.append("email", $("[name='email']").val());
	formData.append("telepon", $("[name='telepon']").val());
	formData.append("alamat", $("[name='alamat']").val());
	formData.append("username", $("[name='username']").val());
	formData.append("password1", $("[name='password1']").val());

	var imageInput = $("[name='image']")[0];
	if (imageInput.files.length > 0) {
		formData.append("image", imageInput.files[0]);
	}

	$.ajax({
		type: "POST",
		url: base_url + _controller + "/edit_profil",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			if (response.errors) {
				delete_error();
				for (var fieldName in response.errors) {
					$("#error-" + fieldName).show();
					$("#error-" + fieldName).html(response.errors[fieldName]);
				}
			} else if (response.success) {
				delete_error();
				$("body").append(response.success);
				get_profil();
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}
