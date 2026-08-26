<?php
/** @var \App\Model\PageModel $pageData */
?>
<article class="mx-auto max-w-3xl py-8">

    <?php if ( ! empty( $pageData->image_url ) ): ?>
        <img src="<?= e( image_get_size( $pageData->image_url, 'full' ) ) ?>"
             alt="<?= e( $pageData->name ) ?>"
             class="mb-8 w-full aspect-video object-cover">
    <?php endif; ?>

    <h1 class="mb-4 font-display font-bold leading-tight text-ink"
        style="font-size: var(--fluid-xl);">
        <?= e( $pageData->name ) ?>
    </h1>

    <p class="mb-8 text-sm uppercase tracking-wider text-ink/50">
        <?= e( format_date( $pageData->date_published, 3 ) ) ?>
    </p>

    <div class="mb-8 leading-relaxed text-ink/85" style="font-size: var(--fluid-base);">
        <p class="mb-4"><?= e( $pageData->text ) ?></p>
    </div>

    <a href="/"
       class="text-sm uppercase tracking-wider text-accent transition-all duration-300 ease-out hover:underline">
        ← Back to all dispatches
    </a>
</article>