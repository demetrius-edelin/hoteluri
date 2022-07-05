<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link id="bsdp-css" href="css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel=stylesheet type="text/css" href="css/main.css">

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="locales/bootstrap-datepicker.ro.min.js" charset="UTF-8"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script>
        $(document).ready(function () {
        });
    </script>
</head>

<body>
<div id="main-div">
    <h2>Hotel {{ array_values($hotels)[0]->getNume() }} ({{ array_values($hotels)[0]->situatieOcupare() }})<br><br></h2>
    <div class="taburile">
        @foreach($hotels as $hotel)
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            @foreach($hotel->getEtaje() as $etaj)
            <li class="nav-item" role="presentation">
                <button class="nav-link @if ($loop->first) active @endif" id="{{ $hotel->getNume()  }}-{{ $etaj->getNumar() }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $hotel->getNume()  }}-{{ $etaj->getNumar() }}-tab-pane" type="button" role="tab" aria-controls="{{ $hotel->getNume()  }}-{{ $etaj->getNumar() }}-tab-pane" aria-selected=" @if ($loop->first) true @else false @endif " >Etaj {{ $etaj->getNumar() }}
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
                                    @if(isset($camera->getOcupanti()[$i - 1]))
                                    data-tippy-content="
                                    <h6>{{ $camera->getOcupanti()[$i - 1]['ocupant']->getNume() }} {{ $camera->getOcupanti()[$i - 1]['ocupant']->getprenume() }}</h6>
                                    Anul {{ $camera->getOcupanti()[$i - 1]['ocupant']->getAnCurs() }}, Oraș {{ $camera->getOcupanti()[$i - 1]['ocupant']->getOras() }}<br>
                                    <strong>15.08 - 04.10</strong>
                                    "
                                    @endif class='locatar
                                    @if(isset($camera->getOcupanti()[$i - 1]) && $camera->getOcupanti()[$i - 1]['tip'] == 'plata') loc_ocupat_platitor tippy-popup
                                    @elseif (isset($camera->getOcupanti()[$i - 1]) && $camera->getOcupanti()[$i - 1]['tip'] == 'gratuit') loc_ocupat_gratuit tippy-popup
                                    @else loc-liber
                                    @endif' style='grid-column-start: 1; grid-column-end: 2; grid-row-start: {{ $i + 1 }}; grid-row-end: {{ $i + 2 }}; border-top: 1px solid grey'>&#10148; @if(isset($camera->getOcupanti()[$i - 1])) {{ $camera->getOcupanti()[$i - 1]['ocupant']->getNume() }} {{ $camera->getOcupanti()[$i - 1]['ocupant']->getprenume() }} @endif</div>
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
                <h4 class="fw-bold">Hotel Rai, Etaj 1, Camera 2</h4>
            </div>

            <div class="row g-5 justify-content-center">
                <div class="col-md-7 col-lg-12">
                    <form class="needs-validation" id="form" action="#">
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
<script>
    // With the above scripts loaded, you can call `tippy()` with a CSS
    // selector and a `content` prop:
    tippy('.tippy-popup', {
        theme: 'tomato',
        allowHTML: true,
        hideOnClick: false,
    });
</script>
</body>
</html>
