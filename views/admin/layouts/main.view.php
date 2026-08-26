<!DOCTYPE html>
<html lang="en"
      data-theme="<?= !empty($_SESSION['user_logged_in']) && $_SESSION['user_type'] === 'super_admin' ? 'super-admin' : 'admin' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css"/>
    <script type="module" src="/js/app.js"></script>
    <title>Vanilla Admin</title>
</head>
<body>
<div class="min-h-screen w-full max-w-full bg-paper text-ink font-display flex flex-col">

    <header class="w-full border-b border-line">
        <div class="container flex items-center justify-between py-3">
            <a href="index.php?<?= route_url(['route' => 'admin/pages']) ?>"
               class="text-accent text-xl font-semibold tracking-tight">Vanilla Admin</a>

            <?php if (!empty($_SESSION['user_logged_in'])): ?>
                <div class="flex items-center gap-6">

                    <?php if ($_SESSION['user_type'] === 'super_admin'): ?>
                        <a href="index.php?<?= route_url(['route' => 'admin/register']) ?>"
                           class="text-sm uppercase tracking-wider text-accent transition-all duration-300 ease-out hover:underline">
                            Register admin
                        </a>
                    <?php else: ?>
                        <span class="text-sm text-ink/70"><?php echo e(mb_substr($_SESSION['user_email'], 0, 25)) ?></span>
                    <?php endif; ?>

                    <form action="index.php?<?= route_url(['route' => 'admin/log-out']) ?>" method="post">
                        <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()) ?>">
                        <button type="submit"
                                class="border border-accent text-accent px-4 py-1 text-sm uppercase tracking-wider transition-colors duration-300 ease-out hover:bg-accent hover:text-[var(--color-on-accent)] hover:cursor-pointer">
                            Log out
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <main class="w-full flex-1">
        <div class="container py-8"><?php echo $contents; ?></div>
    </main>

    <footer class="w-full border-t border-line mt-auto">
        <div class="container flex flex-col items-center py-3 text-sm text-ink/60">
            <span>Developed by Muha</span>
        </div>
    </footer>

</div>
</body>
</html>