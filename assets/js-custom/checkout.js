if (currentUrl.includes(base_url + "Front_page/product_detail")) {
	get_data_rating();
}

function get_data_rating() {
	$.ajax({
		url: base_url + _controller + "/get_data_rating/" + id_produk_detail,
		method: "GET",
		dataType: "json",
		success: function (data) {
			$("#data_penilaian").empty();
			if (Object.keys(data).length === 0) {
				var html = `<div class="col-lg-3"><b>Belum ada penilaian</b></div>`;
				$("#data_penilaian").html(html);
			} else {
				data.forEach(function (item) {
					var list = `<style>
								.rating-star${item.id} {
									font-size: 24px;
									color: #ccc;
								}

								.rating-star${item.id}.active {
									color: #ffc107;
								}
							</style>
							<div class="col-lg-3">
								<div style="font-family: Arial, sans-serif; max-width: 400px; border: 1px solid #e0e0e0; border-radius: 8px; padding: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
									<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 5px;">
										<div style="display: flex; align-items: center;">
											<span style="font-weight: bold;">${item.name}</span>
										</div>
									</div>
									<div class="input-group">
										<span class="rating-star${item.id}" data-rating="1"><i class="bi bi-star"></i></span>
										<span class="rating-star${item.id}" data-rating="2"><i class="bi bi-star"></i></span>
										<span class="rating-star${item.id}" data-rating="3"><i class="bi bi-star"></i></span>
										<span class="rating-star${item.id}" data-rating="4"><i class="bi bi-star"></i></span>
										<span class="rating-star${item.id}" data-rating="5"><i class="bi bi-star"></i></span>
									</div>
									<div style="margin-bottom: 5px;">
										<p style="margin: 5px 0;">Keterangan : ${item.keterangan}</p>
									</div>
								</div>
							</div>`;

					$("#data_penilaian").append(list); // Append list here

					const stars = $("#data_penilaian").find(".rating-star" + item.id); // Select stars inside appended list
					stars.each(function (index, star) {
						$(star).removeClass("active");
					});

					for (let i = 0; i < item.rating; i++) {
						$(stars[i]).addClass("active");
					}
				});
			}
		},
	});
}

if (currentUrl.includes(base_url + "Front_page/checkout")) {
	get_data_address();
	get_profil();
	get_umkm();
}

function get_data_address() {
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
							var list = `<div class="col-lg-4">
                                        <div class="card mb-2">
                                            <div class="card-body">
                                                <h5 class="card-title">Alamat ${no} ${status_alamat}</h5>
                                                <h6 class="card-subtitle mb-2 text-body-secondary">${item.address}</h6>
                                                <p class="card-text">${city_name}, ${province_name}</p>
                                                <a href="#" class="card-link" onclick="Pilih_alamat(${item.id})">Pilih menjadi alamat utama</a>
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

function Pilih_alamat(x) {
	$.ajax({
		type: "POST",
		data: "id=" + x,
		dataType: "json",
		url: base_url + _controller + "/edit_status_address",
		success: function (response) {
			if (response.success) {
				get_data_address();
				get_profil();
				get_umkm();
				$("#courierName").val("").trigger("change");
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

var destinationId, originId, wightProduct, courierName, totalPrice;
function get_profil() {
	$.ajax({
		url: base_url + _controller + "/get_profile",
		method: "GET",
		dataType: "json",
		success: function (data) {
			let fullName = data[0].name;
			let [fname, ...lname] = fullName.split(" ");
			lname = lname.join(" ");
			first_name = fname;
			last_name = lname;
			email = data[0].email;
			phone = data[0].phone_number;
			destinationId = data[0].city;
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(xhr.statusText);
		},
	});
}

function get_umkm() {
	$.ajax({
		url: base_url + _controller + "/get_umkm",
		method: "GET",
		dataType: "json",
		success: function (data) {
			// console.log(data);
			originId = data[0].city;
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(xhr.statusText);
		},
	});
}

function masukan_keranjang(id) {
	var formData = new FormData();
	formData.append("id_produk", id);
	formData.append("jumlah", $("[name='jumlah']").val());

	$.ajax({
		type: "POST",
		url: base_url + "/" + _controller + "/keranjang",
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
				$("[name='jumlah']").val(1);
				get_keranjang();
				alertify.success("Berhasil menambah produk ke keranjang");
			} else if (response.error) {
				alertify.error(response.error);
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}

$("#courierName").change(function () {
	courierName = $(this).val();
	wightProduct = 2000;
	// console.log(originId, destinationId, courierName, wightProduct);
	if (courierName !== "") {
		get_shipping(originId, destinationId, courierName, wightProduct);
	} else {
		$("#courierService").html('<option value="">Pilih Kurir!</option>');
	}
});

function get_shipping(originId, destinationId, courierName, wightProduct) {
	$.ajax({
		url: base_url + "RajaongkirController/cost",
		method: "POST",
		data: {
			origin: originId,
			destination: destinationId,
			courier: courierName,
			weight: wightProduct,
		},
		success: function (response) {
			var data = JSON.parse(response).rajaongkir.results; // Menyesuaikan dengan struktur JSON
			var options = '<option value="">Pilih Service</option>';
			$.each(data, function (index, service) {
				$.each(service.costs, function (costIndex, cost) {
					options +=
						'<option value="' +
						cost.cost[0].value +
						'">' +
						cost.service +
						" - " +
						cost.description +
						" (Rp " +
						cost.cost[0].value +
						" / " +
						cost.cost[0].etd +
						" hari)" +
						"</option>";
				});
			});
			$("#courierService").html(options);
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(errorThrown);
		},
	});
}

$("#courierService").on("change", function () {
	var selectedCost = parseInt($(this).val());
	var productPrice = parseInt($("#productPrice").text());
	totalPrice = selectedCost + productPrice;
	console.log(totalPrice);
	if (selectedCost) {
		$("#shippingPrice").text("Rp " + selectedCost);
		$("#totalPrice").text("Rp " + totalPrice);
	} else {
		$("#shippingPrice").text("");
	}
});

function createPayment(id, total, jumlah) {
	alertify.confirm(
		"Apakah anda yakin melanjutkan proses pembayaran?",
		function () {
			var timestamp = new Date().getTime();
			var random_number = Math.floor(Math.random() * 1000);
			var order_id = "order-" + timestamp + "-" + random_number;

			var data = {
				order_id: order_id,
				gross_amount: totalPrice,
				first_name: first_name,
				last_name: last_name,
				email: email,
				phone: phone,
				jumlah: total,
				jumlah_produk: jumlah,
			};

			// console.log(data);

			$.ajax({
				url: base_url + "MidtransController/create_payment",
				method: "POST",
				data: {
					id_produk: id,
					order_id: order_id,
					gross_amount: totalPrice,
					first_name: first_name,
					last_name: last_name,
					email: email,
					phone: phone,
					jumlah: total,
					jumlah_produk: jumlah,
				},
				success: function (response) {
					var data = JSON.parse(response).redirect_url;
					console.log(data);
					// window.location.redirect =
					window.location.href = data;
				},
				error: function (xhr, status, error) {
					console.error("Error:", status, error);
				},
			});
		}
	);
}
