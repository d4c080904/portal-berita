@csrf

<div class="space-y-6">

    {{-- JUDUL --}}
    <div>
        <label class="block text-sm font-medium mb-1">Judul</label>
        <input
            type="text"
            name="title"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-red-500"
            value="{{ old('title', $article->title ?? '') }}"
        >
        @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- KATEGORI --}}
    <div>
        <label class="block text-sm font-medium mb-1">Kategori</label>
        <select
            name="category_id"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-red-500"
        >
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    @selected(old('category_id', $article->category_id ?? null) == $cat->id)>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- INPUT TAGS (BARU MINGGU 9) --}}
    <div>
        <label class="block text-sm font-medium mb-1">Tags (Pisahkan dengan koma)</label>
        <input
            type="text"
            name="tags"
            placeholder="Contoh: transfer, breaking news, timnas"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-red-500"
            {{-- Ambil tag lama (jika edit) atau input sebelumnya (jika error) --}}
            value="{{ old('tags', isset($article) ? $article->tags->pluck('name')->implode(', ') : '') }}"
        >
        <p class="text-xs text-gray-500 mt-1">Gunakan koma untuk memisahkan tag.</p>
        @error('tags') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- KONTEN (CKEDITOR) --}}
    <div>
        <label class="block text-sm font-medium mb-1">Konten</label>
        <textarea
            id="content-editor"
            name="content"
            rows="10"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-red-500"
        >{{ old('content', $article->content ?? '') }}</textarea>
        @error('content') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- GAMBAR --}}
    <div>
        <label class="block text-sm font-medium mb-1">Gambar (opsional)</label>
        <input
            type="file"
            name="image"
            class="block w-full text-sm text-gray-700"
            accept="image/*"
        >
        @if(!empty($article?->image))
            <p class="text-xs text-gray-500 mt-1">
                Gambar sekarang:
                <a href="{{ asset('storage/'.$article->image) }}" target="_blank" class="text-red-600 underline">
                    Lihat
                </a>
            </p>
        @endif
        @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- STATUS --}}
    <div>
        <label class="block text-sm font-medium mb-1">Status</label>
        <select
            name="status"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-red-500"
        >
            <option value="draft" @selected(old('status', $article->status ?? 'draft') === 'draft')>
                Draft
            </option>
            <option value="published" @selected(old('status', $article->status ?? '') === 'published')>
                Publish
            </option>
        </select>
        @error('status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- FEATURED / BERITA UNGGULAN --}}
    <div class="flex items-center gap-2 pt-2">
        <input 
            type="checkbox" 
            id="is_featured" 
            name="is_featured" 
            value="1"
            class="w-5 h-5 text-red-600 rounded focus:ring-red-500"
            @checked(old('is_featured', $article->is_featured ?? false))
        >
        <label for="is_featured" class="text-sm font-medium text-gray-700 select-none cursor-pointer">
            Jadikan Berita Unggulan (Hot News)
        </label>
    </div>

    {{-- BUTTON --}}
    <div class="flex gap-3 pt-4">
        <button
            class="px-5 py-2 bg-red-600 text-white rounded shadow hover:bg-red-700 transition"
        >
            {{ isset($article) ? 'Update' : 'Simpan' }}
        </button>

        <a href="{{ route('admin.articles.index') }}" class="px-5 py-2 border rounded text-gray-700">
            Batal
        </a>
    </div>

</div>