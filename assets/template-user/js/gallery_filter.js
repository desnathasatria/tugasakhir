$(document).ready(function () {
	function checkAndDisplayNoPhotoMessage() {
		const items = $(".item-content").parent();
		let hasVisibleItems = false;

		items.each(function () {
			const item = $(this);
			if (!item.hasClass("d-none")) {
				hasVisibleItems = true;
				return false;
			}
		});

		if (!hasVisibleItems) {
			$(".no-photo-message").removeClass("d-none");
		} else {
			$(".no-photo-message").addClass("d-none");
		}
	}

	checkAndDisplayNoPhotoMessage();

	$(".filter-button").on("click", (e) => {
		const filter = $(e.target).attr("data-filter");
		const items = $(".item-content").parent();
		let hasVisibleItems = false;

		items.each(function () {
			const item = $(this);

			if (filter == "" || $(item).attr("data-category") == filter) {
				$(item).addClass("animated zoomIn faster");
				$(item).parent().addClass("animated zoomIn faster");
				$(item).removeClass("d-none");
				$(item).parent().removeClass("d-none");
				hasVisibleItems = true;
			} else {
				$(item).addClass("d-none");
				$(item).parent().addClass("d-none");
				$(item).removeClass("animated zoomIn faster");
				$(item).parent().removeClass("animated zoomIn faster");
			}
		});

		if (!hasVisibleItems) {
			$(".no-photo-message").removeClass("d-none");
		} else {
			$(".no-photo-message").addClass("d-none");
		}
	});
});
