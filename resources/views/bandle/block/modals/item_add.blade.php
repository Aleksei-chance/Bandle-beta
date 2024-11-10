@extends('layouts.modal_big')

@section('id', 'bandle_block_item_add')

@section('title')
<i class="block_modal_add_item"></i>
<p class="text_black text_title">Add</p>
@endsection

@section('content')
@foreach ($items as $item)
<div class="block_add_item_block" onclick="bandle_block_item_add({{ $id }}, {{ $item['id'] }})">
    <i class="{{ $item["icon"] }}"></i>
    <div class="block_add_item_text">
        <p class="block_add_item_name">{{ $item["name"] }}</p>
        <p class="block_add_item_description">{{ $item["description"] }}</p>
    </div>
</div>
@endforeach
@endsection