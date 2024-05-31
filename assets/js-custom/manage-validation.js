get_data();
function previewImage(event) {
	const imageInput = event.target;
	const imagePreview = document.getElementById("imagePreviewArsip");

	if (imageInput.files && imageInput.files[0]) {
		const reader = new FileReader();

		reader.onload = function (e) {
			imagePreview.innerHTML = `<img src="${e.target.result}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
		};
		$("#error-image").html("");

		reader.readAsDataURL(imageInput.files[0]);
	} else {
		imagePreview.innerHTML = "";
	}
}
$(".status").select2({
	theme: "bootstrap4",
});

$(".status").on("change", function () {
	filterData();
});

function filterData() {
	$("#example").DataTable().search($(".status").val()).draw();
}

$("#cekPesan").on("show.bs.modal", function (e) {
	var button = $(e.relatedTarget);
	var id = button.data("id");
	var modalButton = $(this).find("#btn-success");
	modalButton.attr("onclick", "cek_message(" + id + ")");
});

function delete_form() {
	$("[name='id']").val("");
	$("[name='name']").val("");
	$("[name='message']").val("");
	$("[name='reply']").val("");
}

function delete_error() {
	$("#error-reply").hide();
}

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
					{ data: "name_letter" },
					{ data: "uploaded_date" },
					{
						data: "status",
						className: "text-center",
						render: function (data, type, row) {
							if (data == "1") {
								return '<button type="button" class="btn btn-block btn-danger">Belum dicek</button>';
							} else if (data == "2") {
								return '<button type="button" class="btn btn-block btn-warning">Belum terpenuhi</button>';
							} else if (data == "3") {
								return '<button type="button" class="btn btn-block btn-success">Terpenuhi</button>';
							} else if (data == "4") {
								return '<button type="button" class="btn btn-block btn-success">Sudah diambil</button>';
							}
						},
					},
					{
						data: "status",
						className: "text-center",
						render: function (data, type, row) {
							if (data == "1") {
								return (
									'<button class="btn btn-primary" data-toggle="modal" data-target="#cekAjuan" title="Lihat" onclick="submit(' +
									row.id +
									')"><i class="fa-solid fa-eye"></i></button>'
								);
							} 
							else if (data == "2") {
								return (
									'<button class="btn btn-primary" data-toggle="modal" data-target="#cekAjuan" title="Lihat" onclick="submit(' +
									row.id +
									')"><i class="fa-solid fa-eye"></i></button>'
								);
							} 
							else if (data == "3") {
								return (
									'<button class="btn btn-primary" data-toggle="modal" data-target="#cekAjuan" title="Lihat" onclick="submit(' +
									row.id +
									')"><i class="fa-solid fa-eye"></i></button>'
								);
							} 
							else if (data == "4") {
								return (
									'<button class="btn btn-info" data-toggle="modal" data-target="#cekDetail" title="detail" onclick="detail(' +
									row.id +
									')"><i class="fa-solid fa-circle-info"></i></button> ' +
									'<button class="btn btn-primary" data-toggle="modal" data-target="#cekSyarat" title="syarat" onclick="syarat(' +
									row.id +
									')"><i class="fa-solid fa-eye"></i></button> ' + 
									'<button class="btn btn-warning" data-toggle="modal" data-target="#tambahArsip" title="arsip" onclick="arsip(' +
									row.id +
									')"><i class="fa-solid fa-archive"></i></button> '
								);
							}
						},
					},
				],
				initComplete: function () {
					$("th").css("text-align", "center");
				},
			});
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(xhr.statusText);
		},
	});
}

function submit(x) {
	$.ajax({
		type: "POST",
		data: "id=" + x,
		url: base_url + "/" + _controller + "/get_data_id",
		dataType: "json",
		success: function (hasil) {
			$("[name='id']").val(hasil[0].id);
			$("[name='id_administration']").val(hasil[0].id_administration);
			$("[name='nama']").val(hasil[0].name);
			$("[name='letter']").val(hasil[0].name_letter);
			$("[name='keterangan']").val(hasil[0].keterangan);
			var namakk = hasil[0].kk;
				imagePreviewKk.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${namakk}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			var namaktp = hasil[0].ktp;
				imagePreviewKtp.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${namaktp}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			var namakia = hasil[0].kia;
				imagePreviewKia.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${namakia}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			var namaakta = hasil[0].akta;
				imagePreviewAkta.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${namaakta}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			var nama = hasil[0].pengantar_rt;
				imagePreviewPengantarRt.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${nama}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;

			var statusValue = hasil[0].status;
				if (statusValue === "1") {
					$("#blm").prop("checked", true);
					$("#belum").removeAttr("checked");
					$("#terpenuhi").removeAttr("checked");
					$("#sudah").removeAttr("checked");
				} else if (statusValue === "2"){
					$("#belum").prop("checked", true);
					$("#blm").removeAttr("checked");
					$("#terpenuhi").removeAttr("checked");
					$("#sudah").removeAttr("checked");
				} else if (statusValue === "3"){
					$("#terpenuhi").prop("checked", true);
					$("#blm").removeAttr("checked");
					$("#belum").removeAttr("checked");
					$("#sudah").removeAttr("checked");
				} else if (statusValue === "4"){
					$("#sudah").prop("checked", true);
					$("#blm").removeAttr("checked");
					$("#terpenuhi").removeAttr("checked");
					$("#belum").removeAttr("checked");
				}
				
			},
	});
	delete_form();
	delete_error();
}

function detail(x) {
	$.ajax({
		type: "POST",
		data: "id=" + x,
		url: base_url + "/" + _controller + "/get_data_id",
		dataType: "json",
		success: function (hasil) {
			$("[name='id']").val(hasil[0].id);
			$("[name='id_administration']").val(hasil[0].id_administration);
			$("[name='nama']").val(hasil[0].name);
			$("[name='letter']").val(hasil[0].name_letter);
			$("[name='keterangan']").val(hasil[0].keterangan);
			var namakk = hasil[0].kk;
				imagePreviewKk.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${namakk}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			var namaktp = hasil[0].ktp;
				imagePreviewKtp.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${namaktp}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			var namakia = hasil[0].kia;
				imagePreviewKia.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${namakia}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			var namaakta = hasil[0].akta;
				imagePreviewAkta.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${namaakta}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			var nama = hasil[0].pengantar_rt;
				imagePreviewPengantarRt.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${nama}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			
			var statusValue = hasil[0].status;
				if (statusValue === "1") {
					$("#blm1").prop("checked", true);
					$("#belum1").removeAttr("checked");
					$("#terpenuhi1").removeAttr("checked");
					$("#sudah1").removeAttr("checked");
				} else if (statusValue === "2"){
					$("#belum1").prop("checked", true);
					$("#blm1").removeAttr("checked");
					$("#terpenuhi1").removeAttr("checked");
					$("#sudah1").removeAttr("checked");
				} else if (statusValue === "3"){
					$("#terpenuhi1").prop("checked", true);
					$("#blm1").removeAttr("checked");
					$("#belum1").removeAttr("checked");
					$("#sudah1").removeAttr("checked");
				} else if (statusValue === "4"){
					$("#sudah1").prop("checked", true);
					$("#blm1").removeAttr("checked");
					$("#terpenuhi1").removeAttr("checked");
					$("#belum1").removeAttr("checked");
				}
			},
	});
	delete_form();
	delete_error();
}

function arsip(x) {
	$.ajax({
		type: "POST",
		data: "id=" + x,
		url: base_url + "/" + _controller + "/get_data_id",
		dataType: "json",
		success: function (hasil) {
			$("[name='id']").val(hasil[0].id);
			$("[name='id_administration']").val(hasil[0].id_administration);
			$("[name='nama']").val(hasil[0].name);
			$("[name='letter']").val(hasil[0].name_letter);
			var statusValue = hasil[0].status;
				if (statusValue === "1") {
					$("#blm1").prop("checked", true);
					$("#belum1").removeAttr("checked");
					$("#terpenuhi1").removeAttr("checked");
					$("#sudah1").removeAttr("checked");
				} else if (statusValue === "2"){
					$("#belum1").prop("checked", true);
					$("#blm1").removeAttr("checked");
					$("#terpenuhi1").removeAttr("checked");
					$("#sudah1").removeAttr("checked");
				} else if (statusValue === "3"){
					$("#terpenuhi1").prop("checked", true);
					$("#blm1").removeAttr("checked");
					$("#belum1").removeAttr("checked");
					$("#sudah1").removeAttr("checked");
				} else if (statusValue === "4"){
					$("#sudah1").prop("checked", true);
					$("#blm1").removeAttr("checked");
					$("#terpenuhi1").removeAttr("checked");
					$("#belum1").removeAttr("checked");
				}
			var nama = hasil[0].file_name;
				imagePreviewArsip.innerHTML = `<br><img src="${base_url}assets/image/administration/letter/${nama}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			
			},
	});
	delete_form();
	delete_error();
}

function syarat(x) {
	$.ajax({
		type: "POST",
		data: "id=" + x,
		url: base_url + "/" + _controller + "/get_data_id",
		dataType: "json",
		success: function (hasil) {
			$("[name='id']").val(hasil[0].id);
			$("[name='id_administration']").val(hasil[0].id_administration);
			$("[name='nama']").val(hasil[0].name);
			$("[name='letter']").val(hasil[0].name_letter);
			$("[name='keterangan']").val(hasil[0].keterangan);
			var namakk = hasil[0].kk;
				imagePreviewKk1.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${namakk}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			var namaktp = hasil[0].ktp;
				imagePreviewKtp1.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${namaktp}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			var namakia = hasil[0].kia;
				imagePreviewKia1.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${namakia}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			var namaakta = hasil[0].akta;
				imagePreviewAkta1.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${namaakta}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			var nama = hasil[0].pengantar_rt;
				imagePreviewPengantarRt1.innerHTML = `<br><img src="${base_url}assets/image/administration/requirement/${nama}" alt="Preview Image" class="img-thumbnail" style="width: 400px; height: 400;">`;
			},
	});
	delete_form();
	delete_error();
}


function update_data() {
	var formData = new FormData();
	formData.append("id", $("[name='id']").val());
	formData.append("keterangan", $("[name='keterangan']").val());
	formData.append("status", $("[name='status']").val());

	var selectedStatus = $("input[name='status']:checked").val();
    if (selectedStatus === undefined) {
        $("#error-status").text("Please select a status").show();
        return;
    } else {
        $("#error-status").hide();
        formData.append("status", selectedStatus);
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
				$("#cekAjuan").modal("hide");
				$("body").append(response.success);
				get_data();
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}
function update_status() {
	var formData = new FormData();
	formData.append("id", $("[name='id']").val());
	formData.append("status", $("[name='status']").val());

	var selectedStatus = $("input[name='status']:checked").val();
    if (selectedStatus === undefined) {
        $("#error-status").text("Please select a status").show();
        return;
    } else {
        $("#error-status").hide();
        formData.append("status", selectedStatus);
    }
	
	$.ajax({
		type: "POST",
		url: base_url + _controller + "/edit_status",
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
				$("#cekDetail").modal("hide");
				$("body").append(response.success);
				get_data();
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}

function tambah_arsip() {
	var formData = new FormData();
	formData.append("id", $("[name='id']").val());

	var imageInput = $("[name='arsip']")[0];
	if (imageInput.files.length > 0) {
		formData.append("arsip", imageInput.files[0]);
	}
	$.ajax({
		type: "POST",
		url: base_url + _controller + "/tambah_arsip",
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
				$("#tambahArsip").modal("hide");
				$("body").append(response.success);
				get_data();
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}

