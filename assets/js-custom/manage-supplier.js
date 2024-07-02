get_data();

$(function () {
	bsCustomFileInput.init();
});

$(".akses").select2({
	theme: "bootstrap4",
});
$(".supplier").select2({
	theme: "bootstrap4",
});

$(".akses").on("change", function () {
	filterData();
});

function filterData() {
	$("#example").DataTable().search($(".akses").val()).draw();
}

$("#hapusSupplier").on("show.bs.modal", function (e) {
	var button = $(e.relatedTarget);
	var id = button.data("id");
	var modalButton = $(this).find("#btn-hapus");
	modalButton.attr("onclick", "delete_data(" + id + ")");
});

function delete_form() {
	const imagePreview = document.getElementById("imagePreview");
	$("[name='id']").val("");
	$("#title").val("").trigger("change");
	$("[name='stok']").val("");
	$("[name='nama_supplier']").val("");
}

function delete_error() {
	$("#error-nama").html("");
	$("#error-stok").html("");
	$("#error-nama_supplier").html("");
}

function get_data() {
	$.ajax({
		url: base_url + "/" + _controller + "/get_data",
		method: "GET",
		dataType: "json",
		success: function (data) {
			var table = $("#example").DataTable({
				destroy: true,
				colReorder: true,
				scrollY: 400,
				data: data,
				columns: [
					{
						data: null,
						render: function (data, type, row, meta) {
							return meta.row + 1;
						},
					},
					{ data: "title" }, // Mengubah 'name' menjadi 'title'
					{ data: "nama_supplier" }, // Mengubah 'name' menjadi 'title'
					{ data: "stok" },
					{
						data: "created_date",
						render: function (data) {
							var date = new Date(data);
							var options = { year: "numeric", month: "long", day: "numeric" };
							return date.toLocaleDateString("id-ID", options);
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
								'<button class="btn btn-warning" data-toggle="modal" data-target="#hapusSupplier" title="hapus" data-id="' +
								row.id +
								'"><i class="fa-solid fa-trash-can"></i></button>'
							);
						},
					},
				],
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
				console.log(hasil);
				$("[name='id']").val(hasil[0].id);
				$("[name='nama_supplier']").val(hasil[0].nama_supplier);
				$("[name='stok']").val(hasil[0].stok);
				$("#name_produk").val(hasil[0].id_produk).trigger("change");
			},
		});
	}
	delete_form();
	delete_error();
}

function insert_data() {
	var formData = new FormData();
	formData.append("nama", $("#name_produk").val());
	formData.append("nama_supplier", $("[name='nama_supplier']").val());
	formData.append("stok", $("[name='stok']").val());

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
	formData.append("nama_supplier", $("[name='nama_supplier']").val());
	formData.append("stok", $("[name='stok']").val());
	formData.append("nama", $("#name_produk").val());

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
		dataType: "json",
		url: base_url + "/" + _controller + "/delete_data",
		success: function (response) {
			if (response.success) {
				$("body").append(response.success);
				get_data();
			}
		},
	});
}
