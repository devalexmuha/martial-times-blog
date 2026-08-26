<div class="mx-auto max-w-sm py-12">
    <h2 class="mb-8 text-center font-display font-bold text-accent" style="font-size: var(--fluid-lg);">Register</h2>

    <form action="index.php?<?= route_url(['route' => 'admin/register']) ?>" method="post" id="register-form"
          class="flex flex-col gap-5">
        <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()) ?>">

        <div class="flex flex-col gap-1">
            <label for="user-email" class="text-sm uppercase tracking-wider text-ink/70">Email</label>
            <input type="email" name="user-email" id="user-email" required value="<?= e($email ?? '') ?>"
                   class="w-full border border-line bg-surface px-3 py-2 text-ink outline-none transition-colors duration-300 ease-out focus:border-accent">
        </div>

        <div class="flex flex-col gap-1">
            <label for="user-pass" class="text-sm uppercase tracking-wider text-ink/70">Password</label>
            <input type="password" name="user-pass" id="user-pass" required
                   class="w-full border border-line bg-surface px-3 py-2 text-ink outline-none transition-colors duration-300 ease-out focus:border-accent">
        </div>

        <div class="flex flex-col gap-1">
            <label for="verify_pass" class="text-sm uppercase tracking-wider text-ink/70">Verify Password</label>
            <input type="password" name="verify_pass" id="verify_pass" required
                   class="w-full border border-line bg-surface px-3 py-2 text-ink outline-none transition-colors duration-300 ease-out focus:border-accent">
        </div>

        <?php if ($error): ?>
            <p class="text-sm text-martian-600">Fields can't be empty and passwords must match.</p>
        <?php endif; ?>

        <button type="submit" id="input-form-submit-btn"
                class="mt-2 border border-accent bg-accent px-4 py-2 text-sm uppercase tracking-wider text-[var(--color-on-accent)] transition-colors duration-300 ease-out hover:bg-transparent hover:text-accent hover:cursor-pointer">
            Submit
        </button>
    </form>
</div>