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
					{ data: "letter_name" },
					{ data: "submit_date" },
					{
						data: "status",
						className: "text-center",
						render: function (data, type, row) {
							if (data == "1") {
								return '<button type="button" class="btn btn-block btn-info">Belum dicek</button>';
							} else if (data == "2") {
								return '<button type="button" class="btn btn-block btn-danger">Tidak terpenuhi</button>';
							} else if (data == "3") {
								return '<button type="button" class="btn btn-block btn-primary">Terpenuhi</button>';
							} else if (data == "4") {
								return '<button type="button" class="btn btn-block btn-success">Dapat diambil</button>';
							}
						},
					},
					{
						data: null,
						className: "text-center",
						render: function (data, type, row) {
							return (
								'<button class="btn btn-dark" data-toggle="modal" data-target="#modalDetail" title="detail" onclick="submit(' +
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
			$("[name='nama']").val(hasil[0].name);
			$("[name='letter']").val(hasil[0].letter_name);
			$("[name='date1']").val(hasil[0].submit_date);
			$("[name='date2']").val(hasil[0].finish_date);
			$("[name='keterangan']").val(hasil[0].keterangan);
		},
	});
	delete_form();
}
