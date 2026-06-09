<?php
/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>
<nav aria-label="Page navigation" class="flex items-center gap-1">
    <?php if ($pager->hasPrevious()) : ?>
        <a href="<?= $pager->getFirst() ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-outline-variant/30 text-on-surface-variant hover:bg-surface-container hover:text-primary transition-all text-xs font-medium" aria-label="First">
            <span class="material-symbols-outlined text-base">first_page</span>
        </a>
        <a href="<?= $pager->getPrevious() ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-outline-variant/30 text-on-surface-variant hover:bg-surface-container hover:text-primary transition-all text-xs font-medium" aria-label="Previous">
            <span class="material-symbols-outlined text-base">chevron_left</span>
        </a>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
        <?php if ($link['active']) : ?>
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary text-on-primary text-xs font-bold shadow-sm shadow-primary/20 cursor-default">
                <?= $link['title'] ?>
            </span>
        <?php else : ?>
            <a href="<?= $link['uri'] ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-outline-variant/30 text-on-surface-variant hover:bg-surface-container hover:text-primary transition-all text-xs font-medium">
                <?= $link['title'] ?>
            </a>
        <?php endif ?>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
        <a href="<?= $pager->getNext() ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-outline-variant/30 text-on-surface-variant hover:bg-surface-container hover:text-primary transition-all text-xs font-medium" aria-label="Next">
            <span class="material-symbols-outlined text-base">chevron_right</span>
        </a>
        <a href="<?= $pager->getLast() ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-outline-variant/30 text-on-surface-variant hover:bg-surface-container hover:text-primary transition-all text-xs font-medium" aria-label="Last">
            <span class="material-symbols-outlined text-base">last_page</span>
        </a>
    <?php endif ?>
</nav>
