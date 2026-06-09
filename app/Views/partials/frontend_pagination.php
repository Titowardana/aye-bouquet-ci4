<?php $pager->setSurroundCount(2) ?>

<nav class="flex justify-center items-center gap-2 mt-12" aria-label="<?= lang('Pager.pageNavigation') ?>">
    <?php if ($pager->hasPrevious()) : ?>
        <a href="<?= $pager->getPrevious() ?>" class="p-2 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-high transition-colors" aria-label="<?= lang('Pager.previous') ?>">
            <span class="material-symbols-outlined text-xl">chevron_left</span>
        </a>
    <?php else: ?>
        <button class="p-2 rounded-lg border border-outline-variant text-on-surface-variant opacity-40 cursor-not-allowed" disabled aria-label="<?= lang('Pager.previous') ?>">
            <span class="material-symbols-outlined text-xl">chevron_left</span>
        </button>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
        <a href="<?= $link['uri'] ?>" class="w-10 h-10 rounded-lg <?= $link['active'] ? 'bg-primary text-on-primary shadow-sm' : 'border border-outline-variant text-on-surface-variant hover:bg-surface-container hover:text-primary transition-colors' ?> font-label-md text-sm font-bold flex items-center justify-center" <?= $link['active'] ? 'aria-current="page"' : '' ?>>
            <?= $link['title'] ?>
        </a>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
        <a href="<?= $pager->getNext() ?>" class="p-2 rounded-lg border border-outline-variant text-on-surface-variant hover:bg-surface-container-high transition-colors" aria-label="<?= lang('Pager.next') ?>">
            <span class="material-symbols-outlined text-xl">chevron_right</span>
        </a>
    <?php else: ?>
        <button class="p-2 rounded-lg border border-outline-variant text-on-surface-variant opacity-40 cursor-not-allowed" disabled aria-label="<?= lang('Pager.next') ?>">
            <span class="material-symbols-outlined text-xl">chevron_right</span>
        </button>
    <?php endif ?>
</nav>
