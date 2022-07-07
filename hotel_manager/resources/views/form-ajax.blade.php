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
        <input type="text" class="form-control" id="nume" name="nume" placeholder="" value="@if($ocupare != ''){{ $ocupare['ocupant']->getNume() }}@endif" >
    </div>

    <div class="col-sm-6">
        <label for="prenume" class="form-label">Prenume</label>
        <input type="text" class="form-control" id="prenume" name="prenume" placeholder="" value="@if($ocupare != ''){{ $ocupare['ocupant']->getPrenume() }}@endif" >
    </div>

    <div class="col-sm-2">
        <label for="an_curs" class="form-label">An de curs</label>
        <input type="text" class="form-control" id="an_curs" name="an_curs" placeholder="" value="@if($ocupare != ''){{ $ocupare['ocupant']->getAnCurs() }}@endif" >
    </div>
    <div class="col-sm-4">
        <label for="oras" class="form-label">Oraș</label>
        <input type="text" class="form-control" id="oras" name="oras" placeholder="" value="@if($ocupare != ''){{ $ocupare['ocupant']->getOras() }}@endif" >
    </div>
    <div class="col-sm-6">
        <label for="tara" class="form-label">Țara</label>
        <input type="text" class="form-control" id="tara" name="tara" placeholder="" value="@if($ocupare != ''){{ $ocupare['ocupant']->getTara() }}@endif" >
    </div>
    <div class="col-sm-6">
        <label for="telefon" class="form-label">Telefon</label>
        <input type="text" class="form-control" id="telefon" name="telefon" placeholder="" value="@if($ocupare != ''){{ $ocupare['ocupant']->getTelefon() }}@endif" >
    </div>
    <div class="col-sm-3">
        <label for="platitor" class="form-label">Cu plată</label>
        <select id="platitor" name="tip" class="form-select" aria-label="Default select example">
            <option value="plata" selected>DA</option>
            <option value="gratuit">NU</option>
        </select>
    </div>
    <div class="col-sm-3">
        <label for="achitat" class="form-label">A achitat</label>
        <select id="achitat" name="achitat" class="form-select" aria-label="Default select example">
            <option value="0">DA</option>
            <option value="1" selected>NU</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label for="datepicker" class="form-label">Perioada</label>
        <div class="input-daterange input-group" id="datepicker">
            <span class="input-group-addon">De la&nbsp;&nbsp;</span>
            <input type="text" class="w-25 form-control" id="perioada_start" name="perioada_start" value="@if($ocupare != ''){{ $ocupare['perioada_start_formatata'] }}@else{{ $dataCurenta }}@endif"/>
            <span class="input-group-addon">&nbsp;&nbsp;la&nbsp;&nbsp;</span>
            <input type="text" class="w-25 form-control" id="perioada_end" name="perioada_end" value="@if($ocupare != ''){{ $ocupare['perioada_end_formatata'] }}@else{{ $dataCurenta }}@endif"/>
        </div>
    </div>
    <div class="col-sm-6">&nbsp;</div>
    <div class="col-sm-2">&nbsp;</div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="hotel" value="{{ $hotel }}" />
    <input type="hidden" name="etaj" value="{{ $etaj }}" />
    <input type="hidden" name="camera" value="{{ $camera }}" />
    <input type="hidden" name="loc" value="{{ $loc }}" />
    <input type="hidden" name="persoana_id" value="@if($ocupare != ''){{ $ocupare['ocupant']->getId() }}@endif" />
    <button id="button-delete" class="form-button col-sm-3 btn btn-danger btn-lg fw-bold me-2 mt-4" @if($ocupare == '') disabled @endif>Șterge</button>
    <button id="button-salvare" class="form-button col-sm-3 btn btn-primary btn-lg fw-bold me-2 mt-4">Salvează</button>
    <button class="form-button col-sm-3 btn btn-outline-primary btn-lg fw-bold me-2 mt-4" onclick="$.magnificPopup.close();">
        Renunță
    </button>
</div>
