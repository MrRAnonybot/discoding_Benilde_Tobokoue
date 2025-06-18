
<div class="col-auto server-list d-flex flex-column align-items-center py-3" style="width: 72px; background-color: #2f3136; height: 100vh;">
    <!-- Button to return to friend/conversations -->
    <div class="server-icon mb-3">
        <a href="index.php?action=friend"
           class="btn btn-secondary rounded-circle d-flex align-items-center justify-content-center"
           style="width: 48px; height: 48px; padding: 0;">
            <img src="/static/img/discordLogo.png"
                 style="width: 24px; height: 24px; object-fit: contain;" alt="Friends" />
        </a>
    </div>



    <div class="server-icon mb-3">
        <a href="index.php?action=createServer"
           class="btn btn-dark rounded-circle d-flex align-items-center justify-content-center"
           style="width: 48px; height: 48px;">
            +
        </a>
    </div>


    <?php foreach ($servers as $server): ?>
        <div class="server-icon mb-3">
            <a href="index.php?action=server&id=<?= $server['id'] ?>">
                <img src="<?= htmlspecialchars($server['icon_url']) ?>"
                     alt="<?= htmlspecialchars($server['name']) ?>"
                     class="rounded-circle"
                     style="width: 48px; height: 48px;">
            </a>
        </div>
    <?php endforeach; ?>
</div>
