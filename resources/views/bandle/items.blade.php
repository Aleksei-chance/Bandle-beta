<div class="bandle_items_list">
    @if (count($items) > 0)
        @foreach ($items as $item)
            <div class="block block_action" id="block_{{ $item['id'] }}" style="order:{{ $item['sort'] }}">
                <div class="block_content" id="block_{{ $item['id'] }}_content">

                </div>
                @if ($access)
                    <div class="block_remove" id="block_remove_{{ $item['id'] }}" action="bandle_block_item_remove_modal({{ $id }}, {{ $item['id'] }})">
                        􀈒 Delete
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <br><br><br><br>
        <center>Add first block!</center>
        <br><br><br><br>
    @endif
</div>

<script>
    bandle_block_items_content_load();
</script>