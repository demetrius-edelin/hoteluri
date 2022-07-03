<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel=stylesheet type="text/css" href="css/main.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script>
        $(document).ready(function () {
            @foreach($hotels as $hotel)
                @foreach($hotel->getEtaje() as $etaj)
                    $("#container").append("<div class='grid' style='grid-template-columns: repeat({{ $etaj->getX() }}, 1fr);'></div>");
                    @foreach($etaj->getCamere() as $camera)
                        $(".grid").append("<div class='camera' id='camera_{{ $etaj->getNumar() }}_{{ $camera->getNumar() }}' style='grid-column-start: {{ $camera->getXStart() }}; grid-column-end: {{ $camera->getXEnd() }}; grid-row-start: {{ $camera->getYStart() }}; grid-row-end: {{ $camera->getYEnd() }}; grid-template-rows: {{ $camera->getLocuri() + 1 }}'><div class='numar-camera' style='grid-column-start: 1; grid-column-end: 2; grid-row-start: 1; grid-row-end: 2;'>Camera {{ $camera->getNumar() }}</div></div>");
                        @for($i = 1; $i < $camera->getLocuri() + 1; $i++)
                            $("#camera_{{ $etaj->getNumar() }}_{{ $camera->getNumar() }}").append("<div class='locatar loc-liber' style='grid-column-start: 1; grid-column-end: 2; grid-row-start: {{ $i + 1 }}; grid-row-end: {{ $i + 2 }}; border-top: 1px solid grey'>&nbsp;</div>");
                        @endfor
                    @endforeach
                @endforeach
            @endforeach
        });
    </script>
</head>

<body>
<div id="container">
</div>

<br><br>

</body>
</html>
