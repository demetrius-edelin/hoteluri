<?php

namespace App\Http\Controllers;

use App\Data;

class Display extends Controller
{
    public function show()
    {
        if (session('ziuaCurenta') == '') {
            session(['ziuaCurenta' => date('Y-m-d')]);
        }

        $backupFile = storage_path('logs\hoteluri_' . date("Y-m-d") . '.sql');
        if (!file_exists($backupFile)) {
            $command = "mysqldump --opt -h " . env('DB_HOST') . " -u " . env('DB_USERNAME') . " -p" . env('DB_PASSWORD') . " hoteluri > $backupFile";
            exec($command);
        }

        if (env('BACKUP_EXTERNAL') == 'true') {
            $backupDBHdd = env('BACKUP_PATH') . '\hoteluri_' . date("Y-m-d") . '.sql';
            $backupDBCsvHdd = env('BACKUP_PATH') . '\exporta_ziua_' . date("Y-m-d") . '.csv';
            $backupLogsHdd = env('BACKUP_PATH') . '\actiuni.log';

            if (!is_dir(env('BACKUP_PATH'))) {
                mkdir(env('BACKUP_PATH'));
            }
            if (!file_exists($backupDBHdd)) {
                copy($backupFile, $backupDBHdd);
            }
            if (!file_exists($backupDBCsvHdd)) {
                copy(storage_path('logs\exporta_ziua_' . date("Y-m-d") . '.csv'), $backupDBCsvHdd);
            }
            if (!file_exists($backupLogsHdd)) {
                copy(storage_path('logs\actiuni.log'), $backupLogsHdd);
            }
        }

        session(['structura' => Data::getStructure()]);

        return view('display', [
            'hotels' => session('structura'),
            'ziuaCurenta' => session('ziuaCurenta')
        ]);
    }
}
