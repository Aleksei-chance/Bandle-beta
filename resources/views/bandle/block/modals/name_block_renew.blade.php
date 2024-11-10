@extends('layouts.modal')

@section('id', 'bandle_name_block_renew')

@section('title')
<i class="name_card_icon"></i>
<p class="text_black text_title">Name</p>
@endsection

@section('content')
<x-Value-Input id="name" placeholder="Name" onchange="bandle_set_value_text({{ $id }}, 'title', $(this).val())" value="{{ $name }}"/>
<x-Value-Input id="article" placeholder="Article" onchange="bandle_set_value_text({{ $id }}, 'description', $(this).val())" value="{{ $article }}"/>
<x-Value-Input id="pronouns" placeholder="Pronouns" onchange="bandle_set_value_text({{ $id }}, 'description', $(this).val())" value="{{ $pronouns }}"/>
@endsection

@section('button')
<button class="modal_main_small" onclick="bandle_block_renew_item_send({{ $block_id }})">Done</button>
@endsection