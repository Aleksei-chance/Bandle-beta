<div class="hover_modal" id="@yield('id')">
    <div class="modal_body bandle_item_add_body">
        <div class="modal_header bandle_item_add_head">
            <button class="modal_btn_close text_black"  action="modal:hide">
                <i class="modal_close"></i>
                Cancel
            </button>
            <div class="title_with_icon">
                @yield("title")
            </div>
            
            <div style="width: 85px;"></div>
        </div>
        @yield('content')
    </div>
</div>

<script>
    $('#@yield('id')').modal('show');
</script>