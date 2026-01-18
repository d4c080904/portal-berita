@extends('admin.layouts.app')

@section('title','Edit Artikel')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Artikel: {{ $article->title }}</h1>

        <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.articles._form')
        </form>
    </div>
@endsection

@push('scripts')
    {{-- CKEditor 5 CDN --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const el = document.querySelector('#content-editor');
            if (!el) return;

            ClassicEditor
                .create(el, {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'blockQuote', 'insertTable', 'undo', 'redo'
                    ]
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endpush
