<div class="row g-3">
    @if($ocupare == '')<div class="col-sm-6">Număr de locuri rezervate:</div>
    <div class="col-sm-6">
         <select class="form-select" aria-label="Default select example">
            <option value="1" selected>1</option>
            <option value="2">2</option>
        </select>
    </div>@endif
    <div class="col-sm-6">
        <label for="nume" class="form-label">Nume</label>
        <input type="text" class="form-control" id="nume" name="nume" placeholder="" value="@if($ocupare != ''){{ $ocupare['ocupant']->getNume() }}@endif" required="">
    </div>

    <div class="col-sm-6">
        <label for="prenume" class="form-label">Prenume</label>
        <input type="text" class="form-control" id="prenume" name="prenume" placeholder="" value="@if($ocupare != ''){{ $ocupare['ocupant']->getPrenume() }}@endif" required>
    </div>

    <div class="col-sm-2">
        <label for="an_curs" class="form-label">An de curs</label>
        <input type="text" class="form-control" id="an_curs" name="an_curs" placeholder="" value="@if($ocupare != ''){{ $ocupare['ocupant']->getAnCurs() }}@endif" required="">
    </div>
    <div class="col-sm-4">
        <label for="oras" class="form-label">Oraș</label>
        <input type="text" class="form-control" id="oras" name="oras" placeholder="" value="@if($ocupare != ''){{ $ocupare['ocupant']->getOras() }}@endif" required="">
    </div>
    <div class="col-sm-6">
        <label for="tara" class="form-label">Țara</label>
        <input type="text" class="form-control" id="tara" name="tara" placeholder="" value="@if($ocupare != ''){{ $ocupare['ocupant']->getTara() }}@endif" required="">
    </div>
    <div class="col-sm-6">
        <label for="telefon" class="form-label">Telefon</label>
        <input type="text" class="form-control" id="telefon" name="telefon" placeholder="" value="@if($ocupare != ''){{ $ocupare['ocupant']->getTelefon() }}@endif" required="">
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
            <input type="text" class="w-25 form-control" name="start"/>
            <span class="input-group-addon">&nbsp;&nbsp;la&nbsp;&nbsp;</span>
            <input type="text" class="w-25 form-control" name="end"/>
        </div>
    </div>
    <div class="col-sm-6">&nbsp;</div>
    <div class="col-sm-2">&nbsp;</div>
    <button class="col-sm-3 btn btn-danger btn-lg fw-bold me-2 mt-4">Șterge</button>
    <button class="col-sm-3 btn btn-primary btn-lg fw-bold me-2 mt-4">Salvează</button>
    <button class="col-sm-3 btn btn-outline-primary btn-lg fw-bold me-2 mt-4" onclick="$.magnificPopup.close();">
        Renunță
    </button>
