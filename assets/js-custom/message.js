function delete_form() {
	$("[name='nama_pengirim']").val("");
	$("[name='email_pengirim']").val("");
	$("[name='subjek_pengirim']").val("");
	$("[name='pesan']").val("");
}

function delete_error() {
	$("#error-nama_pengirim").html("");
	$("#error-email_pengirim").html("");
	$("#error-subjek_pengirim").html("");
	$("#error-pesan").text("");
}
get_data();
var maxToShow = 5;

$(document).ready(function () {
	get_data();

	$("#btn_tampil_data").click(function () {
		if (maxToShow === 5) {
			maxToShow = 999;
			$(this).text("Tampilkan lebih sedikit");
		} else {
			maxToShow = 5;
			$(this).text("Tampilkan lebih banyak");
		}
		get_data();
	});
});

function get_data() {
	delete_form();
	$.ajax({
		url: base_url + _controller + "/get_data_message",
		method: "GET",
		dataType: "json",
		success: function (data) {
			$("#data_kritik_saran").empty();
			if (Object.keys(data).length === 0) {
				var html = "";
				$("#data_kritik_saran").html(html);
			} else {
				var count = 0;
				data.forEach(function (item) {
					var status_kritik = "";
					if (item.status == 3) {
						status_kritik = item.balasan;
					} else if (item.status == 2) {
						status_kritik = "<b>Status : Telah dibaca oleh admin</b>";
					} else if (item.status == 1) {
						status_kritik = "<b>Status : Belum dicek oleh admin</b>";
					}
					var tanggal_balasan = item.tgl_balasan
						? "Tanggal: " + item.tgl_balasan
						: "Tunggu dibalas oleh admin";

					var list = `<div class="col-lg-6 mb-4">
                                    <div class="p-4 bg-light rounded">
                                        <h5>${item.name}</h5>
                                        <p class="mb-1">${item.message}</p>
                                        <p class="text-muted">Tanggal: ${item.date_send}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="p-4 bg-light rounded">
                                        <h5>Balasan</h5>
                                        <p class="mb-1">${status_kritik}</p>
                                        <p class="text-muted">${tanggal_balasan}</p>
                                    </div>
                                </div>`;

					if (count < maxToShow) {
						$("#data_kritik_saran").append(list);
					}
					count++;
				});
			}
		},
	});
}

function insert_message() {
	var formData = new FormData();
	formData.append("nama_pengirim", $("[name='nama_pengirim']").val());
	formData.append("email_pengirim", $("[name='email_pengirim']").val());
	formData.append("subjek_pengirim", $("[name='subjek_pengirim']").val());
	formData.append("pesan", $("[name='pesan']").val());

	$.ajax({
		type: "POST",
		url: base_url + "/" + _controller + "/insert_message",
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
				delete_error();
				delete_form();
				alertify.success("Berhasil menambah kritik saran");
				get_data();
			} else if (response.error) {
				alertify.error(response.error);
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: " + error);
		},
	});
}
