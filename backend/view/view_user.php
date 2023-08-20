<div class="container">
    <div class="row justify-content-center py-5">
        <div class="col-md-8 col-lg-8 col-xl-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="<?php echo BASE_URL?>/index.php/admin/changepassword">
                        <h1 class="h3 mb-3 fw-normal text-center">Change Password</h1>
                        <div class="form-floating mt-3">
                            <input type="email" name="username" readonly class="form-control" id="floatingInput"
                            value = "<?php echo $username ?>" />
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-floating mt-3">
                            <input type="password" name="passwd_lama" class="form-control" id="floatingPasswordLama" />
                            <label for="floatingPasswordLama">Old Password</label>
                        </div>
                        <div class="form-floating mt-3">
                            <input type="password" name="passwd_baru" class="form-control" id="floatingPasswordBaru" />
                            <label for="floatingPasswordBaru">New Password</label>
                        </div>
                        <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>