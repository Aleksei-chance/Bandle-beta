@extends('layouts.modal')

@section('id', 'bandle_item_add')

@section('title', 'New Bande')

@section('content')
<div class="input_block" id="title_block">
    <input type="text" class="input_simple text_black" placeholder="Title" id="title"  oninput="input_valid(this)">
    <p class="error_text"></p>
</div>
<div class="input_block" id="description_block">
    <input type="text" class="input_simple text_black" placeholder="Description" id="description"  oninput="input_valid(this)">
</div>
@endsection

@section('button')
<button class="modal_main_small" onclick="bandle_item_add_send()">Create</button>
@endsection