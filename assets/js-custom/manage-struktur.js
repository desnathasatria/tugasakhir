get_data();

$(function () {
	bsCustomFileInput.init();
});

$(".akses").select2({
	theme: "bootstrap4",
});
$(".jabatan").select2({
	theme: "bootstrap4",
});

$(".akses").on("change", function () {
	filterData();
});

function filterData() {
	$("#example").DataTable().search($(".akses").val()).draw();
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

$("#hapusStruktur").on("show.bs.modal", function (e) {
	var button = $(e.relatedTarget);
	var id = button.data("id");
	var modalButton = $(this).find("#btn-hapus");
	modalButton.attr("onclick", "delete_data(" + id + ")");
});

function delete_form() {
	const imagePreview = document.getElementById("imagePreview");
	$("[name='id']").val("");
	$("[name='name']").val("");
	$("#jabatan").val("").trigger("change");
	$("[name='NIP']").val("");
	$("[name='address']").val("");
	$("#file-label").hide();
	$("[name='image']").val("");
	imagePreview.innerHTML = "";
}

function delete_error() {
	$("#error-name").html("");
	$("#error-jabatan").html("");
	$("#error-NIP").html("");
	$("#error-image").html("");
	$("#error-address").html("");
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
					{ data: "name" },
					{ data: "name_jabatan" },
					{ data: "NIP" },
					{
						data: "image",
						className: "text-center",
						render: function (data, type, row) {
							var imageUrl = base_url + "assets/image/employee/" + data;
							return '<img src="' + imageUrl + '"">';
						},
					},
					{ data: "address" },
					{
						data: null,
						className: "text-center",
						render: function (data, type, row) {
							return (
								'<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" title="edit" onclick="submit(' +
								row.id +
								')"><i class="fa-solid fa-pen-to-square"></i></button> ' +
								'<button class="btn btn-warning" data-toggle="modal" data-target="#hapusStruktur" title="hapus" data-id="' +
								row.id +
								'"><i class="fa-solid fa-trash-can"></i></button>'
							);
						},
					},
				],
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
				$("[name='id']").val(hasil[0].id);
				$("[name='name']").val(hasil[0].name);
				$("[name='NIP']").val(hasil[0].NIP);
				$("[name='address']").val(hasil[0].address);
				$("#jabatan").val(hasil[0].id_jabatan).trigger("change");
				var nama = hasil[0].image;
				imagePreview.innerHTML = `<br><img src="${base_url}assets/image/employee/${nama}" alt="Preview Image" class="img-thumbnail" style="width: 100px; height: auto;">`;
			},
		});
	}
	delete_form();
	delete_error();
}

function insert_data() {
	var formData = new FormData();
	formData.append("name", $("[name='name']").val());
	formData.append("jabatan", $("#jabatan").val());
	formData.append("NIP", $("[name='NIP']").val());
	formData.append("address", $("[name='address']").val());

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
	formData.append("name", $("[name='name']").val());
	formData.append("NIP", $("[name='NIP']").val());
	formData.append("address", $("[name='address']").val());
	formData.append("jabatan", $("#jabatan").val());

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
		url: base_url + "/" + _controller + "/delete_data",
		success: function () {
			get_data();
		},
	});
}
