<?php ob_start() ?>
<form action="index.php?action=createServer" method="POST" class="container mt-5">
    <h2>Create a server</h2>
    <div class="mb-3">
        <label for="server_name" class="form-label">Server Name</label>
        <input type="text" name="server_name" id="server_name" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Create Server</button>
</form>

<?php $content = ob_get_clean(); ?>
<?php require(__DIR__ . '/base.php'); ?>
