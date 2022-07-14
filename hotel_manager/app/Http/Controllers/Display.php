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

        $backupFile = storage_path('backups\database.sqlite');
        if (!is_dir(storage_path('backups'))) {
            mkdir(storage_path('backups'));
        }

        copy(env('DB_DATABASE'), $backupFile);

        if (env('BACKUP_EXTERNAL') == 'true') {
            $backupDBHdd = env('BACKUP_PATH') . '\database_' . date("Y-m-d") . '.sqlite';
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
