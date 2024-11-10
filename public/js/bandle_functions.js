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

function bandle_item_renew_modal(id, Func = '') {
    $.ajax({
        url: "/logic/bandle",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'item_renew_modal', id: id, Func: Func}
    }).done(function(data){
        $("#modal").html(data);
    }).fail(function(data){
        
    });
}

function bandle_set_value_text(id, type, value = '')
{
    $.ajax({
        url: "/logic/bandle",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'set_value_text', id: id, type: type, value: value}
    }).done(function(data){
        if(data > 0)
        {
            user_page_load('bandle');
        }
        else
        {
            alert(data);
        }
    }).fail(function(data){
        
    });
}

function bandle_item_remove_modal(id, Func = '') {
    $.ajax({
        url: "/logic/bandle",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'item_remove_modal', id: id, Func: Func}
    }).done(function(data){
        $("#modal_g").html(data);
    }).fail(function(data){
        location.reload();
    });
}

function bandle_item_remove(id, Func = '') {
    $.ajax({
        url: "/logic/bandle",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'item_remove', id: id}
    }).done(function(data){
        if(data > 0) {
            $('#bandle_item_remove').modal('hide');
            $('#bandle_item_renew').modal('hide');
            if(Func == "location") {
                location.reload();
            } else {
                user_page_load('bandle');
            }
            
        }
    }).fail(function(data){
        
    });
}

function bandle_block_item_add_modal(id) {
    $.ajax({
        url: "/logic/block",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'item_add_modal', bandle_id: id}
    }).done(function(data){
        $("#modal").html(data);
        $('#modal').addClass('modal_block_add')
    }).fail(function(data){
        
    });
}

function bandle_block_item_add(id, block_type_id) {
    $.ajax({
        url: "/logic/block",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'item_add', bandle_id: id, block_type_id: block_type_id}
    }).done(function(data){
        if(data > 0)
        {
            bandle_block_items_load(id, 1);
            $('#bandle_block_item_add').modal('hide');
        }
        console.log(data);
    }).fail(function(data){
        
    });
}


