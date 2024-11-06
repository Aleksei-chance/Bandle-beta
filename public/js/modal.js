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