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


function filterData() {
	$("#example").DataTable().search($(".filter").val()).draw();
}

function get_data() {
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
                                '<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" title="edit" onclick="submit(' +
                                row.id +
                                ')"><i class="fa-solid fa-pen-to-square"></i></button> ' +
                                '<button class="btn btn-warning" data-toggle="modal" data-target="#hapusPurchase" title="hapus" data-id="' +
                                row.id +
                                '"><i class="fa-solid fa-trash-can"></i></button>'
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
                $("[name='pelanggan']").val(hasil[0].name);
                $("[name='harga']").val(hasil[0].harga_transaksi);
                $("[name='tanggal']").val(hasil[0].created_date);
                $("[name='pembayaran']").val(hasil[0].status_pembayaran);
                var status_pengiriman_value = hasil[0].status_pengiriman;
                $("input[name='status'][value='" + status_pengiriman_value + "']").prop("checked", true);
            },
        });
    }
    delete_form();
    delete_error();
}

function update_status() {
    var formData = new FormData();
    formData.append("id", $("[name='id']").val());
    formData.append("status", $("input[name='status']:checked").val());

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
                    if (response.errors.hasOwnProperty(fieldName)) {
                        var errorMessage = response.errors[fieldName];
                        $("#error-" + fieldName).text(errorMessage);
                    }
                }
            } else {
                delete_form();
                delete_error();
                $("#exampleModal").modal("hide");
                get_data();
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            console.error("Error in AJAX request:", xhr.responseText);
        },
    });
}

function delete_form() {
    $("[name='id']").val("");
    $("[name='judul']").val("");
    $("[name='pelanggan']").val("");
    $("[name='harga']").val("");
    $("[name='tanggal']").val("");
    $("[name='pembayaran']").val("");
    $("[name='status']").prop("checked", false);
}

function delete_error() {
    $("#error-judul").text("");
    $("#error-pelanggan").text("");
    $("#error-harga").text("");
    $("#error-tanggal").text("");
    $("#error-pembayaran").text("");
    $("#error-status").text("");
}
