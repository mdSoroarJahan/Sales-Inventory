@extends('layouts.sidenav-layout')
@section('content')
    <div class=" container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4>Sales Report</h4>
                        <label class="form-label mt-2">Date From</label>
                        <input type="date" id="fromDate" class="form-control">
                        <label class="form-label mt-2">Date To</label>
                        <input type="date" id="toDate" class="form-control">
                        <button onclick="SalesReport()" class="btn mt-3 bg-gradient-primary">Download</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    /**
     * Generate and download sales report for the specified date range
     */
    async function SalesReport() {
        let fromDate = document.getElementById('fromDate').value;
        let toDate = document.getElementById('toDate').value;

        if (fromDate.length === 0) {
            errorToast("Date From is required!");
        } else if (toDate.length === 0) {
            errorToast("Date To is required!");
        } else if (fromDate > toDate) {
            errorToast("Date From cannot be greater than Date To!");
        } else {
            showLoader();
            try {
                // Create a temporary form to submit the request
                const form = document.createElement('form');
                form.method = 'GET';
                form.action = '/sales-report/' + fromDate + '/' + toDate;
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);

                hideLoader();
                successToast('Report downloaded successfully!');
            } catch (err) {
                hideLoader();
                errorToast("Something went wrong");
                console.error(err);
            }
        }
    }
</script>
