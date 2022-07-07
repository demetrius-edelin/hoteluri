$(document).ready(function() {
    $('.locatar').click(function() {
        var token = $("#token").attr('data-token');
        let that = this;
        $.post( "getOcupare", { id: $(this).attr('id'), _token: token } )
            .done(function( data ) {
                $("#titlu-popup-etaj").html($(that).attr('data-etaj'))
                $("#titlu-popup-camera").html($(that).attr('data-camera'))
                $("#titlu-popup-loc").html($(that).attr('data-loc'))

                // introducem formularul completat in pagina
                document.getElementById('form').innerHTML = data;

                // activam date pickerul
                $('.input-daterange').datepicker({
                    format: "dd.mm.yyyy",
                    todayBtn: "linked",
                    language: "ro",
                    autoclose: true,
                    todayHighlight: true
                });

                // deschidem popupul
                $.magnificPopup.open({
                    items: {
                        src: '#test-popup'
                    },
                    type: 'inline'
                }, 0);

                $("#button-salvare").click(function () {
                    $(".form-button").attr('disabled', 'disabled');
                    $.post("salvareOcupare", $("#form").serialize())
                        .done(function (data) {
                            const response = JSON.parse(data);
                            if (response['status'] === 'failed') {
                                alert('Salvare eșuată. Eroare: ' +response['data']);
                            }
                            $.magnificPopup.close();
                            $(".overlay").show();
                            location.reload();
                        })
                        .fail(function(error) {
                            console.log( error );
                        })
                });

                $("#button-delete").click(function () {
                    if (window.confirm("Ești sigur că vrei să ștergi ocuparea acestui loc?")) {
                        $(".form-button").attr('disabled', 'disabled');
                        $.post("stergereOcupare", $("#form").serialize())
                            .done(function (data) {
                                const response = JSON.parse(data);
                                if (response['status'] === 'failed') {
                                    alert('Ștergere eșuată. Eroare: ' +response['data']);
                                }
                                $.magnificPopup.close();
                                $(".overlay").show();
                                location.reload();
                            })
                            .fail(function(error) {
                                console.log( error );
                            })
                    }
                });
            });
    });

    // save selected etaj
    $(".nav-link").click(function () {
        localStorage.setItem("etaj_id", $(this)[0].id);
    });

    const etaj_id =  localStorage.getItem("etaj_id");
    if (etaj_id !== undefined) {
        $('#' + etaj_id).tab('show');
    }

    let filtruDatepicker = $('#filtru-data-container input').datepicker({
        format: "dd.mm.yyyy",
        todayBtn: "linked",
        language: "ro",
        orientation: "bottom auto",
        autoclose: true,
        todayHighlight: true
    });
    $('#filtru-data-container input').datepicker('setDate', new Date(ziuaCurenta));

    filtruDatepicker.on('changeDate', function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('#token').attr('data-token')
            }
        });
        $.post("modificaZiuaCurenta", { data: e.format('yyyy-mm-dd') })
            .done(function (data) {
                const response = JSON.parse(data);
                if (response['status'] === 'failed') {
                    alert('Modificare dată eșuată. Eroare: ' +response['data']);
                }
                $(".overlay").show();
                location.reload();
            })
            .fail(function(error) {
                console.log( error );
            })
    });

});
