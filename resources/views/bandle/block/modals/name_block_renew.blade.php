@extends('layouts.modal')

@section('id', 'bandle_name_block_renew')

@section('title')
<i class="name_card_icon"></i>
<p class="text_black text_title">Name</p>
@endsection

@section('content')
<x-Value-Input id="name" placeholder="Name" onchange="bandle_block_set_value_text({{ $id }}, 'name', $(this).val(), 1)" value="{{ $name }}"/>
<x-Value-Input id="article" placeholder="Article" onchange="bandle_block_set_value_text({{ $id }}, 'article', $(this).val(), 1)" value="{{ $article }}"/>
<x-Value-Input id="pronouns" placeholder="Pronouns" onchange="bandle_block_set_value_text({{ $id }}, 'pronouns', $(this).val(), 1)" value="{{ $pronouns }}"/>
@endsection

@section('button')
<button class="modal_main_small" action="modal:hide">Done</button>
@endsection
