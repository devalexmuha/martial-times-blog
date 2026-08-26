<div class="mx-auto max-w-xl py-8">
    <h2 class="mb-8 font-display font-bold text-accent" style="font-size: var(--fluid-lg);">Create a New Post</h2>

    <form action="index.php?<?= route_url(['route' => 'admin/pages/add']) ?>" method="post" id="input-form"
          class="flex flex-col gap-5" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= e(getCsrfToken()) ?>">

        <div class="flex flex-col gap-1">
            <label for="input-name" class="text-sm uppercase tracking-wider text-ink/70">Name</label>
            <input type="text" name="name" id="input-name"
                   class="w-full border border-line bg-surface px-3 py-2 text-ink outline-none transition-colors duration-300 ease-out focus:border-accent">
        </div>

        <div class="flex flex-col gap-1">
            <label for="slug" class="text-sm uppercase tracking-wider text-ink/70">Slug</label>
            <input type="text" name="slug" id="slug"
                   class="w-full border border-line bg-surface px-3 py-2 text-ink outline-none transition-colors duration-300 ease-out focus:border-accent">
        </div>

        <div class="flex flex-col gap-1">
            <label for="date_published" class="text-sm uppercase tracking-wider text-ink/70">Date Published</label>
            <input type="datetime-local" name="date_published" id="date_published"
                   class="w-full border border-line bg-surface px-3 py-2 text-ink outline-none transition-colors duration-300 ease-out hover:cursor-pointer">
        </div>

        <div class="flex flex-col gap-1" id="image-upload-field">
            <label class="text-sm uppercase tracking-wider text-ink/70">Image</label>


            <label for="image"
                   class="group relative block w-full max-w-xs overflow-hidden border border-line bg-surface transition-colors duration-300 ease-out hover:border-accent hover:cursor-pointer">

                    <img id="image-preview"
                         src=""
                         alt=""
                         class="hidden w-full aspect-video object-cover">

                <div id="image-placeholder"
                     class="flex aspect-video w-full items-center justify-center text-sm uppercase tracking-wider text-ink/50 transition-all duration-300 ease-out group-hover:opacity-0">
                    Click to choose image
                </div>

                <!-- hover overlay hint -->
                <div class="pointer-events-none absolute inset-0 flex items-center justify-center bg-ink/0 text-[var(--color-on-accent)] opacity-0 transition-all duration-300 ease-out group-hover:bg-ink/40 group-hover:opacity-100">
                    <span class="text-sm uppercase tracking-wider">Choose image</span>
                </div>

                <!-- the real input, hidden but functional -->
                <input type="file" name="image" id="image" accept="image/*"  class="absolute inset-0 h-full w-full opacity-0 cursor-pointer">
            </label>
        </div>

        <div class="flex flex-col gap-1">
            <label for="text" class="text-sm uppercase tracking-wider text-ink/70">Text</label>
            <textarea name="text" id="text" rows="10"
                      class="w-full border border-line bg-surface px-3 py-2 text-ink outline-none transition-colors duration-300 ease-out focus:border-accent"></textarea>
        </div>

        <button type="submit" id="input-form-submit-btn"
                class="mt-2 self-start border border-accent bg-accent px-6 py-2 text-sm uppercase tracking-wider text-[var(--color-on-accent)] transition-colors duration-300 ease-out hover:bg-transparent hover:text-accent hover:cursor-pointer">
            Submit
        </button>
    </form>
</div>