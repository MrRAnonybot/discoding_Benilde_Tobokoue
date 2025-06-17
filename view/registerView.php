<?php ob_start(); ?>
<div class="container-fluid d-flex h-100 characterBackground">
    <div class="row align-self-center w-100">
        <div class="col-4 mx-auto auth-container">
            <h3>Create an account</h3>
            <form action="/index.php?action=register" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label text-muted small text-uppercase">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required/>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label text-muted small text-uppercase">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required/>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-muted small text-uppercase">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required/>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label text-muted small text-uppercase">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required/>
                </div>

                <?php if (!empty($error_msg)): ?>
                    <div class="alert alert-danger"><?= $error_msg ?></div>
                <?php endif; ?>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary btn-lg btn-block w-100">Sign up</button>
                </div>

                <div class="text-center">
                    <p class="text-muted">Already have an account? <a href="/index.php?action=login">Log in</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require(__DIR__ . '/base.php'); ?>
