<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Discoding</title>

    <link rel="icon" href="/static/img/discord_logo.png" type="image/png">

    <link href="/static/lib/bootstrap-5.0.0/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/static/lib/bootstrap-icons-1.5.0/bootstrap-icons.css" rel="stylesheet"/>
    <link href="/static/css/style.css" rel="stylesheet"/>
</head>


<body>
<?php if (isset($_SESSION['user_id'])): ?>
    <div class="container-fluid py-2 text-end px-4">
        <a href="/index.php?action=logout" class="btn btn-danger">Déconnexion</a>
    </div>
<?php endif; ?>
<?= $content; ?>

<script src="/static/lib/bootstrap-5.0.0/js/bootstrap.min.js"></script>
<script src="/static/js/script.js"></script>
</body>

</html>
