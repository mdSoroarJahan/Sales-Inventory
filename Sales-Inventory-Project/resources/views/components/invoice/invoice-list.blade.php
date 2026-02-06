<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h5>Invoices</h5>
                    </div>
                    <div class="align-items-center col">
                        <a href="{{ url('/salePage') }}" class="float-end btn m-0 bg-gradient-primary">Create Sale</a>
                    </div>
                </div>
                <hr class="bg-dark " />
                <table class="table" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Total</th>
                            <th>Vat</th>
                            <th>Discount</th>
                            <th>Payable</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableList">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    getList();

    async function getList() {
        try {
            showLoader();
            let res = await axios.get("/invoice-select");
            hideLoader();

            let tableList = $("#tableList");
            let tableData = $("#tableData");

            if ($.fn.DataTable.isDataTable('#tableData')) {
                tableData.DataTable().destroy();
            }
            tableList.empty();

            if (res.data['data'] && res.data['data'].length > 0) {
                res.data['data'].forEach(function(item, index) {
                    let row = `<tr>
                                <td>${index+1}</td>
                                <td>${item['customer']['name']}</td>
                                <td>${item['customer']['mobile']}</td>
                                <td>${item['total']}</td>
                                <td>${item['vat']}</td>
                                <td>${item['discount']}</td>
                                <td>${item['payable']}</td>
                                <td>
                                    <button data-id="${item['id']}" data-cid="${item['customer_id']}" class="btn viewBtn btn-sm btn-outline-success">View</button>
                                    <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                                </td>
                            </tr>`
                    tableList.append(row)
                })

                $('.viewBtn').on('click', function() {
                    let invoiceId = $(this).data('id');
                    let customerId = $(this).data('cid');
                    FillInvoiceDetails(invoiceId, customerId);
                    $("#details-modal").modal('show');
                })

                $('.deleteBtn').on('click', function() {
                    let id = $(this).data('id');
                    $("#delete-modal").modal('show');
                    $("#deleteID").val(id);
                })

                new DataTable('#tableData', {
                    order: [
                        [0, 'asc']
                    ],
                    lengthMenu: [5, 10, 15, 20, 30, 100]
                })
            }
        } catch (e) {
            hideLoader();
            console.error('Error loading invoices:', e);
            errorToast(e.response?.data?.message || "Error loading invoices");
        }
    }

    async function FillInvoiceDetails(invoiceId, customerId) {
        try {
            let res = await axios.post("/invoice-details", {
                inv_id: invoiceId,
                cus_id: customerId
            });
            let customer = res.data.data.customer;
            let invoice = res.data.data.invoice;
            let products = res.data.data.products;

            $("#CName").text(customer.name);
            $("#CEmail").text(customer.email);
            $("#CId").text(invoice.id);

            let invoiceList = $("#invoiceList");
            invoiceList.empty();

            products.forEach(function(item) {
                let row = `<tr class="text-xs">
                            <td>${item.product.name}</td>
                            <td>${item.qty}</td>
                            <td>${item.sale_price}</td>
                         </tr>`
                invoiceList.append(row)
            })

            $("#total").text(invoice.total);
            $("#payable").text(invoice.payable);
            $("#vat").text(invoice.vat);
            $("#discount").text(invoice.discount);
        } catch (e) {
            errorToast(e.response?.data?.message || "Error loading invoice details");
        }
    }

    async function itemDelete() {
        let id = $("#deleteID").val();

        showLoader();
        try {
            let res = await axios.post("/invoice-delete", {
                inv_id: id
            });
            hideLoader();
            if (res.data.status === 'success') {
                successToast("Invoice Deleted Successfully");
                getList();
                $("#delete-modal").modal('hide');
            } else {
                errorToast(res.data.message || "Something Went Wrong")
            }
        } catch (e) {
            hideLoader();
            errorToast(e.response?.data?.message || "Something Went Wrong")
        }
    }
</script>
