get_data();

function delete_form() {
	$("[name='id']").val("");
	$("[name='nama']").val("");
	$("[name='letter']").val("");
	$("[name='date1']").val("");
	$("[name='date2']").val("");
	$("[name='keterangan']").val("");
}

function get_data() {
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
							return (
								'<button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalDetail" title="detail" onclick="submit(' +
								row.id +
								')"><i class="fa-solid fa-eye"></i></button> '
							);
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
		},
	});
	delete_form();
}
