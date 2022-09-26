<?php foreach($items as $key => $value): ?>

    <?php if (is_array($value)): ?>

        <div class="folder">
            <div class="folder-toggle">
                <div class="folder-closed mr-10"><i class="fas fa-folder"></i></div>
                <div class="folder-open mr-10"><i class="fas fa-folder-open"></i></div>
                <div><?= $key ?></div>
            </div>
            <div class="folder-items">
                <?php $this->render('/wiki/navitems', ['items' => $value, 'dir' => $dir . $key . '/', 'current' => $current]) ?>
            </div>
        </div>

    <?php else: ?>

        <a href="<?= ABSURL ?>wiki/<?= $dir . $value ?>" class="file<?= $dir . $value == $current . '.md' ? ' current' : '' ?>">
            <div class="mr-10"><i class="fas fa-file"></i></div>
            <div><?= $value ?></div>
        </a>

    <?php endif; ?>

<?php endforeach ?>