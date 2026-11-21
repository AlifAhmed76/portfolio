@extends('themes.futuristic-tech.layouts.app')

@section('title', $page->meta_title ?: $page->title . ' — Alif Ahmed')

@section('content')
<div class="page-builder-wrapper">
    <x-blocks.renderer :blocks="$blocks" />
</div>
@endsection
