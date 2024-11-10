<div class="hover_modal" id="@yield('id')">
    <div class="remove_modal_body">
        <div class="remove_modal_content">
            <p class="text_black text_center">@yield("title")</p>
        </div>
        <div class="remove_modal_btn_group">
            @yield('button')
        </div>
    </div>
</div>


<script>
    $('#@yield("id")').modal('show');
</script>