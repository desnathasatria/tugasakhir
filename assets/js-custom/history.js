if (currentUrl.includes(base_url + "history")) {
	get_data_history();
	delete_error_input();
}

function delete_form() {
	$("[name='id']").val("");
	$("[name='nama']").val("");
	$("[name='letter']").val("");
	$("[name='date1']").val("");
	$("[name='date2']").val("");
	$("[name='keterangan']").val("");
}

$("#modalKonfirmasi").on("show.bs.modal", function (e) {
	var button = $(e.relatedTarget);
	var id = button.data("id");
	var modalButton = $(this).find("#btn-konfirmasi");
	modalButton.attr("onclick", "konfirmasi(" + id + ")");
});

function get_data_history() {
	$.ajax({
		url: base_url + _controller + "/get_data_history",
		method: "GET",
		dataType: "json",
		success: function (data) {
			console.log(data);
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
					{ data: "title" },
					{ data: "created_date" },
					{ data: "status_pengiriman" },
					{
						data: null,
						className: "text-center",
						render: function (data, type, row) {
							if (row.status_pengiriman == "Selesai") {
								if (row.keterangan == null) {
									return (
										'<button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalDetail" title="detail" onclick="submit(\'' +
										row.id +
										'\')"><i class="fa-solid fa-eye"></i></button> ' +
										'<button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalRating" title="rating" onclick="cek_data(\'' +
										row.id +
										'\')"><i class="fa-solid fa-star"></i></button> '
									);
								} else {
									return (
										'<button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalDetail" title="detail" onclick="submit(\'' +
										row.id +
										'\')"><i class="fa-solid fa-eye"></i></button> '
									);
								}
							} else if (row.status_pengiriman == "Dikirim") {
								return (
									'<button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalDetail" title="detail" onclick="submit(\'' +
									row.id +
									'\')"><i class="fa-solid fa-eye"></i></button> ' +
									'<button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalKonfirmasi" title="konfirmasi" data-id="\'' +
									row.id +
									'\'"><i class="fa-solid fa-check-to-slot"></i></button>'
								);
							} else {
								return (
									'<button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalDetail" title="detail" onclick="submit(\'' +
									row.id +
									'\')"><i class="fa-solid fa-eye"></i></button> '
								);
							}
						},
					},
				],
				initComplete: function () {
					// Set column titles alignment to center
					$("th").css("text-align", "center");
				},
			});
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(xhr.statusText);
		},
	});
}

function cek_data(x) {
	$("[name='id']").val(x);
	$("[name='rating']").val("");
	const stars = document.querySelectorAll(".rating-star");
	stars.forEach((star) => {
		star.classList.remove("active");
	});
}

function delete_error_input() {
	$("#error-rating").hide();
	$("#error-keterangan").hide();
}

function kirim_rating() {
	var formData = new FormData();
	formData.append("id", $("[name='id']").val());
	formData.append("rating", $("[name='rating']").val());
	formData.append("keterangan", $("[name='keterangan']").val());

	$.ajax({
		type: "POST",
		url: base_url + "/" + _controller + "/insert_rating",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			delete_error_input();
			if (response.errors) {
				for (var fieldName in response.errors) {
					$("#error-" + fieldName).show();
					$("#error-" + fieldName).html(response.errors[fieldName]);
				}
			} else if (response.success) {
				$("#modalRating").modal("hide");
				alertify.success("Berhasil menambah rating");
				get_data_history();
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}

function submit(x) {
	$.ajax({
		type: "POST",
		data: "id=" + x,
		url: base_url + _controller + "/get_data_id",
		dataType: "json",
		success: function (hasil) {
			$("[name='id']").val(hasil[0].id);
			$("[name='title']").val(hasil[0].title);
			$("[name='tanggal']").val(hasil[0].created_date);
			$("[name='status']").val(hasil[0].status_pengiriman);
			$("[name='keterangan1']").val(hasil[0].keterangan);
			const stars = document.querySelectorAll(".rating-star1");
			stars.forEach((star) => {
				star.classList.remove("active");
			});

			for (let i = 0; i < hasil[0].rating; i++) {
				stars[i].classList.add("active");
			}
		},
	});
	delete_form();
}

function konfirmasi(x) {
	var formData = new FormData();
	formData.append("id", x);

	$.ajax({
		type: "POST",
		url: base_url + _controller + "/konfirmasi_pemesanan",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			if (response.error) {
				alertify.error("ERROR");
			} else if (response.success) {
				alertify.success("Berhasil konfirmasi pemesanan");
				get_data_history();
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}
