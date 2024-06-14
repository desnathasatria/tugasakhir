$(document).ready(function() {
    // Tambahkan event listener untuk tombol "Add to Cart"
    $('.btn-add-to-cart').click(function() {
        var productId = $(this).data('product-id');
        var productName = $(this).data('product-name');
        var productPrice = $(this).data('product-price');
        var productQuantity = $(this).closest('.input-group').find('input[name="jumlah"]').val();

        // Ambil data keranjang belanja dari session
        var shoppingCart = JSON.parse(sessionStorage.getItem('shoppingCart')) || [];

        // Cek apakah produk sudah ada dalam keranjang
        var existingProduct = shoppingCart.find(function(item) {
            return item.id === productId;
        });

        if (existingProduct) {
            // Jika produk sudah ada dalam keranjang, tambahkan kuantitasnya
            existingProduct.quantity = parseInt(existingProduct.quantity) + parseInt(productQuantity);
        } else {
            // Jika produk belum ada dalam keranjang, tambahkan produk baru
            shoppingCart.push({
                id: productId,
                name: productName,
                price: productPrice,
                quantity: productQuantity
            });
        }

        // Simpan data keranjang belanja ke dalam session
        sessionStorage.setItem('shoppingCart', JSON.stringify(shoppingCart));

        // Perbarui jumlah item dalam keranjang di header
        updateCartItemCount(shoppingCart.length);

        // Tampilkan modal keranjang belanja
        $('#shoppingCartModal').modal('show');
        updateShoppingCartTable(shoppingCart);
    });

    // Fungsi untuk memperbarui jumlah item dalam keranjang di header
    function updateCartItemCount(count) {
        $('#cartItemCount').text(count);
    }

    // Fungsi untuk memperbarui tabel keranjang belanja di modal
    function updateShoppingCartTable(shoppingCart) {
        var tableBody = $('#shoppingCartTableBody');
        tableBody.empty();

        shoppingCart.forEach(function(item) {
            var row = $('<tr>');
            row.append($('<td>').text(item.name));
            row.append($('<td>').text(item.price));
            row.append($('<td>').text(item.quantity));
            row.append($('<td>').text(item.price * item.quantity));
            row.append($('<td>').html('<button class="btn btn-danger btn-remove-item">Remove</button>'));
            tableBody.append(row);
        });
    }

    // Event listener untuk tombol "Remove" pada tabel keranjang belanja
    $(document).on('click', '.btn-remove-item', function() {
        var row = $(this).closest('tr');
        var productId = shoppingCart[row.index()].id;

        // Hapus produk dari keranjang belanja
        shoppingCart = shoppingCart.filter(function(item) {
            return item.id !== productId;
        });

        // Simpan data keranjang belanja yang diperbarui ke dalam session
        sessionStorage.setItem('shoppingCart', JSON.stringify(shoppingCart));

        // Perbarui jumlah item dalam keranjang di header
        updateCartItemCount(shoppingCart.length);

        // Perbarui tabel keranjang belanja di modal
        updateShoppingCartTable(shoppingCart);
    });
});