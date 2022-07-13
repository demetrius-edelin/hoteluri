<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Hotel {{ array_values($hotels)[0]->getNume() }}</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link id="bsdp-css" href="css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link rel=stylesheet type="text/css" href="css/main.css">

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="locales/bootstrap-datepicker.ro.min.js" charset="UTF-8"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script>
       var ziuaCurenta = "{{ $ziuaCurenta }}";
       var hotelSelectat = {{ env('ACTIVE_HOTEL_ID') }};
       var numeHotelSelectat = "{{ array_values($hotels)[0]->getNume() }}";
    </script>
    <script type="text/javascript" src="js/main.js"></script>
</head>

<body>
<div id="main-div">
    <h2>Hotel {{ array_values($hotels)[0]->getNume() }}: {{ array_values($hotels)[0]->situatieOcupare() }}<br><br></h2>
    <div class="row mb-4">
        <label for="filtru-data" class="col-sm-1 col-form-label-lg">Data:</label>
        <div class="col-sm-2" id="filtru-data-container">
            <input type="text" class="form-control" id="filtru-data" readonly>
        </div>
        <div class="col-sm-7"></div>
        <div class="col-sm-2">
            <a href="\exportaZiua" id="button-export"
                    class="btn btn-sm btn-info">Exportă ziua
            </a>
        </div>
    </div>

    <div class="taburile">
        @foreach($hotels as $hotel)
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach($hotel->getEtaje() as $etaj)
            <li class="nav-item" role="presentation" id="navtab-{{ $hotel->getNume()  }}-{{ $etaj->getNumar() }}-tab">
                <button class="nav-link @if ($loop->first) active @endif" id="{{ $hotel->getNume()  }}-{{ $etaj->getNumar() }}-tab" data-bs-toggle="tab" data-toggle="tab" data-bs-target="#{{ $hotel->getNume()  }}-{{ $etaj->getNumar() }}-tab-pane" type="button" role="tab" aria-controls="{{ $hotel->getNume()  }}-{{ $etaj->getNumar() }}-tab-pane" aria-selected=" @if ($loop->first) true @else false @endif " >Etaj {{ $etaj->getNumar() }}
                    <br>({{ $etaj->situatieOcupare() }})</button>
            </li>
            @endforeach
        </ul>
        <div class="tab-content" id="myTabContent">
            @foreach($hotel->getEtaje() as $etaj)
            <div class="tab-pane fade @if ($loop->first) show active @endif" id="{{ $hotel->getNume()  }}-{{ $etaj->getNumar() }}-tab-pane" role="tabpanel" aria-labelledby="{{ $hotel->getNume()  }}-{{ $etaj->getNumar() }}-tab" tabindex="0">
                <div class='grid' style='grid-template-columns: repeat({{ $etaj->getX() }}, 1fr);'>
                    @foreach($etaj->getCamere() as $camera)
                        <div class='camera' id='camera_{{ $etaj->getNumar() }}_{{ $camera->getNumar() }}' style='grid-column-start: {{ $camera->getXStart() }}; grid-column-end: {{ $camera->getXEnd() }}; grid-row-start: {{ $camera->getYStart() }}; grid-row-end: {{ $camera->getYEnd() }}; grid-template-rows: {{ $camera->getLocuri() + 1 }}'><div class='numar-camera' style='grid-column-start: 1; grid-column-end: 2; grid-row-start: 1; grid-row-end: 2;'>Camera {{ $camera->getNumar() }}</div>
                            @for($i = 1; $i < $camera->getLocuri() + 1; $i++)
                                <div href="#test-popup" id="camera_{{ $hotel->getId() }}_{{ $etaj->getNumar() }}_{{ $camera->getNumar() }}_{{ $i - 1 }}"
                                     data-etaj="{{ $etaj->getNumar() }}" data-camera="{{ $camera->getNumar() }}" data-loc="{{ $i }}"

                                    @if(isset($camera->getOcupanti()[$i - 1]))
                                    data-tippy-content="
                                    <h6>{{ $camera->getOcupanti()[$i - 1]['ocupant']->getNume() }} {{ $camera->getOcupanti()[$i - 1]['ocupant']->getprenume() }}</h6>
                                    Anul {{ $camera->getOcupanti()[$i - 1]['ocupant']->getAnCurs() }}, Oraș {{ $camera->getOcupanti()[$i - 1]['ocupant']->getOras() }}<br>
                                    <strong>{{ $camera->getOcupanti()[$i - 1]['perioada_start_formatata'] }} - {{ $camera->getOcupanti()[$i - 1]['perioada_end_formatata'] }} (pleacă {{ $camera->getOcupanti()[$i - 1]['perioada_end_formatata_plus_unu'] }},{{ $camera->getOcupanti()[$i - 1]['zile'] }} nopți)</strong>
                                    "
                                    @endif

                                     class='locatar position-relative
                                    @if(isset($camera->getOcupanti()[$i - 1]) && $camera->getOcupanti()[$i - 1]['tip'] == 'plata') loc_ocupat_platitor tippy-popup
                                    @elseif (isset($camera->getOcupanti()[$i - 1]) && $camera->getOcupanti()[$i - 1]['tip'] == 'gratuit') loc_ocupat_gratuit tippy-popup
                                    @else loc-liber
                                    @endif'
                                     style='grid-column-start: 1; grid-column-end: 2; grid-row-start: {{ $i + 1 }}; grid-row-end: {{ $i + 2 }}; border-top: 1px solid grey'><img src="img/cal.png" width="18px" class="calendar-loc" id="calendar-loc_{{ $hotel->getId() }}_{{ $etaj->getNumar() }}_{{ $camera->getNumar() }}_{{ $i - 1 }}" > @if(isset($camera->getOcupanti()[$i - 1])) {{ $camera->getOcupanti()[$i - 1]['ocupant']->getNume() }} {{ $camera->getOcupanti()[$i - 1]['ocupant']->getprenume() }}
                                    <div class="position-absolute end-0 translate-middle-y top-50">@if($camera->getOcupanti()[$i - 1]['tip'] == 'plata') @if($camera->getOcupanti()[$i - 1]['achitat'] == 1)<span class="loc-actions fs-6 me-1" title="Achitat">&#10003;</span>@else <span class="loc-actions me-1" style="font-size: 0.9rem !important;" title="Neachiat">&#9888;</span> @endif @endif  </div>
                                    @endif</div>
                            @endfor
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>


<br><br>
<div style="display: none" id="token" data-token="{{ csrf_token() }}"></div>
<div id="test-popup" class="white-popup mfp-hide">
    <div class="container" style="max-width: 780px;">
        <main>
            <div class="text-center mt-4 mb-5">
                <h4 class="fw-bold">Hotel {{ array_values($hotels)[0]->getNume() }}, Etaj <span id="titlu-popup-etaj"></span>, Camera <span id="titlu-popup-camera"></span>, Locul <span id="titlu-popup-loc"></span></h4>
            </div>

            <div class="row g-5 justify-content-center">
                <div class="col-md-7 col-lg-12">
                    <form class="needs-validation" id="form" action="#" onsubmit="return false;">
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
<div class="overlay" style="display: none;">
    <div class="overlay__inner">
        <div class="overlay__content"><span class="spinner"></span></div>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/tippy-bundle.umd.min.js"></script>
<script>
    tippy('.tippy-popup', {
        theme: 'tomato',
        allowHTML: true,
        hideOnClick: false,
    });
</script>
</body>
</html>
