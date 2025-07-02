document.addEventListener("DOMContentLoaded", () => {
    window.addEventListener("swalSuccess", async (event) => {
        await Swal.fire({
            title: event.detail.title,
            text: event.detail.text,
            icon: event.detail.icon,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "OK",
            timer: event.detail.timer ?? null,
        });

        if (event.detail.redirect) {
            window.location.href = event.detail.redirect;
        }
    });

    window.addEventListener("swalError", async (event) => {
        await Swal.fire({
            title: event.detail.title,
            text: event.detail.text,
            icon: event.detail.icon,
            confirmButtonColor: "#d33",
            confirmButtonText: "OK",
        });

        if (event.detail.redirect) {
            window.location.href = event.detail.redirect;
        }
    });
});
