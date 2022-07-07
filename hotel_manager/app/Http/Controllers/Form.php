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
    public function getOcupare(Request $request)
    {
        $idData = explode('_', $request->input('id')); // hotel_etaj_camera_loc
        $hotels = Data::getStructure();
        $ocupantiCamera = $hotels[$idData[1]]->getEtaje()[$idData[2]]->getCamere()[$idData[3]]->getOcupanti();

        $ocupare = '';
        if (isset($ocupantiCamera[$idData[4]])) {
            $ocupare = $ocupantiCamera[$idData[4]];
        }

        return view('form-ajax', [
            'ocupare' => $ocupare,
            'hotel' => $idData[1],
            'etaj' => $idData[2],
            'camera' => $idData[3],
            'loc' => $idData[4],
            'dataCurenta' => Data::convertDBDateToHuman(session('ziuaCurenta'))
        ]);
    }

    public function salvareOcupare(Request $request)
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

        $ocupare["perioada_start"] = Data::convertHumanDateToDB($request->input('perioada_start'));
        $ocupare["perioada_end"] = Data::convertHumanDateToDB($request->input('perioada_end'));

        try {
            if ($ocupare['persoana_id'] == '') {

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
                    persoana_id = ?,
                    achitat = ?,
                    perioada_start = ?,
                    perioada_end = ?
                    where hotel_id = ? and
                    etaj_numar = ? and
                    camera_numar = ? and
                    loc = ?', [
                    $ocupare['tip'],
                    $ocupare['persoana_id'],
                    $ocupare['achitat'],
                    $ocupare['perioada_start'],
                    $ocupare['perioada_end'],
                    $ocupare['hotel'],
                    $ocupare['etaj'],
                    $ocupare['camera'],
                    $ocupare['loc']
                ]);
            }
        } catch (\Exception $e) {
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

            // șterge și persoana dacă nu mai are ocupări
            $alteocupariPersoana = DB::select('select * from ocupare where persoana_id = ?', [$ocupare['persoana_id']]);
            if (count($alteocupariPersoana) < 1) {
                DB::delete('delete from persoane
                    where id = ?', [
                    $ocupare['persoana_id']
                ]);
            }
        } catch (\Exception $e) {
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
}
