<div class="hover_modal" id="@yield('id')">
    <div class="modal_body">
        <div class="modal_header">
            <button class="modal_btn_close text_black" action="modal:hide">
                <i class="modal_close"></i>
                Back
            </button>
            <p class="text_black text_title">@yield("title")</p>
            <div style="width: 70px;"></div>
        </div>
        <div class="modal_content">
            @yield('content')
        </div>
        @yield('button')
    </div>
</div>

<script>
    $('#@yield("id")').modal('show');
</script>