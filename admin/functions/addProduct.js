function addProductPopup(event, item_name, productPrice, productDescription, cuisineId) {
    event.preventDefault();

    Swal.fire({
        title: 'Add Product',
        icon: 'success',
        text: 'Cuisine Added successfully!',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
    }).then(() => {
        document.querySelector("form").submit();
    });
}
