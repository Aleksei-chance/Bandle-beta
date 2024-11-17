@extends('layouts.modal_small')

@section('id', 'bandle_block_item_remove')

@section('title', 'Delete this block?')

@section('button')
<button class="remove_modal_btn text_red border_right" onclick="bandle_block_set_value_text({{ $block_id }}, 'hidden', 1, 0, {{ $id }})">Delete</button>
<button class="remove_modal_btn" action="modal:hide">Cancel</button>
@endsection
