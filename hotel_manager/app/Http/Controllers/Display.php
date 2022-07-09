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

        if (env('BACKUP_EXTERNAL') == 'true') {

            $backupFile = storage_path('logs/hoteluri_' . date("Y-m-d") . '.sql');
            if (!file_exists($backupFile)) {
                $command = "mysqldump --opt -h " . env('DB_HOST') . " -u " . env('DB_USERNAME') . " -p" . env('DB_PASSWORD') . " " . "hoteluri > $backupFile";
                exec($command);
            }

            $backupDBHdd = env('BACKUP_PATH') . '\hoteluri_' . date("Y-m-d") . '.sql';
            $backupLogsHdd = env('BACKUP_PATH') . '\actiuni.log';
            if (!is_dir(env('BACKUP_PATH'))) {
                mkdir(env('BACKUP_PATH'));
            }
            if (!file_exists($backupDBHdd) || !file_exists($backupLogsHdd)) {
                copy($backupFile, $backupDBHdd);
                copy(storage_path('logs/actiuni.log'), $backupLogsHdd);
            }
        }

        return view('display', [
            'hotels' => Data::getStructure(),
            'ziuaCurenta' => session('ziuaCurenta')
        ]);
    }
}
