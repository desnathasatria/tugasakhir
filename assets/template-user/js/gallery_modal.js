document.addEventListener("DOMContentLoaded", function () {
    const openModalButtons = document.querySelectorAll(".open-modal");
    const modalImage = document.querySelector(".modal-image");
    const modalTitle = document.querySelector("#imageModalLabel");

    openModalButtons.forEach(button => {
        button.addEventListener("click", () => {
            const imageSrc = button.getAttribute("data-image");
            const title = button.getAttribute("data-title");

            modalImage.src = imageSrc;
            modalTitle.textContent = title;
        });
    });
});
