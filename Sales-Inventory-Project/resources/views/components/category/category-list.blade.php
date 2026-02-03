<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Category</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" data-bs-target="#create-modal"
                            class="float-end btn m-0 bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">
                    <table class="table" id="tableData">
                        <thead>
                            <tr class="bg-light">
                                <th>No</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">
                            <tr>
                                <td>1</td>
                                <td>Category</td>
                                <td>
                                    <button data-bs-toggle="modal" data-bs-target="#update-modal">Edit</button>
                                    <button data-bs-toggle="modal" data-bs-target="#delete-modal">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    async function getList() {
        showLoader();
        let res = await axios.get('/list-category');
        hideLoader();

        let tableList = $("#tableList");
        let tableData = $("#tableData");

        res.data.forEach(function(item, index) {
            let row = < tr >
                <
                td > $ {} < /td> <
                td > < /td> <
                td > < /td> <
                /tr>
        })
    }
</script>
