var TOKEN = $('meta[name="csrf-token"]').attr('content');

function user_page_load(type)
{
    $.ajax({
        url: "/logic/user",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'page_load', type: type}
    }).done(function(data)
    {
        $("#content").html(data);
        bandle_actions(0);
    }).fail(function(data)
    {
        
    });

    
}

function bandle_actions(type_view)
{
    let check = 0;

    $(".bundle_action").bind("touchstart mousedown", function(e)
    {
        let id = $(e.currentTarget).attr('id').replaceAll('bandle_', '');
        check = 1;
        Timer = setTimeout(function() 
        {
            if(type_view == 0)
            {
                bandle_item_renew_modal(id);
            }
            check = 0;
        }, 300);
    });


    $(".bundle_action").bind("touchend mouseup", function(e)
    {
        let id = $(e.currentTarget).attr('id').replaceAll('bandle_', '');
        if(check)
        {
            location.href = "/bandle/"+id;
        }
        clearTimeout(Timer);
    });
}

function bandle_item_add_modal()
{
    $.ajax({
        url: "/logic/bandle",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, Type: 'Bandle', func: 'item_add_modal'}
    }).done(function(data)
    {
        $("#modal").html(data);
    }).fail(function(data)
    {
        
    });
}

function input_valid(e) 
{
    let val = $(e).val();
    let block = $(e).parent().parent();
    block.find(".error_text").hide().text("");
    block.find("input").removeClass('input_error');
    block.find("i").removeClass('icon_error');
    if(val != "")
    {
        block.find("i").removeClass('icon_send');
        block.find("i").addClass('icon_clear');
    }
    else
    {
        block.find("i").addClass('icon_send');
        block.find("i").removeClass('icon_clear');
    }
}

function input_error(data) 
{
    let massages = data.split('|');
    $.each(massages, function (index, value) 
    { 
        let massage = value.split(':');
        let block = $("#"+massage[0]+'_block');
        block.find("input").addClass('input_error');
        if(block.find("input").val()) 
        {
            block.find("i").removeClass('icon_send').addClass('icon_error');
        }
        block.find(".error_text").show().text(massage[1]);
    });
}

function bandle_item_add() 
{
    let title = $('#title').val();
    let description = $('#description').val();
    $.ajax({
        url: "/logic/bandle",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'item_add', title: title, description: description}
    }).done(function(data)
    {
        if(data > 0) 
        {
            user_page_load('bandle');
            $('#bandle_item_add').modal('hide');
        } 
        else 
        {
            input_error(data);
        }
    }).fail(function(data){
        
    });
}

function bandle_item_renew_modal(id, Func = '') 
{
    $.ajax({
        url: "/logic/bandle",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'item_renew_modal', id: id, Func: Func}
    }).done(function(data)
    {
        $("#modal").html(data);
    }).fail(function(data)
    {
        
    });
}

function bandle_set_value_text(id, type, value = '')
{
    $.ajax({
        url: "/logic/bandle",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'set_value_text', id: id, type: type, value: value}
    }).done(function(data)
    {
        if(data > 0)
        {
            user_page_load('bandle');
        }
        else
        {
            alert(data);
        }
    }).fail(function(data)
    {
        
    });
}

function bandle_item_remove_modal(id, Func = '') 
{
    $.ajax({
        url: "/logic/bandle",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'item_remove_modal', id: id, Func: Func}
    }).done(function(data)
    {
        $("#modal_g").html(data);
    }).fail(function(data)
    {
        location.reload();
    });
}

function bandle_item_remove(id, Func = '') 
{
    $.ajax({
        url: "/logic/bandle",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'item_remove', id: id}
    }).done(function(data)
    {
        if(data > 0) 
        {
            $('#bandle_item_remove').modal('hide');
            $('#bandle_item_renew').modal('hide');
            if(Func == "location") 
            {
                location.reload();
            } else 
            {
                user_page_load('bandle');
            }
            
        }
    }).fail(function(data)
    {
        
    });
}

function bandle_block_item_add_modal(id) 
{
    $.ajax({
        url: "/logic/block",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'item_add_modal', bandle_id: id}
    }).done(function(data)
    {
        $("#modal").html(data);
        $('#modal').addClass('modal_block_add')
    }).fail(function(data)
    {
        
    });
}

function bandle_block_item_add(id, block_type_id) 
{
    $.ajax({
        url: "/logic/block",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'item_add', bandle_id: id, block_type_id: block_type_id}
    }).done(function(data)
    {
        if(data > 0)
        {
            bandle_block_items_load(id, 1);
            $('#bandle_block_item_add').modal('hide');
        }
        console.log(data);
    }).fail(function(data)
    {
        
    });
}

function bandle_block_items_load(id, auth = false) 
{
    $.ajax({
        url: "/logic/block",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'items_load', bandle_id: id}
    }).done(function(data)
    {
        $("#content").html(data);
        if(auth) 
        {
            bandle_block_actions();
        }
    }).fail(function(data)
    {
        
    });
}

function bandle_block_items_content_load() 
{
    $(document).find('.block').each(function() {
        let id = $(this).attr('id').replace('block_', '');
        bandle_block_item_content_load(id);
    });
}

function bandle_block_item_content_load(id) 
{
    $.ajax({
        url: "/logic/block",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'item_content_load', id: id}
    }).done(function(data)
    {
        $("#block_"+id+"_content").html(data);
    }).fail(function(data)
    {
        
    });
}

function bandle_block_actions() 
{
    let func = "";
    let func_hold = false;
    let moveX = false;
    let moveY = false;
    let id_active = 0;

    let block = null;
    let content = null;

    let new_position = 0;

    $(".block_action").bind("touchstart mousedown", function(e){
        moveX = moveY = func_hold = check = new_poz = 0;
        id_active = $(e.currentTarget).attr('id').replace('block_', '');
        check = 1;
        func_hold = 0;
        
        let func_element = e.target;
        func = $(func_element).attr('action');
        if(func === undefined) {
            func = $(func_element).parent().attr('onclick');
        }

        block = $('#block_'+id_active);
        content = $('#block_'+id_active+'_content');
        let pozStart_Y = e.pageY;
        let width = $('.bandle_items_list').width();
        let top = block.position().top;
        let block_height = block.height();
        let list_height = $('.bandle_items_list').height();

        let positions = bandle_block_get_positions();

        $("#bandle_item_content").find('.block_remove').each(function() {
            let id_check = $(this).attr('id').replace('block_remove_', '');
            if(id_check != id_active) {
                $('#block_remove_'+id_check).css('width', 0);
                $('#block_remove_'+id_check).css('padding', 0);
                $('#block_remove_'+id_check).parent().css('gap', 0);
            }
        });

        oneSecondTimer = setTimeout(function() {
            if(!moveX) {
                $(document).unbind('touchmove mousemove');
                $(document).bind('touchmove mousemove', function(e) {
                    if(e.pageY < pozStart_Y - 10 || e.pageY > pozStart_Y + 10) {
                        moveY = true;
                    }
                    if((e.pageY < pozStart_Y || e.pageY > pozStart_Y)) {
                        bandle_block_remove_action(id_active);

                        block.height(block_height);
                        content.addClass('bandle_item_absolute');
                        content.css('width', width);

                        let new_poz = top - (pozStart_Y - e.pageY);
                        if(new_poz < 0) {
                            new_poz = 0;
                        } if(new_poz > (list_height - block_height)) {
                            new_poz = (list_height - block_height);
                        }

                        content.css('top', new_poz);
                        
                        let order = block.css('order');

                        $.each(positions, function(key, item) {
                            if(key == parseInt(order) + 1 && new_poz > item.topD) {
                                let move_id = item.id;
                                $('#block_' + move_id).css('order', order);
                                block.css('order', key);
                                new_position = key;
                            }
                            if(key == parseInt(order) - 1 && new_poz < item.topU) {
                                let move_id = item.id;
                                $('#block_' + move_id).css('order', order);
                                block.css('order', key);
                                new_position = key;
                            }
                        });

                        positions = bandle_block_get_positions();
                        
                        
                    }
                });
            }
            func_hold = true;
            func = "";
        }, 300);


        let pozStart_X = e.pageX;
        
        $(document).bind('touchmove mousemove', function(e) {
            if(e.pageX < pozStart_X || e.pageX > pozStart_X) {
                if(e.pageX < pozStart_X - 10 || e.pageX > pozStart_X + 10) {
                    moveX = 1;
                }
                
                let width = pozStart_X - e.pageX;
                if(width > 89) {
                    width = 89;
                }
                $('#block_remove_'+id_active).css('width', width);
                if(width > 0) {
                    $('#block_remove_'+id_active).css('padding', 8);
                    $('#block_remove_'+id_active).parent().css('gap', 8);
                } else {
                    $('#block_remove_'+id_active).css('padding', 0);
                    $('#block_remove_'+id_active).parent().css('gap', 0);
                }
            }
        });

        return false;
    });

    function bandle_block_get_positions() {
        let positions = {};
        $('.block').each(function() {
            let pos_order = $(this).css('order');
            let pos_id = $(this).attr('id').replace('block_', '');
            let pos_height = $(this).height()
            let pos_topD = $(this).position().top - pos_height / 2;
            let pos_topU = $(this).position().top + pos_height / 2;

            positions[pos_order] = {id: pos_id, topD: pos_topD, topU: pos_topU};
        });

        return positions;
    }

    $(document).bind("touchend mouseup", function(e){
        $(document).unbind('touchmove mousemove');
        clearTimeout(oneSecondTimer);

        if(!moveX && !moveY && func_hold) {
            bandle_block_renew_item(id_active);
        } else if(moveX && !moveY) {
            let remove_width = $('#block_remove_'+id_active).css('width').replace('px', '');
            if(remove_width > 59) {
                bandle_block_remove_action(id_active, 'set');
            } else {
                bandle_block_remove_action(id_active);
            }
        } else if(!moveX && moveY) {
            block.parent().height('auto');
            content.removeClass('bandle_item_absolute');
            content.css('width', 'auto');
            content.css('top', 0);
        } else if (!moveX && !moveY && !func_hold && func != "") {
            eval(func);
        }

        if(new_position > 0) {
            bandle_block_position_set(id_active, new_position);
            new_position = 0;
        }

        id_active = 0;
        moveX = moveY = func_hold = false;
        func = "";
    });

    $(document).on("touchcancel", function(e) {
        $(document).unbind('touchmove mousemove');
        clearTimeout(oneSecondTimer);
        id_active = 0;
        moveX = moveY = func_hold = false;
    })

    function bandle_block_remove_action(id, func = 'remove') {
        if(func == 'remove') {
            $('#block_remove_'+id).css('width', 0);
            $('#block_remove_'+id).css('padding', 0);
            $('#block_remove_'+id).parent().css('gap', 0);
        } else if(func == 'set') {
            $('#block_remove_'+id).css('width', 89);
            $('#block_remove_'+id).css('padding', 8);
            $('#block_remove_'+id).parent().css('gap', 8);
        }
    }
}

function bandle_block_item_remove_modal(id) {
    $.ajax({
        url: "/logic/block",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'item_remove_modal', id: id}
    }).done(function(data){
        $("#modal").html(data);
    }).fail(function(data){
        
    });
}


