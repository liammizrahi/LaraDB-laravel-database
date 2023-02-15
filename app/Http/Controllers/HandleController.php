<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Database;

class HandleController extends Controller
{
    public function test(Request $request) {
        $database = new Database();

        $database->createTable('users', ['id', 'username', 'first_name', 'last_name']);

        // Because we may run this script many times, we need to drop the table first to prevent duplicate data
        $database->dropTable('users');

        $database->insert('users', [
            'id' => 1,
            'username' => 'lmr',
            'first_name' => 'Rafael',
            'last_name' => 'Mor'
        ]);

        $database->insert('users', [
            'id' => 2,
            'username' => 'dikla96',
            'first_name' => 'Dikla',
            'last_name' => 'Cohen'
        ]);

        $database->update('users', 0, [
            'username' => 'raf88',
        ]);

        dd($database->exportTableByColumns('users', ['id', 'username']));
    }
}
