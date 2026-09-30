@extends('layouts.site')
@section('content')
<article class="max-w-3xl mx-auto px-4 py-12">
    <div class="text-xs text-gray-400">{{ $post->publish_at?->format('d M Y') }} · {{ $post->views }} views</div>
    <h1 class="font-display text-4xl font-bold text-[var(--secondary)] mt-2 mb-6">{{ $post->title }}</h1>
    @if($post->cover)<img src="{{ asset('storage/'.$post->cover) }}" class="rounded-xl mb-8 w-full shadow" alt="">@endif
    <div class="prose max-w-none text-gray-700 leading-relaxed">{!! $post->body !!}</div>
</article>
@endsection
