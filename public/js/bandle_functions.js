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





(
    function (factory) {
        if(typeof module === "object" && typeof module.exports === "object") {
            factory(require("jquery"), window, document);
        }
        else {
            factory(jQuery, window, document);
        }
    }
    (
        function($, window, document, undefined) {
  
            var modals = [],
            getCurrent = function() {
            return modals.length ? modals[modals.length - 1] : null;
            },
            selectCurrent = function() {
                var i,
                        selected = false;
                for (i=modals.length-1; i>=0; i--) {
                    if (modals[i].$blocker) {
                        modals[i].$blocker.toggleClass('current',!selected).toggleClass('behind',selected);
                        selected = true;
                    }
                }
            };
    
            $.modal = function(el, option) {
                this.$body = $('body');
                this.el = $(el);

                if(option == 'show') {
                    this.open();
                    modals.push(this);
                } else if(option == 'hide') {
                    this.close();
                    modals.pop();
                }
            };

            $.modal.prototype = {
                constructor: $.modal,

                open:function() {
                    this.el.show();
                    $(document).off('click').on('click', function(event) {
                        let target = event.target;
                        let curent = getCurrent();
                        if($(target).hasClass('hover_modal')) {
                            curent.close();
                        }
                    });

                    $('button[action~="modal:hide"]').off('click').on('click', function() {
                        $.modal.close();
                    });
                },

                close:function() {
                    modals.pop();
                    this.el.hide();
                }
            }
    
    
            $.modal.close = function(event) {
                var current = getCurrent();
                current.close();
                return current.$elm;
            };
    
        
        
            $.fn.modal = function(options){
            if (this.length === 1) {
                new $.modal(this, options);
            }
            return this;
            };
        }
    )
);