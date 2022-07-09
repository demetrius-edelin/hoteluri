<?php

namespace App;

use App\Http\Classes\Camera;
use App\Http\Classes\Etaj;
use App\Http\Classes\Hotel;
use App\Http\Classes\Ocupant;
use Illuminate\Support\Facades\DB;

class Data
{
    /**
     * Structura descriere diagrame camere
     *
     * Etajele au x,y dimensiunea grid-ului
     * Camerele au x,y pozitia de start si pozitia de sfârșit
     *
     *
     * @var \array[][][]
     */
    public static $hoteluri = [
        'Rai' => [
            'id' => 1,
            'etaje' => [
                '-1' => [
                    'x' => 9,
                    'y' => 13,
                    'camere' => [
                        '1' => [
                            'locuri' => 1,
                            'x_start' => 4,
                            'x_end' => 6,
                            'y_start' => 1,
                            'y_end' => 4
                        ],
                        '2' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 1,
                            'y_end' => 3
                        ],
                        '3' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 3,
                            'y_end' => 5
                        ],
                        '4' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 5,
                            'y_end' => 7
                        ],
                        '5' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 7,
                            'y_end' => 9
                        ],
                        '6' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 9,
                            'y_end' => 11
                        ],
                        '7' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 11,
                            'y_end' => 13
                        ],
                        '8' => [
                            'locuri' => 2,
                            'x_start' => 7,
                            'x_end' => 10,
                            'y_start' => 11,
                            'y_end' => 13
                        ],
                        '9' => [
                            'locuri' => 2,
                            'x_start' => 7,
                            'x_end' => 10,
                            'y_start' => 9,
                            'y_end' => 11
                        ],
                        '10' => [
                            'locuri' => 2,
                            'x_start' => 7,
                            'x_end' => 10,
                            'y_start' => 7,
                            'y_end' => 9
                        ],
                        '11' => [
                            'locuri' => 2,
                            'x_start' => 7,
                            'x_end' => 10,
                            'y_start' => 5,
                            'y_end' => 7
                        ],
                        '12' => [
                            'locuri' => 2,
                            'x_start' => 7,
                            'x_end' => 10,
                            'y_start' => 3,
                            'y_end' => 5
                        ],
                        '13' => [
                            'locuri' => 2,
                            'x_start' => 7,
                            'x_end' => 10,
                            'y_start' => 1,
                            'y_end' => 3
                        ],
                    ]
                ],
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
                ],
                '1' => [
                    'x' => 8,
                    'y' => 17,
                    'camere' => [
                        '101' => [
                            'locuri' => 1,
                            'x_start' => 4,
                            'x_end' => 5,
                            'y_start' => 1,
                            'y_end' => 5
                        ],
                        '118' => [
                            'locuri' => 1,
                            'x_start' => 5,
                            'x_end' => 6,
                            'y_start' => 1,
                            'y_end' => 5
                        ],
                        '102' => [
                            'locuri' => 1,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 1,
                            'y_end' => 3
                        ],
                        '103' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 3,
                            'y_end' => 5
                        ],
                        '104' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 5,
                            'y_end' => 7
                        ],
                        '105' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 7,
                            'y_end' => 9
                        ],
                        '106' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 9,
                            'y_end' => 11
                        ],
                        '107' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 11,
                            'y_end' => 13
                        ],
                        '108' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 13,
                            'y_end' => 15
                        ],
                        '109' => [
                            'locuri' => 1,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 15,
                            'y_end' => 17
                        ],
                        '115' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 5,
                            'y_end' => 7
                        ],
                        '114' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 7,
                            'y_end' => 9
                        ],
                        '113' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 9,
                            'y_end' => 11
                        ],
                        '112' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 11,
                            'y_end' => 13
                        ],
                        '111' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 13,
                            'y_end' => 15
                        ],
                        '110' => [
                            'locuri' => 1,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 15,
                            'y_end' => 17
                        ],
                        '116' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 3,
                            'y_end' => 5
                        ],
                        '117' => [
                            'locuri' => 1,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 1,
                            'y_end' => 3
                        ],
                    ]
                ],
                '2' => [
                    'x' => 8,
                    'y' => 17,
                    'camere' => [
                        '201' => [
                            'locuri' => 1,
                            'x_start' => 4,
                            'x_end' => 5,
                            'y_start' => 1,
                            'y_end' => 5
                        ],
                        '218' => [
                            'locuri' => 1,
                            'x_start' => 5,
                            'x_end' => 6,
                            'y_start' => 1,
                            'y_end' => 5
                        ],
                        '202' => [
                            'locuri' => 1,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 1,
                            'y_end' => 3
                        ],
                        '203' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 3,
                            'y_end' => 5
                        ],
                        '204' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 5,
                            'y_end' => 7
                        ],
                        '205' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 7,
                            'y_end' => 9
                        ],
                        '206' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 9,
                            'y_end' => 11
                        ],
                        '207' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 11,
                            'y_end' => 13
                        ],
                        '208' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 13,
                            'y_end' => 15
                        ],
                        '209' => [
                            'locuri' => 1,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 15,
                            'y_end' => 17
                        ],
                        '215' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 5,
                            'y_end' => 7
                        ],
                        '214' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 7,
                            'y_end' => 9
                        ],
                        '213' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 9,
                            'y_end' => 11
                        ],
                        '212' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 11,
                            'y_end' => 13
                        ],
                        '211' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 13,
                            'y_end' => 15
                        ],
                        '210' => [
                            'locuri' => 1,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 15,
                            'y_end' => 17
                        ],
                        '216' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 3,
                            'y_end' => 5
                        ],
                        '217' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 1,
                            'y_end' => 3
                        ],
                    ]
                ],
                '3' => [
                    'x' => 8,
                    'y' => 17,
                    'camere' => [
                        '301' => [
                            'locuri' => 1,
                            'x_start' => 4,
                            'x_end' => 5,
                            'y_start' => 1,
                            'y_end' => 5
                        ],
                        '318' => [
                            'locuri' => 1,
                            'x_start' => 5,
                            'x_end' => 6,
                            'y_start' => 1,
                            'y_end' => 5
                        ],
                        '302' => [
                            'locuri' => 1,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 1,
                            'y_end' => 3
                        ],
                        '303' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 3,
                            'y_end' => 5
                        ],
                        '304' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 5,
                            'y_end' => 7
                        ],
                        '305' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 7,
                            'y_end' => 9
                        ],
                        '306' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 9,
                            'y_end' => 11
                        ],
                        '307' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 11,
                            'y_end' => 13
                        ],
                        '308' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 13,
                            'y_end' => 15
                        ],
                        '309' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 15,
                            'y_end' => 17
                        ],
                        '315' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 5,
                            'y_end' => 7
                        ],
                        '314' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 7,
                            'y_end' => 9
                        ],
                        '313' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 9,
                            'y_end' => 11
                        ],
                        '312' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 11,
                            'y_end' => 13
                        ],
                        '311' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 13,
                            'y_end' => 15
                        ],
                        '310' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 15,
                            'y_end' => 17
                        ],
                        '316' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 3,
                            'y_end' => 5
                        ],
                        '317' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 1,
                            'y_end' => 3
                        ],
                    ]
                ],
                '4' => [
                    'x' => 8,
                    'y' => 17,
                    'camere' => [
                        '401' => [
                            'locuri' => 1,
                            'x_start' => 4,
                            'x_end' => 5,
                            'y_start' => 1,
                            'y_end' => 5
                        ],
                        '418' => [
                            'locuri' => 1,
                            'x_start' => 5,
                            'x_end' => 6,
                            'y_start' => 1,
                            'y_end' => 5
                        ],
                        '402' => [
                            'locuri' => 1,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 1,
                            'y_end' => 3
                        ],
                        '403' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 3,
                            'y_end' => 5
                        ],
                        '404' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 5,
                            'y_end' => 7
                        ],
                        '405' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 7,
                            'y_end' => 9
                        ],
                        '406' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 9,
                            'y_end' => 11
                        ],
                        '407' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 11,
                            'y_end' => 13
                        ],
                        '408' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 13,
                            'y_end' => 15
                        ],
                        '409' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 15,
                            'y_end' => 17
                        ],
                        '415' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 5,
                            'y_end' => 7
                        ],
                        '414' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 7,
                            'y_end' => 9
                        ],
                        '413' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 9,
                            'y_end' => 11
                        ],
                        '412' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 11,
                            'y_end' => 13
                        ],
                        '411' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 13,
                            'y_end' => 15
                        ],
                        '410' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 15,
                            'y_end' => 17
                        ],
                        '416' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 3,
                            'y_end' => 5
                        ],
                        '417' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 1,
                            'y_end' => 3
                        ],
                    ]
                ],
                '5' => [
                    'x' => 8,
                    'y' => 17,
                    'camere' => [
                        '501' => [
                            'locuri' => 1,
                            'x_start' => 4,
                            'x_end' => 5,
                            'y_start' => 1,
                            'y_end' => 5
                        ],
                        '518' => [
                            'locuri' => 1,
                            'x_start' => 5,
                            'x_end' => 6,
                            'y_start' => 1,
                            'y_end' => 5
                        ],
                        '502' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 1,
                            'y_end' => 3
                        ],
                        '503' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 3,
                            'y_end' => 5
                        ],
                        '504' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 5,
                            'y_end' => 7
                        ],
                        '505' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 7,
                            'y_end' => 9
                        ],
                        '506' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 9,
                            'y_end' => 11
                        ],
                        '507' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 11,
                            'y_end' => 13
                        ],
                        '508' => [
                            'locuri' => 2,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 13,
                            'y_end' => 15
                        ],
                        '509' => [
                            'locuri' => 1,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 15,
                            'y_end' => 17
                        ],
                        '515' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 5,
                            'y_end' => 7
                        ],
                        '514' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 7,
                            'y_end' => 9
                        ],
                        '513' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 9,
                            'y_end' => 11
                        ],
                        '512' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 11,
                            'y_end' => 13
                        ],
                        '511' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 13,
                            'y_end' => 15
                        ],
                        '510' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 15,
                            'y_end' => 17
                        ],
                        '516' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 3,
                            'y_end' => 5
                        ],
                        '517' => [
                            'locuri' => 2,
                            'x_start' => 6,
                            'x_end' => 9,
                            'y_start' => 1,
                            'y_end' => 3
                        ],
                    ]
                ],
                '6' => [
                    'x' => 6,
                    'y' => 21,
                    'camere' => [
                        '601' => [
                            'locuri' => 20,
                            'x_start' => 1,
                            'x_end' => 4,
                            'y_start' => 1,
                            'y_end' => 21
                        ],
                        '602' => [
                            'locuri' => 20,
                            'x_start' => 4,
                            'x_end' => 7,
                            'y_start' => 1,
                            'y_end' => 21
                        ]
                    ]
                ]
            ]
        ]
    ];

    public static function getStructure()
    {
        $ocupari = DB::select('select * from ocupare o join persoane p on p.id = o.persoana_id where o.perioada_start <= "' . session('ziuaCurenta') . '" and o.perioada_end >= "' . session('ziuaCurenta') . '";');

        $ocupareDb = [];
        foreach ($ocupari as $ocupare) {
            $ocupareDb[$ocupare->hotel_id][$ocupare->etaj_numar][$ocupare->camera_numar][] = $ocupare;
        }

        $hotels = [];
        foreach (self::$hoteluri as $hotelName => $hotelContent) {
            $hotelTotalLocuri = 0;
            $hotelOcupareLocuri = 0;
            $hotelOcupareLocuriGratuite = 0;
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
                                $ocupant->id,
                                $ocupant->nume,
                                $ocupant->prenume,
                                $ocupant->an_curs,
                                $ocupant->oras,
                                $ocupant->tara,
                                $ocupant->telefon,
                                $ocupant->premiu
                            ), $ocupant->loc, $ocupant->tip, $ocupant->achitat, $ocupant->perioada_start, $ocupant->perioada_end);

                            $hotelOcupareLocuri++;
                            if ($ocupant->tip == 'gratuit') {
                                $hotelOcupareLocuriGratuite++;
                            }
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
            $hotel->setOcupareLocuriGratuite($hotelOcupareLocuriGratuite);

            $hotels[$hotelContent['id']] = $hotel;
        }

        return $hotels;
    }

    static public function convertDBDateToHuman ($DBDate)
    {
        $parts = explode('-', $DBDate);
        if (count($parts) > 1) {
            return $parts[2] . '.' . $parts[1] . '.' . $parts[0];
        }

        return $DBDate;
    }

    static public function convertHumanDateToDB ($HumanDate)
    {
        $parts = explode('.', $HumanDate);
        if (count($parts) > 1) {
            return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }

        return $HumanDate;
    }
}
