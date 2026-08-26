<h1 class="text-center font-bold text-2xl mb-8 text-ink">Recent Dispatches</h1>
<div class="flex flex-col gap-4">
    <?php foreach ( $pageData as $page ): ?>

        <a class="group flex gap-4 border-b border-vanilla-300 pb-4 transition-colors duration-300 ease-out hover:border-accent"
           href="index.php?<?= route_url( [ 'page' => $page->slug ] ) ?>">

            <?php if ( ! empty( $page->image_url ) ): ?>
                <img src="<?= e( image_get_size( $page->image_url, 'small' ) ) ?>"
                     alt="<?= e( $page->name ) ?>"
                     class="w-40 aspect-video shrink-0 object-cover">
            <?php endif; ?>

            <div class="flex flex-col gap-2">
                <h2 class="font-semibold transition-all duration-300 ease-out text-accent"><?= e( $page->name ) ?></h2>
                <span class="text-xs uppercase tracking-wider text-ink/50">
                    <?= e( format_date( $page->date_published, 2 ) ) ?>
                </span>
                <p class="text-sm text-ink/75 hidden sm:block"><?= e( mb_strimwidth( trim( $page->text ), 0, 100,
                            "..." ) ); ?></p>
                <span class="text-sm uppercase tracking-wider text-ink no-underline transition-all duration-300 ease-out group-hover:underline group-hover:text-accent hidden sm:block">Read More</span>
            </div>
        </a>

    <?php endforeach; ?>

    <?php if ( $pager->haveToPaginate() ):
        $current = $pager->getCurrentPage();
        $last = $pager->getNbPages();
        $window = 1;
        ?>
        <nav class="flex items-center justify-center gap-2 mt-8">

            <?php if ( $pager->hasPreviousPage() ): ?>
                <?php if ( $pager->getPreviousPage() === 1 ): ?>
                    <a href="/" class="px-3 py-1 border border-line">← Back</a>
                <?php else: ?>
                    <a href="?paginate=<?= $pager->getPreviousPage() ?>" class="px-3 py-1 border border-line">← Back</a>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ( $i = 1; $i <= $last; $i ++ ): ?>
                <?php if ( $i === 1 || $i === $last || abs( $i - $current ) <= $window ): ?>
                    <?php if ( $i === $current ): ?>
                        <span class="px-3 py-1 border bg-accent text-[var(--color-on-accent)] border-accent">
                        <?= $i ?>
                        </span>
                    <?php else : ?>
                        <a href="<?php echo ( $i === 1 ) ? "/" : "?paginate={$i}" ?>"
                           class= "px-3 py-1 border border-line">
                        <?= $i ?>
                        </a>
                    <?php endif; ?>
                <?php elseif ( $i === 2 || $i === $last - 1 ): ?>
                    <span class="px-2 text-ink/40">…</span>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ( $pager->hasNextPage() ): ?>
                <a href="?paginate=<?= $pager->getNextPage() ?>" class="px-3 py-1 border border-line">Next →</a>
            <?php endif; ?>

        </nav>
    <?php endif; ?>
</div>