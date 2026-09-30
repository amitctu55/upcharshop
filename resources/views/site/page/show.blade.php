@extends('layouts.site')
@section('content')
<article class="max-w-3xl mx-auto px-4 py-12">
    <h1 class="font-display text-4xl font-bold text-[var(--secondary)] mb-6">{{ $page->title }}</h1>
    <div class="prose max-w-none text-gray-700 leading-relaxed">{!! $page->body !!}</div>
</article>
@endsection
