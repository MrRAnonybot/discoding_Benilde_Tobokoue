<?php ob_start() ?>
<form action="index.php?action=createServer" method="POST" class="container mt-5">
    <h2>Create a server</h2>
    <div class="mb-3">
        <label for="server_name" class="form-label">Server Name</label>
        <input type="text" name="server_name" id="server_name" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Create Server</button>
    <div class="server-icon mb-3">
        <a href="index.php?action=friend"
           class="btn btn-secondary d-flex align-items-center justify-content-center"
           style="width: 48px; height: 48px; padding: 0;"> cancel </a>
    </div>
</form>


<?php $content = ob_get_clean(); ?>
<?php require('base.php'); ?>
