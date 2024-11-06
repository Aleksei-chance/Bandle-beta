@extends('layouts.modal')

@section('id', 'bandle_item_renew')

@section('title', 'Bande edit')

@section('content')
<div class="input_block" id="title_block">
    <input type="text" class="input_simple text_black" placeholder="Title" id="title"  oninput="input_valid(this)" value="{!! $title !!}">
    <p class="error_text"></p>
</div>
<div class="input_block" id="description_block">
    <input type="text" class="input_simple text_black" placeholder="Description" id="description"  oninput="input_valid(this)" value="{!! $description !!}">
    <p class="error_text"></p>
</div>
@endsection

@section('button')
<button class="modal_btn_remove" onclick="bandle_remove_item({!! $id !!})">􀈑 Delete</button>
<button class="modal_main_small" action="modal:hide" style="width: 108px;">Done</button>
@endsection