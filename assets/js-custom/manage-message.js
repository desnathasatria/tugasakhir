get_data();

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
					{ data: "message" },
					{ data: "date_send" },
					{
						data: "status",
						className: "text-center",
						render: function (data, type, row) {
							if (data == "1") {
								return '<button type="button" class="btn btn-block btn-danger">Belum dicek</button>';
							} else if (data == "2") {
								return '<button type="button" class="btn btn-block btn-warning">Sudah dibaca</button>';
							} else if (data == "3") {
								return '<button type="button" class="btn btn-block btn-success">Sudah dibalas</button>';
							}
						},
					},
					{
						data: "status",
						className: "text-center",
						render: function (data, type, row) {
							if (data == "1") {
								return (
									'<button class="btn btn-warning" data-toggle="modal" data-target="#cekPesan" title="tandai sudah dibaca" data-id="' +
									row.id +
									'"><i class="fa-solid fa-check-to-slot"></i></button>' +
									' <button class="btn btn-success" data-toggle="modal" data-target="#balasPesan" title="balas" onclick="submit(' +
									row.id +
									')"><i class="fa-solid fa-reply"></i></button>' +
									' <button class="btn btn-info" data-toggle="modal" data-target="#detailPesan" title="detail" onclick="submit(' +
									row.id +
									')"><i class="fa-solid fa-circle-info"></i></button>'
								);
							} else if (data == "2") {
								return (
									'<button class="btn btn-success" data-toggle="modal" data-target="#balasPesan" title="balas" onclick="submit(' +
									row.id +
									')"><i class="fa-solid fa-reply"></i></button>' +
									' <button class="btn btn-info" data-toggle="modal" data-target="#detailPesan" title="detail" onclick="submit(' +
									row.id +
									')"><i class="fa-solid fa-circle-info"></i></button>'
								);
							} else if (data == "3") {
								return (
									'<button class="btn btn-info" data-toggle="modal" data-target="#detailPesan1" title="detail" onclick="info(' +
									row.id +
									')"><i class="fa-solid fa-circle-info"></i></button>'
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

function cek_message(x) {
	$.ajax({
		type: "POST",
		data: "id=" + x,
		dataType: "json",
		url: base_url + _controller + "/cek_message",
		success: function (response) {
			if (response.success) {
				console.log(response.success);
				$("body").append(response.success);
				get_data();
			}
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
			$("[name='nama']").val(hasil[0].name);
			$("[name='email']").val(hasil[0].email);
			$("[name='date']").val(hasil[0].date_send);
			$("[name='message']").val(hasil[0].message);
		},
	});
	delete_form();
	delete_error();
}

function reply_message() {
	var formData = new FormData();
	formData.append("id", $("[name='id']").val());
	formData.append("reply", $("[name='reply']").val());

	$.ajax({
		type: "POST",
		url: base_url + _controller + "/reply_message",
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
				$("#balasPesan").modal("hide");
				$("body").append(response.success);
				get_data();
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}

function info(x) {
	$.ajax({
		type: "POST",
		data: "id=" + x,
		url: base_url + _controller + "/get_data_info",
		dataType: "json",
		success: function (hasil) {
			$("[name='id']").val(hasil[0].id);
			$("[name='nama']").val(hasil[0].name);
			$("[name='email']").val(hasil[0].email);
			$("[name='date']").val(hasil[0].date_send);
			$("[name='message']").val(hasil[0].message);
			$("[name='reply']").val(hasil[0].reply_message);
			$("[name='admin']").val(hasil[0].name);
			$("[name='date2']").val(hasil[0].date_reply);
		},
	});
	delete_form();
}
