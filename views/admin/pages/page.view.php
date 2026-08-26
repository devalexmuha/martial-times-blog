<?php /** @var \App\Model\PageModel[] $pageData */ ?>

    <div class="flex flex-col gap-4 sm:gap-0 sm:flex-row items-center justify-between mb-8">
        <h2 class="font-display font-bold text-accent" style="font-size: var(--fluid-lg);">List of pages</h2>
        <a href="index.php?route=admin/pages/add"
           class="border border-accent text-accent px-4 py-2 text-sm uppercase tracking-wider transition-colors duration-300 ease-out hover:bg-accent hover:text-[var(--color-on-accent)]">
            + Add page
        </a>
    </div>

    <div class="w-full overflow-x-auto">
        <table class="w-full min-w-[320px] border-collapse text-left">
            <thead>
            <tr class="border-b border-line">
                <th class="py-2 pr-4 text-sm uppercase tracking-wider text-ink/60 w-16"></th>
                <th class="py-2 pr-4 text-sm uppercase tracking-wider text-ink/60">Name</th>
                <th class="py-2 pr-4 text-sm uppercase tracking-wider text-ink/60">Date Updated</th>
                <?php if ( $_SESSION['user_type'] === 'super_admin' ): ?>
                    <th class="py-2 pr-4 text-sm uppercase tracking-wider text-ink/60">Author</th>
                <?php endif; ?>
                <th class="py-2 text-sm uppercase tracking-wider text-ink/60">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ( $pageData as $dataItem ): ?>
                <tr class="border-b border-line align-top">
                    <td class="py-3 pr-4">
                        <?php if ( ! empty( $dataItem->image_url ) ): ?>
                            <img src="<?= e( image_get_size( $dataItem->image_url, 'small' ) ) ?>"
                                 alt="<?= e( $dataItem->name ) ?>"
                                 class="h-10 w-10 min-w-10 object-cover">
                        <?php else: ?>
                            <div class="flex h-10 w-10 min-w-10 items-center justify-center bg-line/40 text-[10px] uppercase tracking-wider text-ink/40">
                                —
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="py-3 pr-4 font-semibold"><?= e( mb_strimwidth( trim( $dataItem->name ), 0, 100,
                                '…' ) ); ?></td>
                    <td class="py-3 pr-4 text-sm text-ink/70"><?= e( format_date( $dataItem->date_updated, 2 ) ) ?></td>
                    <?php if ( $_SESSION['user_type'] === 'super_admin' ): ?>
                        <td class="py-3 pr-4 text-sm text-ink/70"><?= e( $dataItem->author ); ?></td>
                    <?php endif; ?>
                    <td class="py-3">
                        <div class="flex gap-3">
                            <a href="index.php?<?= route_url( [
                                    'route' => 'admin/pages/edit',
                                    'id'    => $dataItem->id
                            ] ) ?>"
                               class="border border-accent text-accent px-3 py-1 text-xs uppercase tracking-wider transition-colors duration-300 ease-out hover:bg-accent hover:text-[var(--color-on-accent)]">
                                Update
                            </a>
                            <form action="index.php?<?= route_url( [
                                    'route' => 'admin/pages/delete',
                                    'id'    => $dataItem->id
                            ] ) ?>"
                                  method="post" class="delete-form">
                                <input type="hidden" name="csrf_token" value="<?= e( getCsrfToken() ) ?>">
                                <button type="submit"
                                        class="delete-btn border border-martian-600 text-martian-600 px-3 py-1 text-xs uppercase tracking-wider transition-colors duration-300 ease-out hover:bg-martian-600 hover:text-white hover:cursor-pointer">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php if ( $pager->haveToPaginate() ):
    $current = $pager->getCurrentPage();
    $last = $pager->getNbPages();
    $window = 1;

    function page_url( int $n ) {
        return $n === 1
                ?
                'index.php?' . route_url( [ 'route' => 'admin/pages' ] )
                : 'index.php?' . route_url( [ 'route' => 'admin/pages', 'paginate' => $n ] );
    }

    ?>
    <nav class="flex items-center justify-center gap-2 mt-8">

        <?php if ( $pager->hasPreviousPage() ): ?>
            <a href="<?= page_url( $pager->getPreviousPage() ) ?>"
               class="px-3 py-1 border border-line text-ink transition-colors duration-300 ease-out hover:border-accent">
                ← Back
            </a>
        <?php endif; ?>

        <?php for ( $i = 1; $i <= $last; $i ++ ): ?>
            <?php if ( $i === 1 || $i === $last || abs( $i - $current ) <= $window ): ?>
                <?php if ( $i === $current ): ?>
                    <span class="px-3 py-1 border bg-accent text-[var(--color-on-accent)] border-accent">
                        <?= $i ?>
                    </span>
                <?php else: ?>
                    <a href="<?= page_url( $i ) ?>"
                       class="px-3 py-1 border border-line text-ink transition-colors duration-300 ease-out hover:border-accent">
                        <?= $i ?>
                    </a>
                <?php endif; ?>
            <?php elseif ( $i === 2 || $i === $last - 1 ): ?>
                <span class="px-2 text-ink/40">…</span>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ( $pager->hasNextPage() ): ?>
            <a href="<?= page_url( $pager->getNextPage() ) ?>"
               class="px-3 py-1 border border-line text-ink transition-colors duration-300 ease-out hover:border-accent">
                Next →
            </a>
        <?php endif; ?>

    </nav>
<?php endif; ?>