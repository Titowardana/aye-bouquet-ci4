<?php
/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>
<nav aria-label="Page navigation" class="flex items-center justify-center gap-1 flex-wrap">
    <?php if ($pager->hasPrevious()) : ?>
        <a href="<?= $pager->getFirst() ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-outline-variant/40 dark:border-white/20 text-on-surface-variant dark:text-gray-300 hover:bg-surface-container dark:hover:bg-white/10 hover:text-primary dark:hover:text-primary-fixed-dim transition-all text-xs font-medium" aria-label="First">
            <span class="material-symbols-outlined text-base">first_page</span>
        </a>
        <a href="<?= $pager->getPrevious() ?>" class="inline-flex items-center justify-center gap-1 px-2 h-8 rounded-lg border border-outline-variant/40 dark:border-white/20 text-on-surface-variant dark:text-gray-300 hover:bg-surface-container dark:hover:bg-white/10 hover:text-primary dark:hover:text-primary-fixed-dim transition-all text-xs font-medium" aria-label="Previous">
            <span class="material-symbols-outlined text-base">chevron_left</span>
            <span class="hidden sm:inline text-xs font-medium">Sebelumnya</span>
        </a>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
        <?php if ($link['active']) : ?>
            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary dark:bg-primary-fixed-dim text-on-primary dark:text-primary-fixed text-xs font-bold shadow-sm shadow-primary/20 dark:shadow-primary/10 cursor-default">
                <?= $link['title'] ?>
            </span>
        <?php else : ?>
            <a href="<?= $link['uri'] ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-outline-variant/40 dark:border-white/20 text-on-surface-variant dark:text-gray-300 hover:bg-surface-container dark:hover:bg-white/10 hover:text-primary dark:hover:text-primary-fixed-dim transition-all text-xs font-medium">
                <?= $link['title'] ?>
            </a>
        <?php endif ?>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
        <a href="<?= $pager->getNext() ?>" class="inline-flex items-center justify-center gap-1 px-2 h-8 rounded-lg border border-outline-variant/40 dark:border-white/20 text-on-surface-variant dark:text-gray-300 hover:bg-surface-container dark:hover:bg-white/10 hover:text-primary dark:hover:text-primary-fixed-dim transition-all text-xs font-medium" aria-label="Next">
            <span class="hidden sm:inline text-xs font-medium">Berikutnya</span>
            <span class="material-symbols-outlined text-base">chevron_right</span>
        </a>
        <a href="<?= $pager->getLast() ?>" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-outline-variant/40 dark:border-white/20 text-on-surface-variant dark:text-gray-300 hover:bg-surface-container dark:hover:bg-white/10 hover:text-primary dark:hover:text-primary-fixed-dim transition-all text-xs font-medium" aria-label="Last">
            <span class="material-symbols-outlined text-base">last_page</span>
        </a>
    <?php endif ?>
</nav>
