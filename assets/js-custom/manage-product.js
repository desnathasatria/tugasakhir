$(".kategori").select2({
	theme: "bootstrap4",
});

$(".filter").select2({
	theme: "bootstrap4",
});

$("#reservationdate1").datetimepicker({
	format: "YYYY-MM-DD",
});

var today = moment().startOf("day");
$("#reservationdate1").datetimepicker({
	minDate: today,
});

$("#reservationdate1").on("change.datetimepicker", function (e) {
	$("#reservationdate1").datetimepicker("minDate", today);
});

get_data();

$(function () {
	bsCustomFileInput.init();
});

$(".filter").on("change", function () {
	filterData();
});

function filterData() {
	$("#example").DataTable().search($(".filter").val()).draw();
}

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
	$("[name='id']").val("");
	$("[name='judul']").val("");
	$("[name='deskripsi']").val("");
	$("[name='harga']").val("");
	$("[name='berat']").val("");
	$("[name='kategori']").val("");
	$("[name='kadaluarsa']").val("");
	$("[name='image']").val("");
	imagePreview.innerHTML = "";
}

function delete_error() {
	$("#error-judul").hide();
	$("#error-kategori").hide();
	$("#error-deskripsi").hide();
	$("#error-harga").hide();
	$("#error-berat").hide();
	$("#error-image").hide();
	$("#error-kadaluarsa").hide();
}

$("#hapusGaleri").on("show.bs.modal", function (e) {
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
					{ data: "title" },
					{ data: "name" },
					{ data: "description" },
					{
						data: "price",
						render: function (data, type, row) {
							return formatRupiah(data);
						},
					},
					{
						data: "weight",
						render: function (data, type, row) {
							return data + " grams";
						},
					},
					{ data: "exp_date" },
					{
						data: "image",
						className: "text-center",
						render: function (data, type, row) {
							var imageUrl = base_url + "assets/image/product/" + data;
							return (
								'<img src="' +
								imageUrl +
								'" style="max-width: 100px; max-height: 400px;">'
							);
						},
					},
					{
						data: "total_stok",
						render: function (data, type, row) {
							return data ? data : 0;
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
								'<button class="btn btn-warning" data-toggle="modal" data-target="#hapusGaleri" title="hapus" data-id="' +
								row.id +
								'"><i class="fa-solid fa-trash-can"></i></button> ' +
								'<button class="btn btn-success" data-toggle="modal" data-target="#promoProduk" title="promo" onclick="delete_form_promo(' +
								row.id +
								'); delete_error_promo();" data-id="' +
								row.id +
								'"><i class="fa-solid fa-percent"></i></button>'
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

function formatRupiah(angka) {
	const numberString = angka.toString().replace(/[^,\d]/g, "");
	const split = numberString.split(",");
	const sisa = split[0].length % 3;
	let rupiah = split[0].substr(0, sisa);
	const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

	if (ribuan) {
		const separator = sisa ? "." : "";
		rupiah += separator + ribuan.join(".");
	}

	rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
	return "Rp. " + rupiah;
}

function formatRupiahInput(input) {
	var value = input.value.replace(/[^,\d]/g, "");
	input.value = formatRupiah(value);
}

function submit(x) {
	if (x == "tambah") {
		$("#btn-tambah").show();
		$("#btn-ubah").hide();
	} else {
		$("#btn-tambah").hide();
		$("#btn-ubah").show();

		$.ajax({
			type: "POST",
			data: "id=" + x,
			url: base_url + "/" + _controller + "/get_data_id",
			dataType: "json",
			success: function (hasil) {
				$("[name='id']").val(hasil[0].id);
				$("[name='judul']").val(hasil[0].title);
				$("[name='deskripsi']").val(hasil[0].description);
				$("[name='harga']").val(hasil[0].price);
				$("[name='berat']").val(hasil[0].weight);
				$("[name='kadaluarsa']").val(hasil[0].exp_date);
				$("#kategori").val(hasil[0].id_category_product).trigger("change");
				var nama = hasil[0].image;
				imagePreview.innerHTML = `<br><img src="${base_url}assets/image/product/${nama}" alt="Preview Image" class="img-thumbnail" style="width: 100px; height: auto;">`;
			},
		});
	}
	delete_form();
	delete_error();
}

function insert_data() {
	var formData = new FormData();
	formData.append("judul", $("[name='judul']").val());
	formData.append("deskripsi", $("[name='deskripsi']").val());
	formData.append("harga", $("[name='harga']").val());
	formData.append("berat", $("[name='berat']").val());
	formData.append("kategori", $("#kategori").val());
	formData.append("kadaluarsa", $("[name='kadaluarsa']").val());

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
	formData.append("judul", $("[name='judul']").val());
	formData.append("deskripsi", $("[name='deskripsi']").val());
	formData.append("harga", $("[name='harga']").val());
	formData.append("berat", $("[name='berat']").val());
	formData.append("kategori", $("#kategori").val());
	formData.append("kadaluarsa", $("[name='kadaluarsa']").val());

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
			$("body").append(response);
			get_data();
		},
	});
}

function delete_form_promo(x) {
	$("[name='id']").val(x);
	$("[name='stok']").val("");
	$("[name='harga_baru']").val("");
}

function delete_error_promo() {
	$("#error-stok").hide();
	$("#error-harga_baru").hide();
}

function insert_promo() {
	var formData = new FormData();
	formData.append("id", $("[name='id']").val());
	formData.append("stok", $("[name='stok']").val());

	$.ajax({
		type: "POST",
		url: base_url + "/" + _controller + "/insert_promo",
		data: formData,
		dataType: "json",
		processData: false,
		contentType: false,
		success: function (response) {
			delete_error_promo();
			if (response.errors) {
				for (var fieldName in response.errors) {
					$("#error-" + fieldName).show();
					$("#error-" + fieldName).html(response.errors[fieldName]);
				}
			} else if (response.success) {
				$("#promoProduk").modal("hide");
				$("body").append(response.success);
				get_data();
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}
