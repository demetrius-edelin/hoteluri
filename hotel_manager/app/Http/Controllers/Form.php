<?php

namespace App\Http\Controllers;

use App\Data;
use App\Http\Classes\Camera;
use App\Http\Classes\Etaj;
use App\Http\Classes\Hotel;
use App\Http\Classes\Ocupant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Form extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $descriptionArray = Data::$hoteluri;

        $ocupari = DB::select('select * from ocupare o join persoane p on p.id=o.persoana_id;');

        $ocupareDb = [];
        foreach ($ocupari as $ocupare) {
            $ocupareDb[$ocupare->hotel_id][$ocupare->etaj_numar][$ocupare->camera_numar][] = $ocupare;
        }

        $hotels = [];
        foreach ($descriptionArray as $hotelName => $hotelContent) {
            $hotelTotalLocuri = 0;
            $hotelOcupareLocuri = 0;
            $hotel = new Hotel($hotelContent['id'], $hotelName);

            foreach ($hotelContent['etaje'] as $etajNumar => $etajContent) {
                $etajTotalLocuri = 0;
                $etajOcupareLocuri = 0;
                $etaj = new Etaj($etajNumar, $etajContent['x'], $etajContent['y']);

                foreach ($etajContent['camere'] as $cameraNumar => $cameraContent) {
                    $camera = new Camera(
                        $cameraNumar,
                        $cameraContent['locuri'],
                        $cameraContent['x_start'],
                        $cameraContent['x_end'],
                        $cameraContent['y_start'],
                        $cameraContent['y_end']
                    );

                    $hotelTotalLocuri += $cameraContent['locuri'];
                    $etajTotalLocuri  += $cameraContent['locuri'];

                    if (isset($ocupareDb[$hotel->getId()][$etajNumar][$cameraNumar])) {
                        foreach ($ocupareDb[$hotel->getId()][$etajNumar][$cameraNumar] as $ocupant) {
                            $camera->adaugaOcupant(new Ocupant(
                                $ocupant->nume,
                                $ocupant->prenume,
                                $ocupant->an_curs,
                                $ocupant->oras,
                                $ocupant->tara,
                                $ocupant->premiu
                            ), $ocupant->tip);

                            $hotelOcupareLocuri++;
                            $etajOcupareLocuri++;
                        }
                    };

                    $etaj->adaugaCamera($camera);
                }
                $etaj->setTotalLocuri($etajTotalLocuri);
                $etaj->setOcupareLocuri($etajOcupareLocuri);

                $hotel->adaugaEtaj($etaj);
            }
            $hotel->setTotalLocuri($hotelTotalLocuri);
            $hotel->setOcupareLocuri($hotelOcupareLocuri);

            $hotels[$hotelContent['id']] = $hotel;
        }

        return view('form', [
            'hotels' => $hotels
        ]);
    }

    public function getOcupare(Request $request)
    {
        $idData = explode('_', $request->input('id')); // etaj_camera_loc
        $hotels = Data::getStructure();
        $ocupantiCamera = $hotels[$idData[1]]->getEtaje()[$idData[2]]->getCamere()[$idData[3]]->getOcupanti();

        $ocupare = '';
        if (isset($ocupantiCamera[$idData[4]])) {
            $ocupare = $ocupantiCamera[$idData[4]];
        }

        return view('form-ajax', [
            'ocupare' => $ocupare
        ]);
    }
}
