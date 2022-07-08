<div class="row g-3">
    @if($ocupare == '' && $multipleSelections > 1)
        <div class="col-sm-6">Număr de locuri rezervate:</div>
        <div class="col-sm-6">
            <select class="form-select" aria-label="Default select example" name="multipleSelection">
                <option value="1" selected>un loc</option>
                <option value="2">toată camera</option>
            </select>
        </div>@endif
    <div class="col-sm-6">
        <label for="nume" class="form-label">Nume</label>
        <input type="text" class="form-control" id="nume" name="nume" placeholder=""
               value="@if($ocupare != ''){{ $ocupare['ocupant']->getNume() }}@endif">
    </div>

    <div class="col-sm-6">
        <label for="prenume" class="form-label">Prenume</label>
        <input type="text" class="form-control" id="prenume" name="prenume" placeholder=""
               value="@if($ocupare != ''){{ $ocupare['ocupant']->getPrenume() }}@endif">
    </div>

    <div class="col-sm-2">
        <label for="an_curs" class="form-label">An de curs</label>
        <input type="text" class="form-control" id="an_curs" name="an_curs" placeholder=""
               value="@if($ocupare != ''){{ $ocupare['ocupant']->getAnCurs() }}@endif">
    </div>
    <div class="col-sm-4">
        <label for="oras" class="form-label">Oraș</label>
        <input type="text" class="form-control" id="oras" name="oras" placeholder=""
               value="@if($ocupare != ''){{ $ocupare['ocupant']->getOras() }}@endif">
    </div>
    <div class="col-sm-6">
        <label for="tara" class="form-label">Țara</label>
        <input type="text" class="form-control" id="tara" name="tara" placeholder=""
               value="@if($ocupare != ''){{ $ocupare['ocupant']->getTara() }}@endif">
    </div>
    <div class="col-sm-6">
        <label for="telefon" class="form-label">Telefon</label>
        <input type="text" class="form-control" id="telefon" name="telefon" placeholder=""
               value="@if($ocupare != ''){{ $ocupare['ocupant']->getTelefon() }}@endif">
    </div>
    <div class="col-sm-3">
        <label for="platitor" class="form-label">Cu plată</label>
        <select id="platitor" name="tip" class="form-select" aria-label="Default select example">
            <option value="plata" @if($ocupare != '') @if($ocupare['tip'] == 'plata') selected
                    @endif @else selected @endif>DA
            </option>
            <option value="gratuit" @if($ocupare != '' && $ocupare['tip'] == 'gratuit') selected @endif>NU</option>
        </select>
    </div>
    <div class="col-sm-3">
        <label for="achitat" class="form-label">A achitat</label>
        <select id="achitat" name="achitat" class="form-select" aria-label="Default select example">
            <option value="0" @if($ocupare != '') @if($ocupare['achitat'] == '0') selected @endif @else selected @endif>
                NU
            </option>
            <option value="1" @if($ocupare != '' && $ocupare['achitat'] == '1') selected @endif>DA</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label for="datepicker" class="form-label">Perioada (începutul zilelor de cazare):</label>
        <div class="input-daterange input-group" id="datepicker">
            <span class="input-group-addon">De la&nbsp;&nbsp;</span>
            <input type="text" class="w-25 form-control" id="perioada_start" name="perioada_start"
                   value="@if($ocupare != ''){{ $ocupare['perioada_start_formatata'] }}@else{{ $dataCurenta }}@endif"/>
            <span class="input-group-addon">&nbsp;&nbsp;la&nbsp;&nbsp;</span>
            <input type="text" class="w-25 form-control" id="perioada_end" name="perioada_end"
                   value="@if($ocupare != ''){{ $ocupare['perioada_end_formatata'] }}@else{{ $dataCurenta }}@endif"/>
        </div>
    </div>
    <div class="col-sm-6">&nbsp;</div>
    <div class="col-sm-2">&nbsp;</div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    <input type="hidden" name="hotel" value="{{ $hotel }}"/>
    <input type="hidden" name="etaj" value="{{ $etaj }}"/>
    <input type="hidden" name="camera" value="{{ $camera }}"/>
    <input type="hidden" name="loc" value="{{ $loc }}"/>
    <input type="hidden" id="structuraHotel" data-value="{{ json_encode($structuraHotel) }}"/>
    <input type="hidden" name="persoana_id" value="@if($ocupare != ''){{ $ocupare['ocupant']->getId() }}@endif"/>
    <div class="col-sm-10 d-grid gap-2 d-md-flex justify-content-md-end">
        @if($ocupare != '')
            @if($poateLuaCamera)
                <button type="button" id="button-ocupatot"
                        class="form-button col-sm-2 btn btn-info btn-sm fw-bold me-2 mt-4">Ia toată
                </button>
            @endif
            <button type="button" id="button-muta"
                    class="form-button col-sm-2 btn btn-info btn-sm fw-bold me-2 mt-4">Mută
            </button>
            <button type="button" id="button-delete"
                    class="form-button col-sm-2 btn btn-danger btn-sm fw-bold me-2 mt-4">Șterge
            </button>
        @endif
        <button id="button-salvare" class="form-button col-sm-2 btn btn-primary btn-sm fw-bold me-2 mt-4"
                type="submit">Salvează
        </button>
        <button type="button" class="form-button col-sm-2 btn btn-outline-primary btn-sm fw-bold me-2 mt-4"
                onclick="$.magnificPopup.close();">Renunță
        </button>
    </div>
    <div class="col-sm-4 muta-toggle">&nbsp;</div>
    <div class="col-sm-2 muta-toggle">
        <label for="muta-etaje" class="form-label">Etaj</label>
        <select id="muta-etaje" name="muta-etaje" class="form-select" >
            @foreach($structuraHotel[1] as $numar => $etajArray)
                <option value="{{ $numar }}" @if($numar == $etaj)  selected @endif>
                    {{ $numar }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-2 muta-toggle">
        <label for="muta-camere" class="form-label">Camera</label>
        <select id="muta-camere" name="muta-camere" class="form-select" >
            @foreach($structuraHotel[1][$etaj] as $numar => $cameraArray)
                <option value="{{ $numar }}" @if($numar == $camera)  selected @endif>
                    {{ $numar }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-sm-2 muta-toggle">
        <label for="muta-locuri" class="form-label">Loc</label>
        <select id="muta-locuri" name="muta-locuri" class="form-select" >
            @for($i = 0; $i < $structuraHotel[1][$etaj][$camera]; $i++)
                <option value="{{ $i }}" @if($i == $loc)  selected @endif>
                    {{ $i + 1 }}
                </option>
            @endfor
        </select>
    </div>
    <div class="col-sm-2 muta-toggle position-relative">
        <button type="button" id="button-muta-trimite"
                class="form-button btn btn-info btn-sm fw-bold position-absolute bottom-0 start-0 mb-1">Mută acum
        </button>
    </div>
</div>
