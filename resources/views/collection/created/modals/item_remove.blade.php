@extends('layouts.modal_small')

@section('id', 'bandle_item_remove')

@section('title', 'Delete this Bandle?')

@section('button')
<button class="remove_modal_btn text_red border_right" onclick="bandle_set_value_text({{ $bandle_id }}, 'hidden', 1, {{ $id }})">Delete</button>
<button class="remove_modal_btn" action="modal:hide" >Cancel</button>
@endsection
