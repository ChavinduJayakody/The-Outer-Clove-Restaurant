function showUpdatePopup(event, cuisineId, cuisineName) {

    Swal.fire({
        title: 'Update Cuisine',
        input: 'text',
        inputLabel: 'Cuisine Name',
        inputValue: cuisineName,
        showCancelButton: true,
        confirmButtonText: 'Update',
        cancelButtonText: 'Cancel',
        inputValidator: (value) => {
            if (!value) {
                return 'Cuisine name cannot be empty!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('update_cuisine_id').value = cuisineId;
            document.getElementById('update_cuisine_name').value = result.value;

            document.getElementById('update-form').submit();
            event.preventDefault();

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Cuisine updated successfully!',
                showConfirmButton: true
            });
        }
    });
}
