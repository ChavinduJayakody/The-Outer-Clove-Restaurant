function showDeleteConfirmation(event, cuisineId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete ',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete_cuisine_id').value = cuisineId;

            document.getElementById('delete-form').submit();

            event.preventDefault();

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Cuisine deleted successfully!',
                showConfirmButton: true,
                timer: 5000,
            });
        }
    });
}
