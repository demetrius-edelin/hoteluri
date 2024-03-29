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
                                    $(".form-button").removeAttr('disabled');
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
                                    $(".form-button").removeAttr('disabled');
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

                $("#button-muta-trimite").click(function () {
                    $(".form-button").attr('disabled', 'disabled');
                    $.post("muta", $("#form").serialize())
                        .done(function (data) {
                            const response = JSON.parse(data);
                            if (response['status'] === 'failed') {
                                alert('Ocupare eșuată. EROARE: ' +response['data']);
                                $(".form-button").removeAttr('disabled');
                            } else {
                                $.magnificPopup.close();
                                $(".overlay").show();
                                localStorage.setItem("etaj_id", numeHotelSelectat + '-' + $('#muta-etaje').val() + '-tab');
                                location.reload();
                            }
                        })
                        .fail(function(error) {
                            console.log( error );
                        })
                });

                $("#button-copiaza-trimite").click(function () {
                    $(".form-button").attr('disabled', 'disabled');
                    $.post("copiaza", $("#form").serialize())
                        .done(function (data) {
                            const response = JSON.parse(data);
                            if (response['status'] === 'failed') {
                                alert('Ocupare eșuată. EROARE: ' +response['data']);
                                $(".form-button").removeAttr('disabled');
                            } else {
                                $.magnificPopup.close();
                                $(".overlay").show();
                                localStorage.setItem("etaj_id", numeHotelSelectat + '-' + $('#muta-etaje').val() + '-tab');
                                location.reload();
                            }
                        })
                        .fail(function(error) {
                            console.log( error );
                        })
                });

                // schimbă selectia de camere și locuri la schimbare etaj [MUTĂ]
                $("#muta-etaje").change(function() {
                    let camere = Object.keys(structuraHotel[hotelSelectat][$(this).val()]).sort(function(a, b) {
                        return a - b;
                    });
                    var camereOptions = '';
                    var primaCamera = 0;
                    camere.forEach((i) => {
                        var selected = '';
                        if (camereOptions === '') {
                            selected = 'selected';
                            primaCamera = i;
                        }
                        if (structuraHotel[hotelSelectat][$(this).val()][i] > 0) {
                            camereOptions += '<option value="' + i + '" ' + selected + '>' + i + '</option>';
                        }
                    });

                    var locuriOption = '';
                    for (var i = 0; i < structuraHotel[hotelSelectat][$(this).val()][primaCamera]; i++) {
                        locuriOption += '<option value="' + i + '" ' + (i === 0 ? 'selected' : '') + '>' + (i + 1) + '</option>';
                    }

                    $('#muta-camere').html(camereOptions);
                    $('#muta-locuri').html(locuriOption);
                })

                // schimbă selectia de locuri la schimbare camera [MUTĂ]
                $("#muta-camere").change(function() {
                    let etaj = $('#muta-etaje').val();

                    var locuriOption = '';
                    for (var i = 0; i < structuraHotel[hotelSelectat][etaj][$(this).val()]; i++) {
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

    $("#button-export").click(function () {
        $(this).blur();
        $.post("exportaZiua")
            .done(function (data) {
                const response = JSON.parse(data);
                if (response['status'] === 'failed') {
                    alert('Ocupare eșuată. EROARE: ' +response['data']);
                    $(".form-button").removeAttr('disabled');
                } else {
                    $.magnificPopup.close();
                    $(".overlay").show();
                    localStorage.setItem("etaj_id", numeHotelSelectat + '-' + $('#muta-etaje').val() + '-tab');
                    location.reload();
                }
            })
            .fail(function(error) {
                console.log( error );
            })
    });

    $('.search-select').select2({
        dropdownParent: $('#search-popup')
    });

    $("#button-search").click(function () {
        $(this).blur();
        var token = $("#token").attr('data-token');
        let that = this;
        $.post( "getPersoane", { _token: token } )
            .done(function( data ) {
                let info = JSON.parse(data);
                document.getElementById('search-select').innerHTML = info['data'];
                $('.select2-search__field').focus();
                $.magnificPopup.open({
                    items: {
                        src: '#search-popup'
                    },
                    callbacks: {
                        close: function() {
                            // location.reload();
                        }
                    },
                    type: 'inline'
                }, 0);

                $('#search-select').on('change', function(e) {
                    $.post( "getDatePersoana", { id: e.target.value, _token: token } )
                        .done(function( data ) {
                            let info = JSON.parse(data);
                            document.getElementById('search-persoana-detalii').innerHTML = info['data'];
                        });
                });
            });
    });


    $("#button-available").click(function () {
        $(this).blur();

        var token = $("#token").attr('data-token');
        let that = this;

        $('.input-daterange').datepicker({
            format: "dd.mm.yyyy",
            todayBtn: "linked",
            language: "ro",
            autoclose: true,
            todayHighlight: true
        });

        $.magnificPopup.open({
            items: {
                src: '#available-popup'
            },
            callbacks: {
                close: function() {
                    console.log('close');
                    $('#display-availability').html('');
                }
            },
            type: 'inline'
        }, 0);

        $('#button-export-available-d').click(function () {
            let start = $('#availability_perioada_start')[0].value;
            let end   = $('#availability_perioada_end')[0].value;

            $.get( "exportLocuriLibere", { start: start, end: end, d: 0 } )
                .done(function( data ) {
                    console.log(data);
                    $('#display-availability').html(data);
                });
        });

        $('#button-export-available-e').click(function () {
            let start = $('#availability_perioada_start')[0].value;
            let end   = $('#availability_perioada_end')[0].value;

            window.location.href = "/exportLocuriLibere?start=" + start + "&end=" + end + "&d=1";
        });

    })
});
