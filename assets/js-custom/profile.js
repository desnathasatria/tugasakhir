get_profil();
load_provinces();

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

function delete_error_profile() {
	$("#error-nama").hide();
	$("#error-alamat").hide();
	$("#error-provinsi").hide();
	$("#error-kota").hide();
	$("#error-telepon").hide();
	$("#error-email").hide();
	$("#error-username").hide();
	$("#error-password").hide();
	$("#error-password1").hide();
	$("#error-profil").hide();
}

function get_profil() {
	delete_error_profile();
	$.ajax({
		url: base_url + _controller + "/get_profile",
		method: "GET",
		dataType: "json",
		success: function (data) {
			$("[name='id']").val(data[0].id);
			$("[name='nama']").val(data[0].name);
			$("[name='email']").val(data[0].email);
			$("[name='telepon']").val(data[0].phone_number);
			$("[name='alamat']").val(data[0].address);
			$("[name='provinsi']").val(data[0].province);
			$("[name='kota']").val(data[0].city);
			$("[name='username']").val(data[0].username);
			$("[name='password']").val(data[0].password);
			$("[name='password1']").val(data[0].password1);

			var imageSrc = base_url + "assets/image/user/" + data[0].image;
			$("[name='profile_user']").attr("src", imageSrc);

			if (data[0].province && data[0].city) {
				load_cities(data[0].province, data[0].city);
			} else {
				$("#kota").html('<option value="">Pilih Kota</option>');
			}
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
	formData.append("provinsi", $("[name='provinsi']").val());
	formData.append("kota", $("[name='kota']").val());
	formData.append("username", $("[name='username']").val());
	formData.append("password1", $("[name='password1']").val());

	var imageInput = $("[name='profil']")[0];
	if (imageInput.files.length > 0) {
		formData.append("profil", imageInput.files[0]);
	}

	$.ajax({
		type: "POST",
		url: base_url + _controller + "/edit_profile",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			if (response.errors) {
				delete_error_profile();
				for (var fieldName in response.errors) {
					$("#error-" + fieldName).show();
					$("#error-" + fieldName).html(response.errors[fieldName]);
				}
			} else if (response.success) {
				window.location.href = "profile";
				get_profil();
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}

function load_provinces() {
	$.getJSON(base_url + "RajaongkirController/provinces", function (data) {
		$("#provinsi").html('<option value="">Pilih Provinsi</option>');
		$.each(data.rajaongkir.results, function (key, val) {
			$("#provinsi").append(
				'<option value="' + val.province_id + '">' + val.province + "</option>"
			);
		});
	});
}

$("#provinsi").change(function () {
	var provinceId = $(this).val();
	if (provinceId !== "") {
		load_cities(provinceId);
	} else {
		$("#kota").html('<option value="">Pilih Kota</option>');
	}
});

function load_cities(provinceId, selectedCityId) {
	$.getJSON(
		base_url + "RajaongkirController/cities/" + provinceId,
		function (data) {
			$("#kota").html('<option value="">Pilih Kota</option>');
			$.each(data.rajaongkir.results, function (key, val) {
				$("#kota").append(
					'<option value="' + val.city_id + '">' + val.city_name + "</option>"
				);
			});

			if (selectedCityId && provinceId) {
				$("#provinsi").val(provinceId);
				$("#kota").val(selectedCityId);
			}
		}
	);
}
