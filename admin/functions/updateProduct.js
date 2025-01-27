function openPopup(event, id, name, product_image, price, description, cuisineId) {
    event.preventDefault();

    Swal.fire({
        title: 'Update Product',
        html: `
            <div style="display: flex;flex-direction:column;align-items:center;margin-bottom:10px; gap: 20px;">
            <img id="popupImagePreview" src="../${product_image}" alt="${product_image}" style="max-width: 50%; margin-bottom: 10px;" />
                <input type="file" id="product_image" name="product_image" accept="image/*" onchange="previewImagePopup(event)" required hidden>
                <button type="button" class="button" onclick="changeImagePopup(event)">Change</button>
            </div>
            <label for="productName" style="display: block; margin-bottom: 5px;">Product Name:</label>
            <input type="text" id="productName" value="${name}" class="swal2-input" style="margin-bottom: 15px;" />

            </div>
        <div>
            <label for="productPrice" style="display: block; margin-bottom: 5px;">Price:</label>
            <input type="text" id="productPrice" value="${price}" class="swal2-input" style="margin-bottom: 15px;" />
        </div>
        <div>
            <label for="productCuisine" style="display: block; margin-bottom: 5px;">Cuisine:</label>
            <select id="productCuisine" class="swal2-input" style="margin-bottom: 15px;">
                ${getCuisineOptions(cuisineId)}
            </select>
        </div>
        <div>
            <label for="productDescription" style="display: block; margin-bottom: 5px;">Description:</label>
            <textarea id="productDescription" class="swal2-textarea" style="margin-bottom: 15px;">${description}</textarea>
        </div>
    `,
        showCancelButton: true,
        confirmButtonText: 'Update',
        preConfirm: () => {
            const formData = new FormData();
            formData.append('update_product', true);
            formData.append('update_item_id', id);
            formData.append('item_name', document.getElementById('productName').value);
            formData.append('price', document.getElementById('productPrice').value);
            formData.append('cuisine_id', document.getElementById('productCuisine').value);
            formData.append('description', document.getElementById('productDescription').value);

            const productImage = document.getElementById('product_image').files[0];
            if (productImage) {
                formData.append('product_image', productImage);
            }

            return fetch('menuManagement.php', {
                    method: 'POST',
                    body: formData,
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .catch((error) => {
                    Swal.showValidationMessage(`Request failed: ${error}`);
                });
        },
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'success',
                title: 'Product Updated!',
                text: 'The product details were updated successfully.',
                showConfirmButton: false,
                timer: 2000,
            }).then(() => {
                event.preventDefault();
                window.location = 'menuManagement.php';
            });
        }
    });
}

function getCuisineOptions(selectedId) {
    const cuisines = window.cuisinesData || [];
    return cuisines
        .map(
            (cuisine) =>
            `<option value="${cuisine.id}" ${
                cuisine.id == selectedId ? 'selected' : ''
            }>${cuisine.name}</option>`
        )
        .join('');
}

function changeImagePopup(event) {
    document.getElementById('product_image').click();
}

function previewImagePopup(event) {
    const imagePreview = document.getElementById('popupImagePreview');

    if (event.target.files && event.target.files[0]) {
        const reader = new FileReader();

        reader.onload = () => {

            imagePreview.src = reader.result;
            imagePreview.style.display = 'block';
        };

        reader.readAsDataURL(event.target.files[0]);
    }
}
