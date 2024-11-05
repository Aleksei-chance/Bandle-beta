var TOKEN = $('meta[name="csrf-token"]').attr('content');

function user_page_load(type) {
    $.ajax({
        url: "/logic/user",
        method: "post",
        dataType: "html",
        data: {_token: TOKEN, func: 'page_load', type: type}
    }).done(function(data){
        $("#content").html(data);
        // bandle_actions(type_view);
    }).fail(function(data){
        
    });
}