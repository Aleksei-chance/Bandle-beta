@extends('layouts.app')

@section('content')

<div class="bandle_item">
    <div class="bandle_head">
        <button class="modal_btn_close text_black"
            onclick="location.href='/collection'"
            style="width: 70px;">
            <i class="modal_close"></i>
            Back
        </button>
        <p class="text_black text_title">{{ $title ?? 'Bandle' }}</p>
        <div style="width: 70px;" class="btn_zero">
            <button class="btn_bandle_edit" onclick="bandle_renew_item({{ $id }}, 'location')"></button>
        </div>
    </div>
    <div class="bandle_item_content" id="content">

    </div>
    <div class="modal_header" style="justify-content: center;" id="bandle_action_btn">
        @include('bandle.buttons')
    </div>
</div>

<script>
    bandle_block_items_load({{ $id }}, {{ $auth }})
</script>

@endsection
