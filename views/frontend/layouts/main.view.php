<!DOCTYPE html>
<html lang="en" data-theme="front">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css"/>
    <script type="module" src="/js/app.js"></script>
    <title>Vanilla Blog</title>
</head>
<body>
<div class="min-h-screen w-full max-w-full bg-paper text-ink font-display flex flex-col">

    <header class="w-full border-b border-vanilla-300">
        <div class="container flex items-center justify-between py-3">
            <a href="/" class="text-accent text-xl font-semibold tracking-tight">MT Times</a>
            <span class="text-sm text-ink/70">Dispatches from the Red Frontier</span>
        </div>
    </header>

    <main class="w-full flex-1">
        <div class="container py-8">
            <?php echo $contents; ?>
        </div>
    </main>

    <footer class="w-full border-t border-vanilla-300 mt-auto">
        <div class="container flex flex-col items-center py-3 text-sm text-ink/60">
            <span>Developed by Muha</span>
        </div>
    </footer>

</div>
</body>
</html>