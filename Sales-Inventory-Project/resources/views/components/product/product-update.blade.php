<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category *</label>
                                <select type="text" class="form-control form-select" id="productCategoryUpdate">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-3">Name *</label>
                                <input type="text" class="form-control" id="productNameUpdate">

                                <label class="form-label mt-3">Price *</label>
                                <input type="text" class="form-control" id="productPriceUpdate">

                                <label class="form-label mt-3">Unit *</label>
                                <input type="text" class="form-control" id="productUnitUpdate">

                                <br>
                                <img class="w-15" id="updateImg" src="{{ asset('images/default.jpg') }}"
                                    alt="">
                                <br>
                                <label class="form-label mt-2">Image</label>
                                <input oninput="updateImg.src=window.URL.createObjectURL(this.files[0])" type="file"
                                    class="form-control" id="productImgUpdate">

                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="filePath">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success">Update</button>
            </div>

        </div>
    </div>
</div>

<script>
    FillCategoryBDropDown();

    async function FillCategoryBDropDown() {
        let res = await axios.get("/category-list")
        res.data['data'].forEach(function(item, i) {
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $("#productCategoryUpdate").append(option);
        })
    }

    async function FillUpdateForm(id, filePath) {
        document.getElementById('updateID').value = id;
        document.getElementById('filePath').value = filePath;
        showLoader();
        try {
            let res = await axios.post("/product-by-id", {
                id: id
            })
            hideLoader();
            document.getElementById('productCategoryUpdate').value = res.data['data']['category_id'];
            document.getElementById('productNameUpdate').value = res.data['data']['name'];
            document.getElementById('productPriceUpdate').value = res.data['data']['price'];
            document.getElementById('productUnitUpdate').value = res.data['data']['unit'];
            document.getElementById('updateImg').src = "/storage/" + res.data['data']['img_url'];
        } catch (e) {
            hideLoader();
            errorToast("Failed to fetch product detail");
        }
    }

    async function Update() {
        let productCategory = document.getElementById('productCategoryUpdate').value;
        let productName = document.getElementById('productNameUpdate').value;
        let productPrice = document.getElementById('productPriceUpdate').value;
        let productUnit = document.getElementById('productUnitUpdate').value;
        let productImg = document.getElementById('productImgUpdate').files[0];
        let updateID = document.getElementById('updateID').value;

        if (productCategory.length === 0) {
            errorToast('Product Category Required!')
        } else if (productName.length === 0) {
            errorToast('Product Name Required!')
        } else if (productPrice.length === 0) {
            errorToast('Product Price Required!')
        } else if (productUnit.length === 0) {
            errorToast('Product Unit Required!')
        } else {
            document.getElementById('update-modal-close').click();

            let formData = new FormData();
            formData.append('id', updateID)
            formData.append('name', productName)
            formData.append('price', productPrice)
            formData.append('unit', productUnit)
            formData.append('category_id', productCategory)
            if (productImg) {
                formData.append('image', productImg)
            }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            try {
                let res = await axios.post("/product-update", formData, config);
                hideLoader();

                if (res.status === 200 && res.data['status'] === 'success') {
                    successToast('Product Updated Successfully!');
                    document.getElementById('update-form').reset();
                    document.getElementById('updateImg').src = "{{ asset('images/default.jpg') }}";
                    await getList();
                } else {
                    errorToast("Failed...!");
                }
            } catch (e) {
                hideLoader();
                errorToast("Something went wrong!");
            }
        }
    }
</script>
