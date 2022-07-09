<?php

namespace App\Http\Controllers;

use App\Data;
use App\Http\Classes\Camera;
use App\Http\Classes\Etaj;
use App\Http\Classes\Hotel;
use App\Http\Classes\Ocupant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Form extends Controller
{
    public function getOcupare(Request $request)
    {
        $idData = explode('_', $request->input('id')); // hotel_etaj_camera_loc
        $hotels = session('structura');

        $structuraHotel = [];
        foreach ($hotels as $hotel) {
            foreach ($hotels[$hotel->getId()]->getEtaje() as $etaj) {
                foreach ($etaj->getCamere(0) as $camera) {
                    $structuraHotel[$hotel->getId()][$etaj->getNumar()][$camera->getNumar()] = $camera->getLocuri();
                }
            }
            foreach ($structuraHotel[$hotel->getId()] as $etajNumar => $etajUnsorted) {
                ksort($etajUnsorted);
                $structuraHotel[$hotel->getId()][$etajNumar] = $etajUnsorted;
            }
        }

        $camera = $hotels[$idData[1]]->getEtaje()[$idData[2]]->getCamere()[$idData[3]];
        $ocupantiCamera = $camera->getOcupanti();

        $ocupare = '';
        if (isset($ocupantiCamera[$idData[4]])) {
            $ocupare = $ocupantiCamera[$idData[4]];
        }

        $multiplSelections = 1;
        if (
            $camera->getLocuri() > 1 && // are mai mult de 1 loc
            $camera->getLocuri() - count($ocupantiCamera) > 1 && // are mai mult de 1 loc liber
            count($ocupantiCamera) == 0 && // e complet liberă
            $camera->getLocuri() < 4 // are mai puțin de 4 locuri
        ) {
            $multiplSelections = 2;
        }

        $poateLuaCamera = false;
        if (
            $camera->getLocuri() > 1 && // are mai mult de 1 loc
            $camera->getLocuri() - count($ocupantiCamera) > 0 && // are mai mult de 1 loc liber
            $camera->getLocuri() < 4 // are mai puțin de 4 locuri
        ) {
            $poateLuaCamera = true;
        }

        return view('form-ajax', [
            'structuraHotel' => $structuraHotel,
            'ocupare' => $ocupare,
            'hotel' => $idData[1],
            'etaj' => $idData[2],
            'camera' => $idData[3],
            'loc' => $idData[4],
            'dataCurenta' => Data::convertDBDateToHuman(session('ziuaCurenta')),
            'multipleSelections' => $multiplSelections,
            'poateLuaCamera' => $poateLuaCamera
        ]);
    }

    public function salvareOcupare(Request $request)
    {
        $structura = session('structura');

        $ocupare = [];
        $ocupare["persoana_id"] = $request->input('persoana_id');
        $ocupare["nume"] = $request->input('nume');
        $ocupare["prenume"] = $request->input('prenume');
        $ocupare["an_curs"] = $request->input('an_curs');
        $ocupare["oras"] = $request->input('oras');
        $ocupare["tara"] = $request->input('tara');
        $ocupare["telefon"] = $request->input('telefon');
        $ocupare["tip"] = $request->input('tip');
        $ocupare["hotel"] = $request->input('hotel');
        $ocupare["etaj"] = $request->input('etaj');
        $ocupare["camera"] = $request->input('camera');
        $ocupare["loc"] = $request->input('loc');
        $ocupare["achitat"] = $request->input('achitat');
        $ocupare["perioada_start"] = Data::convertHumanDateToDB($request->input('perioada_start'));
        $ocupare["perioada_end"] = Data::convertHumanDateToDB($request->input('perioada_end'));

        try {
            if ($ocupare['persoana_id'] == '') {
                // verificare loc liber
                $ocupareIntervalDB = DB::select('select * from ocupare where hotel_id = ? and
                            etaj_numar = ? and
                            camera_numar = ? and
                            loc = ? and
                            (perioada_start <= ? and perioada_end >= ?)', [
                    $ocupare['hotel'],
                    $ocupare['etaj'],
                    $ocupare['camera'],
                    $ocupare['loc'],
                    Data::convertHumanDateToDB($ocupare["perioada_end"]),
                    Data::convertHumanDateToDB($ocupare["perioada_start"])
                ]);

                if (count($ocupareIntervalDB) > 0) {
                    return json_encode([
                        'status' => 'failed',
                        'data' => 'Intervalul nu este liber!'
                    ]);
                }

                if ($ocupare['nume'] == '') {
                    return json_encode([
                        'status' => 'failed',
                        'data' => 'Numele trebuie completat'
                    ]);
                }

                DB::insert('insert into persoane (nume, prenume, an_curs, oras, tara, telefon) values(?, ?, ?, ?, ?, ?)', [
                    $ocupare['nume'],
                    $ocupare['prenume'],
                    $ocupare['an_curs'],
                    $ocupare['oras'],
                    $ocupare['tara'],
                    $ocupare['telefon']
                ]);
                $ocupare['persoana_id'] = DB::getPdo()->lastInsertId();

                if ($request->input('multipleSelection') == ''  || $request->input('multipleSelection') < 2) {
                    DB::insert('insert into ocupare (hotel_id, etaj_numar, camera_numar, loc, tip, persoana_id, achitat, perioada_start, perioada_end) values(?, ?, ?, ?, ?, ?, ? ,?, ?)', [
                        $ocupare['hotel'],
                        $ocupare['etaj'],
                        $ocupare['camera'],
                        $ocupare['loc'],
                        $ocupare['tip'],
                        $ocupare['persoana_id'],
                        $ocupare['achitat'],
                        $ocupare['perioada_start'],
                        $ocupare['perioada_end']
                    ]);
                } else {
                    for ($i = 0; $i < $structura[$ocupare['hotel']]->getEtaje()[$ocupare['etaj']]->getCamere()[$ocupare['camera']]->getLocuri(); $i++) {
                        DB::insert('insert into ocupare (hotel_id, etaj_numar, camera_numar, loc, tip, persoana_id, achitat, perioada_start, perioada_end) values(?, ?, ?, ?, ?, ?, ? ,?, ?)', [
                            $ocupare['hotel'],
                            $ocupare['etaj'],
                            $ocupare['camera'],
                            $i,
                            $ocupare['tip'],
                            $ocupare['persoana_id'],
                            $ocupare['achitat'],
                            $ocupare['perioada_start'],
                            $ocupare['perioada_end']
                        ]);
                    }
                }

                Log::channel('actiuni')->info('Creat ocupant nou', $ocupare);
            } else {
                // verificare loc liber
                $ocupareIntervalDB = DB::select('select * from ocupare where hotel_id = ? and
                            etaj_numar = ? and
                            camera_numar = ? and
                            loc = ? and
                            (perioada_start <= ? and perioada_end >= ?) and
                            persoana_id != ?', [
                    $ocupare['hotel'],
                    $ocupare['etaj'],
                    $ocupare['camera'],
                    $ocupare['loc'],
                    Data::convertHumanDateToDB($ocupare["perioada_end"]),
                    Data::convertHumanDateToDB($ocupare["perioada_start"]),
                    $ocupare['persoana_id']
                ]);

                if (count($ocupareIntervalDB) > 0) {
                    return json_encode([
                        'status' => 'failed',
                        'data' => 'Intervalul nu este liber!'
                    ]);
                }

                DB::update('update persoane set
                    nume = ?,
                    prenume = ?,
                    an_curs = ?,
                    oras = ?,
                    tara = ?,
                    telefon = ?
                    where id = ?', [
                    $ocupare['nume'],
                    $ocupare['prenume'],
                    $ocupare['an_curs'],
                    $ocupare['oras'],
                    $ocupare['tara'],
                    $ocupare['telefon'],
                    $ocupare['persoana_id']
                ]);

                DB::update('update ocupare set
                    tip = ?,
                    achitat = ?,
                    perioada_start = ?,
                    perioada_end = ?
                    where hotel_id = ? and
                    etaj_numar = ? and
                    camera_numar = ? and
                    loc = ? and
                    persoana_id = ?', [
                    $ocupare['tip'],
                    $ocupare['achitat'],
                    $ocupare['perioada_start'],
                    $ocupare['perioada_end'],
                    $ocupare['hotel'],
                    $ocupare['etaj'],
                    $ocupare['camera'],
                    $ocupare['loc'],
                    $ocupare['persoana_id']
                ]);

                Log::channel('actiuni')->info('Updatat ocupant', $ocupare);
            }
        } catch (\Exception $e) {
            Log::channel('actiuni')->info('ERROARE! Creat/updatat ocupant eșuată. ' . $e->getMessage(), $ocupare);

            return json_encode([
                'status' => 'failed',
                'data' => $e->getMessage()
            ]);
        };

        return json_encode([
            'status' => 'success',
            'data' => 1
        ]);
    }

    public function stergereOcupare(Request $request)
    {
        $ocupare = [];
        $ocupare["persoana_id"] = $request->input('persoana_id');
        $ocupare["hotel"] = $request->input('hotel');
        $ocupare["etaj"] = $request->input('etaj');
        $ocupare["camera"] = $request->input('camera');
        $ocupare["loc"] = $request->input('loc');

        if ($ocupare["persoana_id"] == '') {
            return json_encode([
                'status' => 'success',
                'data' => 1
            ]);
        }

        try {
            // șterge ocuparea
            DB::delete('delete from ocupare
                    where hotel_id = ? and
                    etaj_numar = ? and
                    camera_numar = ? and
                    loc = ?', [
                $ocupare['hotel'],
                $ocupare['etaj'],
                $ocupare['camera'],
                $ocupare['loc']
            ]);

            Log::channel('actiuni')->info('Ștergere ocupare', $ocupare);

            // șterge și persoana dacă nu mai are ocupări
            $alteocupariPersoana = DB::select('select * from ocupare where persoana_id = ?', [$ocupare['persoana_id']]);
            if (count($alteocupariPersoana) < 1) {
                DB::delete('delete from persoane
                    where id = ?', [
                    $ocupare['persoana_id']
                ]);

                Log::channel('actiuni')->info('Ștergere și persoană', $alteocupariPersoana);
            }

        } catch (\Exception $e) {
            Log::channel('actiuni')->info('ERROARE! Ștergere eșuată. ' . $e->getMessage(), $ocupare);

            return json_encode([
                'status' => 'failed',
                'data' => $e->getMessage()
            ]);
        };

        return json_encode([
            'status' => 'success',
            'data' => 1
        ]);
    }

    public function modificaZiuaCurenta(Request $request)
    {
        session(['ziuaCurenta' => $request->input('data')]);

        return true;
    }

    public function ocupaTot(Request $request)
    {
        $ocupare = [];
        $ocupare["persoana_id"] = $request->input('persoana_id');
        $ocupare["tip"] = $request->input('tip');
        $ocupare["hotel"] = $request->input('hotel');
        $ocupare["etaj"] = $request->input('etaj');
        $ocupare["camera"] = $request->input('camera');
        $ocupare["achitat"] = $request->input('achitat');
        $ocupare["perioada_start"] = Data::convertHumanDateToDB($request->input('perioada_start'));
        $ocupare["perioada_end"] = Data::convertHumanDateToDB($request->input('perioada_end'));

        try {
            $ocupariDB = DB::select('select * from ocupare where hotel_id = ? and etaj_numar = ? and camera_numar = ?', [
                $ocupare['hotel'],
                $ocupare['etaj'],
                $ocupare['camera']
            ]);

            $locuriOcupate = [];
            foreach ($ocupariDB as $ocupareDB) {
                $locuriOcupate[] = $ocupareDB->loc;
            }

            $structura = session('structura');

            $camera = $structura[$ocupare['hotel']]->getEtaje()[$ocupare['etaj']]->getCamere()[$ocupare['camera']];

            for ($i = 0; $i < $camera->getLocuri(); $i++) {
                if (!in_array($i, $locuriOcupate)) {
                    DB::insert('insert into ocupare (hotel_id, etaj_numar, camera_numar, loc, tip, persoana_id, achitat, perioada_start, perioada_end) values(?, ?, ?, ?, ?, ?, ? ,?, ?)', [
                        $ocupare['hotel'],
                        $ocupare['etaj'],
                        $ocupare['camera'],
                        $i,
                        $ocupare['tip'],
                        $ocupare['persoana_id'],
                        $ocupare['achitat'],
                        $ocupare['perioada_start'],
                        $ocupare['perioada_end']
                    ]);
                }
            }

            Log::channel('actiuni')->info('Ocupare totală', $ocupare);
        } catch (\Exception $e) {
            Log::channel('actiuni')->info('ERROARE! Ocupare totală eșuată. ' . $e->getMessage(), $ocupare);

            return json_encode([
                'status' => 'failed',
                'data' => $e->getMessage()
            ]);
        }

        return json_encode([
            'status' => 'success',
            'data' => 1
        ]);
    }

    public function getDateRangeLoc(Request $request)
    {
        $locParts = explode('_', $request->input('id'));
        $hotel = $locParts[1];
        $etaj = $locParts[2];
        $camera = $locParts[3];
        $loc = $locParts[4];

        try {
            $ocupariDB = DB::select('select * from ocupare where hotel_id = ? and etaj_numar = ? and camera_numar = ? and loc = ?', [
                $hotel,
                $etaj,
                $camera,
                $loc
            ]);

            $zileOcupate = [];
            foreach ($ocupariDB as $ocupareDB) {
                $perioada = new \DatePeriod(
                    new \DateTime($ocupareDB->perioada_start),
                    new \DateInterval('P1D'),
                    new \DateTime($ocupareDB->perioada_end .  ' 23:59:59')
                );

                foreach ($perioada as $zi) {
                    $zileOcupate[] = $zi->format('d.m.Y');
                }
            }
        } catch (\Exception $e) {
            $zileOcupate = [];
        }
        return $zileOcupate;
    }

    public function muta(Request $request)
    {
        $ocupare = [];
        $ocupare["persoana_id"] = $request->input('persoana_id');
        $ocupare["nume"] = $request->input('nume');
        $ocupare["prenume"] = $request->input('prenume');
        $ocupare["an_curs"] = $request->input('an_curs');
        $ocupare["oras"] = $request->input('oras');
        $ocupare["tara"] = $request->input('tara');
        $ocupare["telefon"] = $request->input('telefon');
        $ocupare["tip"] = $request->input('tip');
        $ocupare["hotel"] = $request->input('hotel');
        $ocupare["etaj"] = $request->input('etaj');
        $ocupare["camera"] = $request->input('camera');
        $ocupare["loc"] = $request->input('loc');
        $ocupare["achitat"] = $request->input('achitat');
        $ocupare["muta-etaje"] = $request->input('muta-etaje');
        $ocupare["muta-camere"] = $request->input('muta-camere');
        $ocupare["muta-locuri"] = $request->input('muta-locuri');
        $ocupare["perioada_start"] = Data::convertHumanDateToDB($request->input('perioada_start'));
        $ocupare["perioada_end"] = Data::convertHumanDateToDB($request->input('perioada_end'));

        try {
            // verificare loc liber
            $ocupareIntervalDB = DB::select('select * from ocupare where hotel_id = ? and
                            etaj_numar = ? and
                            camera_numar = ? and
                            loc = ? and
                            (perioada_start <= ? and perioada_end >= ?) and
                            persoana_id != ?', [
                $ocupare['hotel'],
                $ocupare['muta-etaje'],
                $ocupare['muta-camere'],
                $ocupare['muta-locuri'],
                $ocupare["perioada_end"],
                $ocupare["perioada_start"],
                $ocupare['persoana_id']
            ]);

            if (count($ocupareIntervalDB) > 0) {
                return json_encode([
                    'status' => 'failed',
                    'data' => 'Intervalul nu este liber!'
                ]);
            }

            DB::update('update persoane set
                    nume = ?,
                    prenume = ?,
                    an_curs = ?,
                    oras = ?,
                    tara = ?,
                    telefon = ?
                    where id = ?', [
                $ocupare['nume'],
                $ocupare['prenume'],
                $ocupare['an_curs'],
                $ocupare['oras'],
                $ocupare['tara'],
                $ocupare['telefon'],
                $ocupare['persoana_id']
            ]);

            DB::update('update ocupare set
                    tip = ?,
                    achitat = ?,
                    perioada_start = ?,
                    perioada_end = ?,
                    etaj_numar = ?,
                    camera_numar = ?,
                    loc = ?
                    where hotel_id = ? and
                    etaj_numar = ? and
                    camera_numar = ? and
                    loc = ? and
                    persoana_id = ?', [
                $ocupare['tip'],
                $ocupare['achitat'],
                $ocupare['perioada_start'],
                $ocupare['perioada_end'],
                $ocupare['muta-etaje'],
                $ocupare['muta-camere'],
                $ocupare['muta-locuri'],
                $ocupare['hotel'],
                $ocupare['etaj'],
                $ocupare['camera'],
                $ocupare['loc'],
                $ocupare['persoana_id']
            ]);

            Log::channel('actiuni')->info('Mutare ocupare (si posibil update)', $ocupare);
        } catch (\Exception $e) {
            Log::channel('actiuni')->info('ERROARE! Mutare eșuată. ' . $e->getMessage(), $ocupare);

            return json_encode([
                'status' => 'failed',
                'data' => $e->getMessage()
            ]);
        }

        return json_encode([
            'status' => 'success',
            'data' => 1
        ]);
    }

    public function exportaZiua(Request $request)
    {
        $ocupari = DB::select('select * from ocupare o join persoane p on p.id = o.persoana_id where o.perioada_start <= "' . session('ziuaCurenta') . '" and o.perioada_end >= "' . session('ziuaCurenta') . '";');

        $ocupariArray = array_map(function ($value) {
            return (array)$value;
        }, $ocupari);

        $filename = storage_path('logs/exporta_ziua.csv');
        $handle = fopen($filename, 'w+');

        if (count($ocupariArray) > 0) {
            fputcsv($handle, array_keys($ocupariArray[0]));
        }

        foreach($ocupariArray as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return response()->download($filename, 'export.csv', $headers);
    }
}
