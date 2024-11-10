@extends('layouts.modal_small')

@section('id', 'bandle_block_item_remove')

@section('title', 'Delete this block?')

@section('button')
<button class="remove_modal_btn text_red border_right" onclick="bandle_block_item_remove({{ $id }}, {{ $bandle_id }})">Delete</button>
<button class="remove_modal_btn" action="modal:hide">Cancel</button>
@endsection