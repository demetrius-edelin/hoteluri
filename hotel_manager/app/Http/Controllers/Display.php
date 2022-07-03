<?php

namespace App\Http\Controllers;

use App\Http\Classes\Camera;
use App\Http\Classes\Etaj;
use App\Http\Classes\Hotel;
use Illuminate\Http\Request;

class Display extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $description = json_encode([
            'Rai' => [
                'etaje' => [
                    '0' => [
                        'x' => 8,
                        'y' => 17,
                        'camere' => [
                            '2' => [
                                'locuri' => 2,
                                'x_start' => 1,
                                'x_end' => 4,
                                'y_start' => 5,
                                'y_end' => 7
                            ],
                            '3' => [
                                'locuri' => 2,
                                'x_start' => 1,
                                'x_end' => 4,
                                'y_start' => 7,
                                'y_end' => 9
                            ],
                            '4' => [
                                'locuri' => 2,
                                'x_start' => 1,
                                'x_end' => 4,
                                'y_start' => 9,
                                'y_end' => 11
                            ],
                            '5' => [
                                'locuri' => 2,
                                'x_start' => 1,
                                'x_end' => 4,
                                'y_start' => 11,
                                'y_end' => 13
                            ],
                            '6' => [
                                'locuri' => 2,
                                'x_start' => 1,
                                'x_end' => 4,
                                'y_start' => 13,
                                'y_end' => 15
                            ],
                            '7' => [
                                'locuri' => 1,
                                'x_start' => 1,
                                'x_end' => 4,
                                'y_start' => 15,
                                'y_end' => 17
                            ],
                            '1' => [
                                'locuri' => 0,
                                'x_start' => 4,
                                'x_end' => 5,
                                'y_start' => 1,
                                'y_end' => 5
                            ],
                            '16' => [
                                'locuri' => 1,
                                'x_start' => 5,
                                'x_end' => 6,
                                'y_start' => 1,
                                'y_end' => 5
                            ],
                            '15' => [
                                'locuri' => 2,
                                'x_start' => 6,
                                'x_end' => 9,
                                'y_start' => 1,
                                'y_end' => 3
                            ],
                            '14' => [
                                'locuri' => 2,
                                'x_start' => 6,
                                'x_end' => 9,
                                'y_start' => 3,
                                'y_end' => 5
                            ],
                            '13' => [
                                'locuri' => 2,
                                'x_start' => 6,
                                'x_end' => 9,
                                'y_start' => 5,
                                'y_end' => 7
                            ],
                            '12' => [
                                'locuri' => 2,
                                'x_start' => 6,
                                'x_end' => 9,
                                'y_start' => 7,
                                'y_end' => 9
                            ],
                            '11' => [
                                'locuri' => 2,
                                'x_start' => 6,
                                'x_end' => 9,
                                'y_start' => 9,
                                'y_end' => 11
                            ],
                            '10' => [
                                'locuri' => 2,
                                'x_start' => 6,
                                'x_end' => 9,
                                'y_start' => 11,
                                'y_end' => 13
                            ],
                            '9' => [
                                'locuri' => 2,
                                'x_start' => 6,
                                'x_end' => 9,
                                'y_start' => 13,
                                'y_end' => 15
                            ],
                            '8' => [
                                'locuri' => 2,
                                'x_start' => 6,
                                'x_end' => 9,
                                'y_start' => 15,
                                'y_end' => 17
                            ],
                        ]
                    ]
                ]
            ]
        ]);

        $descriptionArray = json_decode($description, TRUE);

        $hotels = [];
        foreach ($descriptionArray as $hotelName => $hotelContent) {
            $hotel = new Hotel($hotelName);
            foreach ($hotelContent['etaje'] as $etajNumar => $etajContent) {
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

                    $etaj->adaugaCamera($camera);
                }

                $hotel->adaugaEtaj($etaj);
            }

            $hotels[] = $hotel;
        }

        return view('display', [
            'hotels' => $hotels
        ]);
    }
}
