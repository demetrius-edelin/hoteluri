$(document).ready(function() {
    // $(".locatar").colorbox({
    //     width:900,
    //     transition:"elastic",
    //     speed:100,
    //     onLoad:function(){ console.log($(this).attr('id')); },
    // });
    // $('.locatar').magnificPopup({
    //     type:'inline',
    //     callbacks: {
    //         elementParse: function(item) {
    //             // Function will fire for each target element
    //             // "item.el" is a target DOM element (if present)
    //             // "item.src" is a source that you may modify
    //
    //             console.log('Parsing content. Item object that is being parsed:', item.el[0].id);
    //             $("#test-popup").innerHTML = "cucu";
    //         },
    //     }
    //     // closeOnContentClick: false,
    //     // closeOnBgClick: false,
    //     // showCloseBtn: true
    // });

    $('.locatar').click(function() {
        var token = $("#token").attr('data-token');
        $.post( "getOcupare", { id: $( this ).attr('id'), _token: token } )
            .done(function( data ) {
                document.getElementById('form').innerHTML = data;
                $.magnificPopup.open({
                    items: {
                        src: '#test-popup'
                    },
                    type: 'inline'

                    // You may add options here, they're exactly the same as for $.fn.magnificPopup call
                    // Note that some settings that rely on click event (like disableOn or midClick) will not work here
                }, 0);
            });
    });

    $('.input-daterange').datepicker({
        format: "dd/mm/yyyy",
        startDate: "01/08/2002",
        todayBtn: "linked",
        language: "ro",
        autoclose: true,
        todayHighlight: true
    });
});
