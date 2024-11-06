@extends('layouts.modal')

@section('id', 'bandle_item_add')

@section('title', 'New Bande')

@section('content')
<x-Input id="title" placeholder="Title" oninput="input_valid(this)" onchange=""/>
<x-Input id="description" placeholder="Description" oninput="input_valid(this)" onchange=""/>
@endsection

@section('button')
<button class="modal_main_small" onclick="bandle_item_add()">Create</button>
@endsection