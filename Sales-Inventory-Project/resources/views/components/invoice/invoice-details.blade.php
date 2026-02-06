<!-- Modal -->
<div class="modal animated zoomIn" id="details-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Invoice</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="invoice" class="modal-body p-3">
                <div class="container-fluid">
                    <br />
                    <div class="row">
                        <div class="col-8">
                            <span class="text-bold text-dark">BILLED TO </span>
                            <p class="text-xs mx-0 my-1">Name: <span id="CName"></span> </p>
                            <p class="text-xs mx-0 my-1">Email: <span id="CEmail"></span></p>
                            <p class="text-xs mx-0 my-1">User ID: <span id="CId"></span> </p>
                        </div>
                        <div class="col-4">
                            <img class="w-40" src="{{ 'images/logo.png' }}">
                            <p class="text-bold mx-0 my-1 text-dark">Invoice </p>
                            <p class="text-xs mx-0 my-1">Date: {{ date('Y-m-d') }} </p>
                        </div>
                    </div>
                    <hr class="mx-0 my-2 p-0 bg-secondary" />
                    <div class="row">
                        <div class="col-12">
                            <table class="table w-100" id="invoiceTable">
                                <thead class="w-100">
                                    <tr class="text-xs text-bold">
                                        <td>Name</td>
                                        <td>Qty</td>
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                <tbody class="w-100" id="invoiceList">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr class="mx-0 my-2 p-0 bg-secondary" />
                    <div class="row">
                        <div class="col-12">
                            <p class="text-bold text-xs my-1 text-dark"> TOTAL: <i class="bi bi-currency-dollar"></i>
                                <span id="total"></span>
                            </p>
                            <p class="text-bold text-xs my-2 text-dark"> PAYABLE: <i class="bi bi-currency-dollar"></i>
                                <span id="payable"></span>
                            </p>
                            <p class="text-bold text-xs my-1 text-dark"> VAT(5%): <i class="bi bi-currency-dollar"></i>
                                <span id="vat"></span>
                            </p>
                            <p class="text-bold text-xs my-1 text-dark"> Discount: <i class="bi bi-currency-dollar"></i>
                                <span id="discount"></span>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-primary" data-bs-dismiss="modal">Close</button>
                <button onclick="PrintPage()" class="btn bg-gradient-success">Print</button>
            </div>
        </div>
    </div>
</div>

<script>
    function PrintPage() {
        let printContents = document.getElementById('invoice').innerHTML;
        let printWindow = window.open('', '', 'height=900,width=1000');

        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Invoice</title>
                <link rel="stylesheet" href="/css/bootstrap.css">
                <style>
                    * {
                        margin: 0;
                        padding: 0;
                        box-sizing: border-box;
                    }
                    body {
                        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                        margin: 0;
                        padding: 20px;
                        background: white;
                    }
                    .container-fluid { width: 100%; }
                    .row { display: flex; flex-wrap: wrap; margin: -12px; }
                    .col-8 { flex: 0 0 66.667%; padding: 12px; }
                    .col-4 { flex: 0 0 33.333%; padding: 12px; text-align: right; }
                    .col-12 { flex: 0 0 100%; padding: 12px; }
                    .text-xs { font-size: 0.75rem; }
                    .text-bold { font-weight: 600; }
                    .text-dark { color: #2d3748; }
                    .mx-0 { margin-left: 0 !important; margin-right: 0 !important; }
                    .my-1 { margin-top: 0.25rem !important; margin-bottom: 0.25rem !important; }
                    .my-2 { margin-top: 0.5rem !important; margin-bottom: 0.5rem !important; }
                    .p-0 { padding: 0 !important; }
                    .p-3 { padding: 1rem !important; }
                    .bg-secondary { background-color: #e9ecef; }
                    .w-100 { width: 100% !important; }
                    .w-40 { width: 40%; }
                    hr { border: none; border-top: 1px solid #6c757d; margin: 0.5rem 0; }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin: 10px 0;
                    }
                    table thead tr {
                        border-bottom: 2px solid #2d3748;
                    }
                    table th, table td {
                        padding: 10px;
                        text-align: left;
                        border-bottom: 1px solid #ddd;
                    }
                    table tbody tr:last-child td {
                        border-bottom: 2px solid #2d3748;
                    }
                    img { max-width: 100%; height: auto; }
                    i { margin-right: 5px; }
                    p { margin: 5px 0; }
                    h1 { font-size: 20px; }
                    @media print {
                        body { margin: 0; padding: 10px; }
                    }
                </style>
            </head>
            <body>
                ${printContents}
            </body>
            </html>
        `);

        printWindow.document.close();
        setTimeout(() => {
            printWindow.print();
        }, 250);
    }
</script>
