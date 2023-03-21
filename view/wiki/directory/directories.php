<main class="container">
    <div class="directories">

        <?php if (isset($errorstring) && $errorstring != ''): ?>
            <div class="errorstring"><i class="fas fa-exclamation-triangle"></i> <?= $errorstring ?></div>
            <hr>
        <?php endif; ?>

        <div class="dir-name">Loaction: <?= $root ?></div>
        <hr>

        <?php if ($prev != ''): ?>
            <div class="prev-dir">
                <a href="<?= ABSURL ?>directories?dir=<?= $prev ?>"><i class="fas fa-arrow-circle-left"></i>&nbsp;&nbsp;&nbsp;Previous Directory</a>
            </div>
            <hr>
        <?php endif; ?>
        <?php $i = 0; ?>
        <?php foreach ($dirs as $dir => $value): ?>
            <?php $i++; ?>
            <?php if (is_array($value)): ?>
                <div class="dir">
                    <a href="<?= ABSURL ?>directories?dir=<?= $root ?><?= $dir ?>"><i class="fas fa-folder"></i>&nbsp;&nbsp;&nbsp;<?= $dir ?></a>
                    <a class="icon" href="<?= ABSURL ?>directories/edit?dir=<?= $root ?><?= $dir ?>"><i class="fas fa-pen"></i></a>
                    <a class="icon danger" style="cursor: pointer;" onclick="deleteDir('<?= $i ?>')"><i class="fas fa-trash"></i></a>
                    <form id="delete-dir-<?= $i ?>" method="post" action="<?= ABSURL ?>directories/delete" class="hidden"><input type="hidden" class="hidden" name="dir" value="<?= $root . $dir ?>/" /></form>
                </div>
            <?php else: ?>
                <div class="file">
                    <a href="<?= ABSURL ?>wiki<?= $root ?><?= $dir ?>"><i class="fas fa-file"></i>&nbsp;&nbsp;&nbsp;<?= $dir ?></a>
                    <a class="icon" href="<?= ABSURL ?>wiki<?= $root ?><?= $dir ?>/edit"><i class="fas fa-pen"></i></a>
                    <form id="delete-dir-<?= $i ?>" method="post" action="<?= ABSURL ?>directories/delete" class="hidden"><input type="hidden" class="hidden" name="dir" value="<?= $root . $dir ?>/" /></form>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if (empty($dirs)): ?>
            <div class="empty-dir">
                <center>Such Empty, Much Wow</center>
            </div>
        <?php endif; ?>
        <hr>
        <div class="create-dir">
            <a href="<?= ABSURL ?>directories/create?in=<?= $root ?>"><i class="fas fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;Create new Directory</a>
        </div>
        <div class="create-file">
            <a href="<?= ABSURL ?>create?in=<?= $root ?>"><i class="fas fa-file-signature"></i>&nbsp;&nbsp;&nbsp;Create new Wiki Entry</a>
        </div>
    </div>
</main>

<script>

async function deleteDir(id) {
    await confirmJs('do you really want to delete this directory?')
        .then(() => {
            setTimeout(async () => {
                await confirmJs('are you sure? (all content in this directory will be deleted as well)')
                    .then(() => {
                        document.getElementById(`delete-dir-${id}`).submit()
                    })
            }, 400)
        })
}

</script>