$(document).ready(function(){
    $("#formCadastro").validate({
        rules:{
            nome:{
                required:true,
               maxlength: 90,
               minlength: 10,
               minWords:2
            },
            iemail:{
                required:true,
                email:true,
            },
            iDataN:{
                required:true,
            },
            iTel:{
                required:true,

            }
            
        }
   })     
})
$(document).ready(function(){
    $("#formProf").validate({
        rules:{
            nome:{
                required:true,
               maxlength: 90,
               minlength: 10,
               minWords:2
            },
            email:{
                required:true,
                email:true,
            },
            senha:{
                required:true,
                rangelength: [4,10]
            },
            Tel:{
                required:true,
            },
            DataN:{
                required:true,
            }
            
        }
   })     
})
$(document).ready(function(){
    $("#form").validate({
        rules:{
            nome:{
                required:true,
               maxlength: 90,
               minlength: 10,
               minWords:2
            },
            imattricula:{
                required:true,
            },
            data:{
                required:true,  
            },
            ano:{
                required:true,
            },
            hora:{
                required:true,
            },
            end:{
                required:true,
            }
            
        }
   })     
})
$(document).ready(function(){
    $("#formEdit").validate({
        rules:{
            nome:{
                required:true,
               maxlength: 90,
               minlength: 10,
               minWords:2
            },
            email:{
                required:true,
                email:true,
            },
            Data:{
                required:true,   
            },
            iTel:{
                required:true,
            }
            
        }
   })     
})
$(document).ready(function(){
    $("#formTurma").validate({
        rules:{
            required:true,
            
        }
   })     
})


!function(e){e.fn.niceSelect=function(t){function s(t){t.after(e("<div></div>").addClass("nice-select").addClass(t.attr("class")||"").addClass(t.attr("disabled")?"disabled":"").attr("tabindex",t.attr("disabled")?null:"0").html('<span class="current"></span><ul class="list"></ul>'));var s=t.next(),n=t.find("option"),i=t.find("option:selected");s.find(".current").html(i.data("display")||i.text()),n.each(function(t){var n=e(this),i=n.data("display");s.find("ul").append(e("<li></li>").attr("data-value",n.val()).attr("data-display",i||null).addClass("option"+(n.is(":selected")?" selected":"")+(n.is(":disabled")?" disabled":"")).html(n.text()))})}if("string"==typeof t)return"update"==t?this.each(function(){var t=e(this),n=e(this).next(".nice-select"),i=n.hasClass("open");n.length&&(n.remove(),s(t),i&&t.next().trigger("click"))}):"destroy"==t?(this.each(function(){var t=e(this),s=e(this).next(".nice-select");s.length&&(s.remove(),t.css("display",""))}),0==e(".nice-select").length&&e(document).off(".nice_select")):console.log('Method "'+t+'" does not exist.'),this;this.hide(),this.each(function(){var t=e(this);t.next().hasClass("nice-select")||s(t)}),e(document).off(".nice_select"),e(document).on("click.nice_select",".nice-select",function(t){var s=e(this);e(".nice-select").not(s).removeClass("open"),s.toggleClass("open"),s.hasClass("open")?(s.find(".option"),s.find(".focus").removeClass("focus"),s.find(".selected").addClass("focus")):s.focus()}),e(document).on("click.nice_select",function(t){0===e(t.target).closest(".nice-select").length&&e(".nice-select").removeClass("open").find(".option")}),e(document).on("click.nice_select",".nice-select .option:not(.disabled)",function(t){var s=e(this),n=s.closest(".nice-select");n.find(".selected").removeClass("selected"),s.addClass("selected");var i=s.data("display")||s.text();n.find(".current").text(i),n.prev("select").val(s.data("value")).trigger("change")}),e(document).on("keydown.nice_select",".nice-select",function(t){var s=e(this),n=e(s.find(".focus")||s.find(".list .option.selected"));if(32==t.keyCode||13==t.keyCode)return s.hasClass("open")?n.trigger("click"):s.trigger("click"),!1;if(40==t.keyCode){if(s.hasClass("open")){var i=n.nextAll(".option:not(.disabled)").first();i.length>0&&(s.find(".focus").removeClass("focus"),i.addClass("focus"))}else s.trigger("click");return!1}if(38==t.keyCode){if(s.hasClass("open")){var l=n.prevAll(".option:not(.disabled)").first();l.length>0&&(s.find(".focus").removeClass("focus"),l.addClass("focus"))}else s.trigger("click");return!1}if(27==t.keyCode)s.hasClass("open")&&s.trigger("click");else if(9==t.keyCode&&s.hasClass("open"))return!1});var n=document.createElement("a").style;return n.cssText="pointer-events:auto","auto"!==n.pointerEvents&&e("html").addClass("no-csspointerevents"),this}}(jQuery);

$(document).ready(function() {
  $('.personalizar-select').niceSelect();
});
$(document).ready(function(){
    $("#iTel").mask("(00) 0.0000-0000")
    $("idataN").mask("00/00/0000")
    $("#iTelResponsavel").mask("(00) 0.0000-0000")
    $("#matricula").mask("00000000")

})

  $(document).ready(function(){
      $("#confirmNumber") . validate({
        rules:{
            required:true,
            
        }
   })    
   $("#iNum").mask("(00) 0.0000-0000") 

  
  })
 