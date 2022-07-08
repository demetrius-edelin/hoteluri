$(document).ready(function() {

    $(".calendar-loc").click(function (e) {
        let loc_id = $(this).attr('id');
        $("#" + loc_id).datepicker({
            format: "dd.mm.yyyy",
            language: "ro",
            orientation: "bottom auto",
            autoclose: true,
            multidate: true
        });

        $("#" + loc_id).datepicker('show');

        e.stopPropagation();
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('#token').attr('data-token')
            }
        });
        $.post( "getDateRangeLoc", { id: loc_id } )
            .done(function( data ) {
                $("#" + loc_id).datepicker('setDates', data)
                    .on('changeDate', function (e) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-Token': $('#token').attr('data-token')
                            }
                        });
                        $.post("modificaZiuaCurenta", {data: e.format('yyyy-mm-dd')})
                            .done(function (data) {
                                const response = JSON.parse(data);
                                if (response['status'] === 'failed') {
                                    alert('Modificare dată eșuată. EROARE: ' + response['data']);
                                }
                                $(".overlay").show();
                                location.reload();
                            })
                            .fail(function (error) {
                                console.log(error);
                            });

                    });
            });

    });
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

                let structuraHotel = JSON.parse($('#structuraHotel').attr('data-value'));

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
                                alert('Salvare eșuată. EROARE: ' +response['data']);
                                $(".form-button").removeAttr('disabled');
                                return false;
                            } else {
                                $.magnificPopup.close();
                                $(".overlay").show();
                                location.reload();
                            }
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
                                    alert('Ștergere eșuată. EROARE: ' +response['data']);
                                } else {
                                    $.magnificPopup.close();
                                    $(".overlay").show();
                                    location.reload();
                                }
                            })
                            .fail(function(error) {
                                console.log( error );
                            })
                    }
                });

                $("#button-ocupatot").click(function () {
                    if (window.confirm("Ești sigur că vrei ocupi toate locurile libere din cameră?")) {
                        $(".form-button").attr('disabled', 'disabled');
                        $.post("ocupaTot", $("#form").serialize())
                            .done(function (data) {
                                const response = JSON.parse(data);
                                if (response['status'] === 'failed') {
                                    alert('Ocupare eșuată. EROARE: ' +response['data']);
                                } else {
                                    $.magnificPopup.close();
                                    $(".overlay").show();
                                    location.reload();
                                }
                            })
                            .fail(function(error) {
                                console.log( error );
                            })
                    }
                });

                $("#button-muta").click(function () {
                    $('#button-muta').attr('disabled', 'disabled');
                    $('.muta-toggle').show();
                });

                // schimbă selectia de camere și locuri la schimbare etaj [MUTĂ]
                $("#muta-etaje").change(function() {
                    let camere = Object.keys(structuraHotel[1][$(this).val()]);
                    var camereOptions = '';
                    var primaCamera = 0;
                    camere.forEach((i) => {
                        var selected = '';
                        if (camereOptions === '') {
                            selected = 'selected';
                            primaCamera = i;
                        }
                        if (structuraHotel[1][$(this).val()][i] > 0) {
                            camereOptions += '<option value="' + i + '" ' + selected + '>' + i + '</option>';
                        }
                    });

                    var locuriOption = '';
                    for (var i = 0; i < structuraHotel[1][$(this).val()][primaCamera]; i++) {
                        locuriOption += '<option value="' + i + '" ' + (i === 0 ? 'selected' : '') + '>' + (i + 1) + '</option>';
                    }

                    $('#muta-camere').html(camereOptions);
                    $('#muta-locuri').html(locuriOption);
                })

                // schimbă selectia de locuri la schimbare camera [MUTĂ]
                $("#muta-camere").change(function() {
                    let etaj = $('#muta-etaje').val();

                    var locuriOption = '';
                    for (var i = 0; i < structuraHotel[1][etaj][$(this).val()]; i++) {
                        locuriOption += '<option value="' + i + '" ' + (i === 0 ? 'selected' : '') + '>' + (i + 1) + '</option>';
                    }

                    $('#muta-locuri').html(locuriOption);
                })
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
                    alert('Modificare dată eșuată. EROARE: ' +response['data']);
                }
                $(".overlay").show();
                location.reload();
            })
            .fail(function(error) {
                console.log( error );
            })
    });

});
