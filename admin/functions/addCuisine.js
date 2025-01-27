function addCuisinePopup(event, cuisineName) {
    event.preventDefault();

    if (!cuisineName.trim()) {
        Swal.fire({
            title: 'Error',
            icon: 'error',
            text: 'Cuisine name cannot be empty!',
            showConfirmButton: false
        });
        return;
    }

    Swal.fire({
        title: 'Add Cuisine',
        icon: 'success',
        text: 'Cuisine Added successfully!',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    }).then(() => {
        document.querySelector("form").submit();
    });
}
