get_profil();
get_umkm();

var destinationId, originId, wightProduct, courierName, totalPrice;
function get_profil() {
	$.ajax({
		url: base_url + _controller + "/get_profile",
		method: "GET",
		dataType: "json",
		success: function (data) {
			let fullName = data[0].name;
			let [fname, ...lname] = fullName.split(" ");
			lname = lname.join(" ");
			first_name = fname;
			last_name = lname;
			email = data[0].email;
			phone = data[0].phone_number;
			destinationId = data[0].city;
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(xhr.statusText);
		},
	});
}

function get_umkm() {
	$.ajax({
		url: base_url + _controller + "/get_umkm",
		method: "GET",
		dataType: "json",
		success: function (data) {
			// console.log(data);
			originId = data[0].city;
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(xhr.statusText);
		},
	});
}

$("#courierName").change(function () {
	courierName = $(this).val();
	wightProduct = 2000;
	// console.log(originId, destinationId, courierName, wightProduct);
	if (courierName !== "") {
		get_shipping(originId, destinationId, courierName, wightProduct);
	} else {
		$("#courierService").html('<option value="">Pilih Kurir!</option>');
	}
});

function get_shipping(originId, destinationId, courierName, wightProduct) {
	$.ajax({
		url: base_url + "RajaongkirController/cost",
		method: "POST",
		data: {
			origin: originId,
			destination: destinationId,
			courier: courierName,
			weight: wightProduct,
		},
		success: function (response) {
			var data = JSON.parse(response).rajaongkir.results; // Menyesuaikan dengan struktur JSON
			var options = '<option value="">Pilih Service</option>';
			$.each(data, function (index, service) {
				$.each(service.costs, function (costIndex, cost) {
					options +=
						'<option value="' +
						cost.cost[0].value +
						'">' +
						cost.service +
						" - " +
						cost.description +
						" (Rp " +
						cost.cost[0].value +
						" / " +
						cost.cost[0].etd +
						" hari)" +
						"</option>";
				});
			});
			$("#courierService").html(options);
		},
		error: function (xhr, textStatus, errorThrown) {
			console.log(errorThrown);
		},
	});
}

$("#courierService").on("change", function () {
	var selectedCost = parseInt($(this).val());
	var productPrice = parseInt($("#productPrice").text());
	totalPrice = selectedCost + productPrice;
	console.log(totalPrice);
	if (selectedCost) {
		$("#shippingPrice").text("Rp " + selectedCost);
		$("#totalPrice").text("Rp " + totalPrice);
	} else {
		$("#shippingPrice").text("");
	}
});

function createPayment(id) {
	var timestamp = new Date().getTime();
	var random_number = Math.floor(Math.random() * 1000);
	var order_id = "order-" + timestamp + "-" + random_number;

	var data = {
		order_id: order_id,
		gross_amount: totalPrice,
		first_name: first_name,
		last_name: last_name,
		email: email,
		phone: phone,
	};

	// console.log(data);

	$.ajax({
		url: base_url + "MidtransController/create_payment",
		method: "POST",
		data: {
			id_produk: id,
			order_id: order_id,
			gross_amount: totalPrice,
			first_name: first_name,
			last_name: last_name,
			email: email,
			phone: phone,
		},
		success: function (response) {
			var data = JSON.parse(response).redirect_url;
			console.log(data);
			// window.location.redirect =
			window.location.href = data;
		},
		error: function (xhr, status, error) {
			console.error("Error:", status, error);
		},
	});
}
