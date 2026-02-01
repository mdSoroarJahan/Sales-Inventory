<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90 p-4">
                <div class="card-body">
                    <h4>SET NEW PASSWORD</h4>
                    <br />
                    <label>New Password</label>
                    <input id="password" placeholder="New Password" class="form-control" type="password" />
                    <br />
                    <label>Confirm Password</label>
                    <input id="cpassword" placeholder="Confirm Password" class="form-control" type="password" />
                    <br />
                    <button onclick="ResetPassword()" class="btn w-100 bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    async function ResetPassword() {
        let password = document.getElementById('password').value;
        let cpassword = document.getElementById('cpassword').value;

        if (password.length === 0) {
            errorToast('Password is required');
        } else if (password.length < 6) {
            errorToast('Password must be at least 6 characters');
        } else if (cpassword.length === 0) {
            errorToast('Confirm Password is required');
        } else if (password !== cpassword) {
            errorToast('Password and Confirm Password must be same');
        } else {
            showLoader();
            try {
                let res = await axios.post('/reset-password', {
                    password: password,
                    password_confirmation: cpassword
                });
                hideLoader();
                if (res.status === 200 && res.data.status === 'success') {
                    successToast(res.data.message || 'Password Reset Successful');
                    setTimeout(() => {
                        window.location.href = '/userLogin';
                    }, 1000);
                } else {
                    errorToast(res.data.message || 'Something went wrong');
                }
            } catch (err) {
                hideLoader();
                if (err.response && err.response.data && err.response.data.message) {
                    errorToast(err.response.data.message);
                } else {
                    errorToast('Something went wrong');
                }
            }
        }
    }
</script>
