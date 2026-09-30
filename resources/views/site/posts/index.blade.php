@extends('layouts.site')
@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="font-display text-4xl font-bold text-[var(--secondary)] mb-8">News & Articles</h1>
    <div class="grid md:grid-cols-3 gap-6">
        @foreach($posts as $post)
        <a href="/news/{{ $post->slug }}" class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition border border-gray-100">
            @if($post->cover)<img src="{{ asset('storage/'.$post->cover) }}" class="h-44 w-full object-cover" alt="">@endif
            <div class="p-5">
                <div class="text-xs text-gray-400">{{ $post->publish_at?->format('d M Y') }}</div>
                <h2 class="font-bold mt-1 text-gray-800 hover:text-[var(--primary)]">{{ $post->title }}</h2>
                <p class="text-sm text-gray-500 mt-2">{{ $post->excerpt }}</p>
            </div>
        </a>
        @endforeach
    </div>
    <div class="mt-8">{{ $posts->links() }}</div>
</div>
@endsection
