$(document).ready(function () {
	// Fungsi untuk mengecek dan menampilkan pesan jika tidak ada foto
	function checkAndDisplayNoPhotoMessage() {
		const items = $(".item-content").parent();
		let hasVisibleItems = false;

		items.each(function () {
			const item = $(this);
			if (!item.hasClass("d-none")) {
				hasVisibleItems = true;
			}
		});

		if (!hasVisibleItems) {
			$(".no-photo-message").removeClass("d-none");
		} else {
			$(".no-photo-message").addClass("d-none");
		}
	}

	// Panggil fungsi untuk mengecek dan menampilkan pesan saat halaman dimuat
	checkAndDisplayNoPhotoMessage();

	$(".filter-button").on("click", (e) => {
		const filter = $(e.target).attr("data-filter");
		console.log(filter);
		const items = $(".item-content").parent();
		let hasVisibleItems = false;

		items.each(function () {
			const item = $(this);
			if (filter == "" || item.attr("data-category") == filter) {
				item.addClass("animated zoomIn faster");
				item.removeClass("d-none");
				hasVisibleItems = true;
			} else {
				item.addClass("d-none");
				item.removeClass("animated zoomIn faster");
			}
		});

		// Menampilkan teks "tidak ada foto" jika tidak ada item yang ditampilkan
		if (!hasVisibleItems) {
			$(".no-photo-message").removeClass("d-none");
		} else {
			$(".no-photo-message").addClass("d-none");
		}
	});
});
