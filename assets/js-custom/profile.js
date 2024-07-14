var currentUrl = window.location.href;

if (currentUrl.includes(base_url + "profile")) {
	get_profil();
	load_provinces();
	get_address();
}

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
			console.log(data);
			$("[name='id']").val(data[0].id);
			$("[name='nama']").val(data[0].name);
			$("[name='email']").val(data[0].email);
			$("[name='telepon']").val(data[0].phone_number);
			$("[name='provinsi']").val(data[0].province);
			$("[name='kota']").val(data[0].city);
			$("[name='username']").val(data[0].username);
			$("[name='password']").val(data[0].password);
			$("[name='password1']").val(data[0].password1);
			$("[name='alamat']").val(data[0].address);
			var imageSrc = base_url + "assets/image/user/" + data[0].image;
			$("[name='profile_user']").attr("src", imageSrc);

			$.ajax({
				url:
					base_url + "RajaongkirController/province_name/" + data[0].province,
				method: "GET",
				dataType: "json",
				success: function (hasil) {
					$("[name='province']").val(hasil.nama_provinsi);
				},
				error: function (xhr, textStatus, errorThrown) {
					console.log(xhr.statusText);
				},
			});

			$.ajax({
				url:
					base_url +
					"RajaongkirController/city_name/" +
					data[0].city +
					"/" +
					data[0].province,
				method: "GET",
				dataType: "json",
				success: function (hasil1) {
					$("[name='city']").val(hasil1.nama_kota);
				},
				error: function (xhr, textStatus, errorThrown) {
					console.log(xhr.statusText);
				},
			});
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

function get_address() {
	$.ajax({
		url: base_url + _controller + "/get_data_address",
		method: "GET",
		dataType: "json",
		success: function (data) {
			var no = 1;
			$("#data_alamat").empty();
			if (Object.keys(data).length === 0) {
				var html = "<b class='mb-1 mt-1'>Belum ada alamat</b>";
				$("#data_alamat").html(html);
			} else {
				data.forEach(function (item) {
					var provinceRequest = $.ajax({
						url:
							base_url + "RajaongkirController/province_name/" + item.province,
						method: "GET",
						dataType: "json",
					});

					var cityRequest = $.ajax({
						url:
							base_url +
							"RajaongkirController/city_name/" +
							item.city +
							"/" +
							item.province,
						method: "GET",
						dataType: "json",
					});

					$.when(provinceRequest, cityRequest)
						.done(function (provinceResult, cityResult) {
							var province_name = provinceResult[0].nama_provinsi;
							var city_name = cityResult[0].nama_kota;
							if (item.is_active == 1) {
								var status_alamat = " - (Alamat utama)";
							} else {
								var status_alamat = "";
							}
							var list = `<div class="col-lg-6">
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <h5 class="card-title">Alamat ${no} ${status_alamat}</h5>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">${item.address}</h6>
                                                <p class="card-text">${city_name}, ${province_name}</p>
                                                <a href="#" class="card-link" data-bs-toggle="modal" data-bs-target="#modalAlamat" onclick="submit_address(${item.id})">Edit</a>
                                                <a href="#" class="card-link" onclick="delete_address(${item.id})">Hapus</a>
                                                <a href="#" class="card-link" onclick="edit_status_address(${item.id})">Set alamat utama</a>
                                            </div>
                                        </div>
                                    </div>`;
							$("#data_alamat").append(list);
							no++;
						})
						.fail(function (xhr, textStatus, errorThrown) {
							console.log(xhr.statusText);
						});
				});
			}
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(xhr.statusText);
		},
	});
}
function delete_error() {
	$("#error-alamat1").hide();
	$("#error-provinsi").hide();
	$("#error-kota").hide();
}

function delete_form() {
	$("[name='id_alamat']").val("");
	$("[name='alamat1']").val("");
	$("#provinsi").val("").trigger("change");
	$("#kota").val("").trigger("change");
}

function submit_address(x) {
	if (x == "tambah") {
		$("#btn-tambah1").show();
		$("#btn-ubah").hide();
	} else {
		$("#btn-tambah1").hide();
		$("#btn-ubah").show();

		$.ajax({
			type: "POST",
			data: "id=" + x,
			url: base_url + "/" + _controller + "/get_address_id",
			dataType: "json",
			success: function (hasil) {
				$("[name='id_alamat']").val(hasil[0].id);
				$("[name='alamat1']").val(hasil[0].address);
				if (hasil[0].province && hasil[0].city) {
					load_cities(hasil[0].province, hasil[0].city);
				} else {
					$("#kota").html('<option value="">Pilih Kota</option>');
				}
			},
		});
	}
	delete_form();
	delete_error();
}

function insert_address() {
	var formData = new FormData();
	formData.append("alamat1", $("[name='alamat1']").val());
	formData.append("provinsi", $("#provinsi").val());
	formData.append("kota", $("#kota").val());

	$.ajax({
		type: "POST",
		url: base_url + "/" + _controller + "/insert_address",
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
				$("#modalAlamat").modal("hide");
				get_address();
				alertify.success("Berhasil menambah alamat");
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}

function delete_address(x) {
	$.ajax({
		type: "POST",
		data: "id=" + x,
		dataType: "json",
		url: base_url + _controller + "/delete_address",
		success: function (response) {
			if (response.success) {
				get_address();
				alertify.success("Berhasil menghapus alamat");
			} else if (response.error) {
				alertify.error(response.error);
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}

function edit_status_address(x) {
	$.ajax({
		type: "POST",
		data: "id=" + x,
		dataType: "json",
		url: base_url + _controller + "/edit_status_address",
		success: function (response) {
			if (response.success) {
				// get_address();
				// get_profil();
				window.location.href = "profile";
				alertify.success("Berhasil mengatur alamat");
			} else if (response.error) {
				alertify.error("Gagal mengatur alamat");
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}

function edit_address() {
	var formData = new FormData();
	formData.append("id_alamat", $("[name='id_alamat']").val());
	formData.append("alamat1", $("[name='alamat1']").val());
	formData.append("provinsi", $("#provinsi").val());
	formData.append("kota", $("#kota").val());

	$.ajax({
		type: "POST",
		url: base_url + "/" + _controller + "/edit_address",
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
				$("#modalAlamat").modal("hide");
				get_address();
				alertify.success("Berhasil mengubah alamat");
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}
