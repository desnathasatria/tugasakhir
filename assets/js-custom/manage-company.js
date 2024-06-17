get_data();
load_provinces();

$(function () {
	bsCustomFileInput.init();
});

function delete_error() {
	$("#error-nama").hide();
	$("#error-alamat").hide();
	$("#error-provinsi").hide();
	$("#error-kota").hide();
	$("#error-telepon").hide();
	$("#error-email").hide();
	$("#error-map").hide();
}

function previewImage(event) {
	const imageInput = event.target;
	const imagePreview = document.getElementById("imagePreview");

	if (imageInput.files && imageInput.files[0]) {
		const reader = new FileReader();

		reader.onload = function (e) {
			imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview Image" class="img-thumbnail" style="max-width: 50%; height: auto;">`;
		};
		$("#error-image").html("");

		reader.readAsDataURL(imageInput.files[0]);
	} else {
		imagePreview.innerHTML = "";
	}
}

function get_data() {
	delete_error();
	$.ajax({
		url: base_url + _controller + "/get_data",
		method: "GET",
		dataType: "json",
		success: function (data) {
			console.log(data);
			$("[name='id']").val(data[0].id_company);
			$("[name='nama']").val(data[0].company_name);
			$("[name='alamat']").val(data[0].address);
			$("[name='provinsi']").val(data[0].province);
			$("[name='kota']").val(data[0].city);
			$("[name='telepon']").val(data[0].phone_number);
			$("[name='email']").val(data[0].email);
			$("[name='map']").val(data[0].embed_address);
			var imageUrl = base_url + "/assets/image/company/" + data[0].company_logo;
			imagePreview.innerHTML = `<img src="${imageUrl}" alt="Preview Image" class="img-thumbnail" style="max-width: 50%; height: auto;">`;

			$("#image").attr("src", imageUrl);

			if (data[0].province && data[0].city) {
				load_cities(data[0].province, data[0].city);
			} else {
				$("#kota").html('<option value="">Pilih Kota</option>');
			}

			var mapUrl = data[0].embed_address;
			$("iframe").attr("src", mapUrl);
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(xhr.statusText);
		},
	});
}

function edit_data() {
	var formData = new FormData();
	formData.append("id", $("[name='id']").val());
	formData.append("nama", $("[name='nama']").val());
	formData.append("alamat", $("[name='alamat']").val());
	formData.append("provinsi", $("[name='provinsi']").val());
	formData.append("kota", $("[name='kota']").val());
	formData.append("telepon", $("[name='telepon']").val());
	formData.append("email", $("[name='email']").val());
	formData.append("map", $("[name='map']").val());

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
				$("body").append(response.success);
				get_data();
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
