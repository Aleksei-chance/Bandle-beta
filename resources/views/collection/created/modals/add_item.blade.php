@extends('layouts.modal')

@section('id', 'bandle_item_add')

@section('title', 'New Bande')

@section('content')
<x-Input id="title" placeholder="Title" oninput="input_valid(this)"/>
<x-Input id="description" placeholder="Description" oninput="input_valid(this)"/>
@endsection

@section('button')
<button class="modal_main_small" onclick="collection_item_add({{ $id }})">Create</button>
@endsection