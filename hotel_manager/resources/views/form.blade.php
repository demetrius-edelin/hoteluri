<!doctype html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="favicon.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Title</title>
    <link rel=stylesheet type="text/css" href="css/main.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="js/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <link id="bsdp-css" href="css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="locales/bootstrap-datepicker.ro.min.js" charset="UTF-8"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script>
        window.onload = function () {
            const validation = new JustValidate('#form');

            validation
                .addField('#nume', [
                    {
                        rule: 'minLength',
                        value: 3,
                        errorMessage: 'e',
                    },
                    {
                        rule: 'required',
                        errorMessage: 'e',
                    },
                ])
                .addField('#prenume', [
                    {
                        rule: 'minLength',
                        value: 3,
                        errorMessage: 'e',
                    },
                    {
                        rule: 'required',
                        errorMessage: 'ee',
                    },
                ])
                .addField('#an_curs', [
                    {
                        rule: 'number',
                        errorMessage: 'ee',
                    },
                    {
                        rule: 'minNumber',
                        value: 0,
                        errorMessage: 'ee',
                    },
                    {
                        rule: 'maxNumber',
                        value: 32,
                        errorMessage: 'ee',
                    },
                    {
                        rule: 'required',
                        errorMessage: 'ee',
                    },
                ])
                .addField('#oras', [
                    {
                        rule: 'minLength',
                        value: 3,
                        errorMessage: 'ee',
                    },
                    {
                        rule: 'required',
                        errorMessage: 'ee',
                    },
                ])
                .addField('#telefon', [
                    {
                        rule: 'required',
                        errorMessage: 'ee',
                    },                    {
                        rule: 'customRegexp',
                        value: /^[+. 0-9]+$/,
                        errorMessage: 'ee',
                    },
                ])
                .onSuccess((event) => {
                    document.getElementById("form").submit();
                });
        };
    </script>
    <style>
        .bootstrap-select {
            display: block !important;
            width: 100% !important;
        }
    </style>
</head>
<body>
<div class="container" style="max-width: 780px;">
    <main>
        <div class="text-center mt-4 mb-5">
            <h4 class="fw-bold">Hotel Rai, Etaj 1, Camera 2</h4>
        </div>

        <div class="row g-5 justify-content-center">
            <div class="col-md-7 col-lg-12">
                <form class="needs-validation" id="form" novalidate="" action="#" method="post">
                    <div class="row g-3">
                        <div class="col-sm-6">Număr de locuri rezervate: </div>
                        <div class="col-sm-6">
                            <select class="form-select" aria-label="Default select example">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="nume" class="form-label">Nume</label>
                            <input type="text" class="form-control" id="nume" name="nume" placeholder="" value="" required="">
                        </div>

                        <div class="col-sm-6">
                            <label for="prenume" class="form-label">Prenume</label>
                            <input type="text" class="form-control" id="prenume" name="prenume" placeholder="" value="" required>
                        </div>

                        <div class="col-sm-2">
                            <label for="an_curs" class="form-label">An de curs</label>
                            <input type="text" class="form-control" id="an_curs" name="an_curs" placeholder="" value="" required="">
                        </div>
                        <div class="col-sm-4">
                            <label for="oras" class="form-label">Oraș</label>
                            <input type="text" class="form-control" id="oras" name="oras" placeholder="" value="" required="">
                        </div>
                        <div class="col-sm-6">
                            <label for="tara" class="form-label">Țara</label>
                            <input type="text" class="form-control" id="tara" name="tara" placeholder="" value="" required="">
                        </div>
                        <div class="col-sm-6">
                            <label for="telefon" class="form-label">Telefon</label>
                            <input type="text" class="form-control" id="telefon" name="telefon" placeholder="" value="" required="">
                        </div>
                        <div class="col-sm-3">
                            <label for="platitor" class="form-label">Plătitor</label>
                            <select id="platitor" name="platitor" class="form-select" aria-label="Default select example">
                                <option value="0" selected>DA</option>
                                <option value="1">NU</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="achitat" class="form-label">A achitat</label>
                            <select id="achitat" name="achitat" class="form-select" aria-label="Default select example">
                                <option value="0" selected>DA</option>
                                <option value="1">NU</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="datepicker" class="form-label">Perioada</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon">De la&nbsp;&nbsp;</span>
                                <input type="text" class="w-25 form-control" name="start" />
                                <span class="input-group-addon">&nbsp;&nbsp;la&nbsp;&nbsp;</span>
                                <input type="text" class="w-25 form-control" name="end" />
                            </div>
                        </div>
                        <div class="col-sm-6">&nbsp;</div>
                        <div class="col-sm-2">&nbsp;</div>
                        <input type="submit" class="col-sm-3 btn btn-danger btn-lg fw-bold me-2 mt-4" value="Șterge" />
                        <input type="submit" class="col-sm-3 btn btn-primary btn-lg fw-bold me-2 mt-4" value="Trimite" />
                        <button class="col-sm-3 btn btn-outline-primary btn-lg fw-bold me-2 mt-4" onclick="$.magnificPopup.close();">Renunță</button>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>
