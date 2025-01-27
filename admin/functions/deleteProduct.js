function deleteProduct(event, productId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'post';
            form.action = 'menuManagement.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_product';
            input.value = productId;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
            event.preventDefault();
            Swal.fire({
                title: 'Deleted!',
                text: "The product has been deleted.",
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
        });
        }
    });
}
