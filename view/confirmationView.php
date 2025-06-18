<?php ob_start();?>

<div class="container-fluid d-flex h-100 characterBackground">
    <div class="row align-self-center w-100">
        <div class="col-6 mx-auto text-center">
            <h3><?= htmlspecialchars($confirmation_message ?? "Something went wrong.")  ?></h3>
            <a href="/index.php?action=login" class="btn btn-primary mt-3">Login</a>
        </div>
    </div>
</div>

<?php $content = ob_get_clean();?>
<?php require('base.php') ?>
