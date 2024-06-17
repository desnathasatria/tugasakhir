<!DOCTYPE html>
<html>
<head>
    <title>RajaOngkir Demo</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>RajaOngkir Demo</h1>
    <form id="shipping-form">
        <h2>Origin</h2>
        <label for="origin-province">Origin Province</label>
        <select id="origin-province" name="origin_province">
            <option value="">Select Province</option>
        </select>

        <label for="origin-city">Origin City</label>
        <select id="origin-city" name="origin">
            <option value="">Select City</option>
        </select>

        <h2>Destination</h2>
        <label for="destination-province">Destination Province</label>
        <select id="destination-province" name="destination_province">
            <option value="">Select Province</option>
        </select>

        <label for="destination-city">Destination City</label>
        <select id="destination-city" name="destination">
            <option value="">Select City</option>
        </select>

        <label for="weight">Weight (gram)</label>
        <input type="text" id="weight" name="weight" placeholder="Weight (gram)" required>

        <label for="courier">Courier</label>
        <select id="courier" name="courier" required>
            <option value="">Select Kurir</option>
            <option value="jne">JNE</option>
            <option value="pos">POS</option>
            <option value="tiki">Tiki</option>
        </select>
        <button type="submit">Check Cost</button>
    </form>

    <div id="cost-result"></div>

    <script>
        $(document).ready(function() {
            // Load provinces on page load
            $.getJSON('provinces', function(data) {
                $.each(data.rajaongkir.results, function(key, val) {
                    $('#origin-province, #destination-province').append('<option value="' + val.province_id + '">' + val.province + '</option>');
                });
            });

            // Load cities when an origin province is selected
            $('#origin-province').change(function() {
                var province_id = $(this).val();
                if (province_id) {
                    $.getJSON('cities/' + province_id, function(data) {
                        $('#origin-city').html('<option value="">Select City</option>');
                        $.each(data.rajaongkir.results, function(key, val) {
                            $('#origin-city').append('<option value="' + val.city_id + '">' + val.city_name + '</option>');
                        });
                    });
                } else {
                    $('#origin-city').html('<option value="">Select City</option>');
                }
            });

            // Load cities when a destination province is selected
            $('#destination-province').change(function() {
                var province_id = $(this).val();
                if (province_id) {
                    $.getJSON('cities/' + province_id, function(data) {
                        $('#destination-city').html('<option value="">Select City</option>');
                        $.each(data.rajaongkir.results, function(key, val) {
                            $('#destination-city').append('<option value="' + val.city_id + '">' + val.city_name + '</option>');
                        });
                    });
                } else {
                    $('#destination-city').html('<option value="">Select City</option>');
                }
            });

            // Handle form submission
            $('#shipping-form').submit(function(e) {
                e.preventDefault();
                $.post('cost', $(this).serialize(), function(data) {
                    $('#cost-result').html(JSON.stringify(data));
                });
            });
        });
    </script>
</body>
</html>
