@extends('layouts.modal')

@section('id', 'bandle_item_renew')

@section('title', 'Bande edit')

@section('content')
<x-Value-Input id="title" placeholder="Title" onchange="bandle_set_value_text({{ $id }}, 'title', $(this).val())" value="{{ $title }}"/>
<x-Value-Input id="description" placeholder="Description" onchange="bandle_set_value_text({{ $id }}, 'description', $(this).val())" value="{{ $description }}"/>
@endsection

@section('button')
<button class="modal_btn_remove" onclick="bandle_item_remove_modal({!! $id !!})">􀈑 Delete</button>
<button class="modal_main_small" action="modal:hide" style="width: 108px;">Done</button>
@endsection