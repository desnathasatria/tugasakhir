get_data();

$("#reservationdate1").datetimepicker({
	format: "YYYY-MM-DD",
});
$("#reservationdate2").datetimepicker({
	format: "YYYY-MM-DD",
});

$("#reservationdate1").on("change.datetimepicker", function (e) {
	$("#reservationdate2").datetimepicker("minDate", e.date);
});

$("#reservationdate2").on("change.datetimepicker", function (e) {
	$("#reservationdate1").datetimepicker("maxDate", e.date);
});

$(".filter").select2({
	theme: "bootstrap4",
});

$(".filter").on("change", function () {
	filterData();
});

function get_data(startDate = null, endDate = null) {
	$.ajax({
		url: base_url + _controller + "/get_data",
		method: "GET",
		data: {
			start_date: startDate,
			end_date: endDate,
		},
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
					{ data: "title", className: "text-center" },
					{ data: "name", className: "text-center" },
					{ data: "harga_transaksi", className: "text-center" },
					{ data: "created_date", className: "text-center" },
					{ data: "status_pembayaran", className: "text-center" },
					{ data: "status_pengiriman", className: "text-center" },
					{
						data: null,
						className: "text-center",
						render: function (data, type, row) {
							return (
								'<button class="btn btn-info" data-toggle="modal" data-target="#detailHistory" title="detail" onclick="detail(' +
								row.id +
								')"><i class="fa-solid fa-circle-info"></i></button> '
							);
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

function get_data_filter() {
	let startDate = $("#date1").val();
	let endDate = $("#date2").val();
	get_data(startDate, endDate);
}

function export_pdf() {
	window.location.href = base_url + _controller + "/export_pdf";
}

function detail(x) {
	$.ajax({
		type: "POST",
		data: "id=" + x,
		url: base_url + "/" + _controller + "/get_data_id",
		dataType: "json",
		success: function (hasil) {
			$("[name='id']").val(hasil[0].id);
			$("[name='judul']").val(hasil[0].title);
			$("[name='pelanggan']").val(hasil[0].name);
			$("[name='harga']").val(hasil[0].harga_transaksi);
			$("[name='tanggal']").val(hasil[0].created_date);
			$("[name='pembayaran']").val(hasil[0].status_pembayaran);
			var status_pengiriman_value = hasil[0].status_pengiriman;
			$("input[name='status'][value='" + status_pengiriman_value + "']").prop(
				"checked",
				true
			);
		},
	});
}
