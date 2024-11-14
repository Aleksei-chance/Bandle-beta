@extends('layouts.app')

@section('content')

    <div class="navigation_bar">
        <img src="{{ asset('svg/Logo-title-1.svg') }}">
        <div class="navigation_btns">
            <button class="nav_button nav_set" onclick="location.href='/settings'"></button>
        </div>
    </div>
    <div class="bandle_container" id="content">

    </div>
    <div class="toolbar">
        <button class="saved_btn {{-- @if ($type_view == 1) saved_btn_active @endif--}}" onclick="location.href='/SavedBandles'"></button>
        <div class="toolbar_separator"></div>
        <button class="my_bandle_btn my_active" onclick="location.href='/MyBandles'"></button>
    </div>

    <script>
        collection_load({{ $id }}, '{!! $type_id !!}');
    </script>

@endsection
