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
                bandle_renew_item(id);
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

function bandle_add_item()
{
    $.ajax({
        url: "/logic/user",
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





