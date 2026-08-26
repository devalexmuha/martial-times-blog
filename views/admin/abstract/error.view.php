<section class="flex flex-col items-center justify-center text-center py-24">
    <p class="font-mono text-xs uppercase tracking-[0.3em] text-ink/40 mb-6">Error · Sector 404</p>

    <h1 class="text-accent font-display font-bold leading-none mb-6" style="font-size: var(--fluid-xl);">
        Page not found
    </h1>

    <p class="text-ink/70 max-w-md mb-10" style="font-size: var(--fluid-base);">
        Nothing broke — this admin page doesn't exist or has been moved.
    </p>

    <a href="index.php?<?= route_url(['route' => 'admin/pages']) ?>"
       class="inline-block border border-accent bg-accent px-6 py-2 text-sm uppercase tracking-wider text-[var(--color-on-accent)] transition-colors duration-300 ease-out hover:bg-transparent hover:text-accent">
        Back to dashboard
    </a>
</section>