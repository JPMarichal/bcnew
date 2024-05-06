<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class NotionImportController extends Controller
{
    public function import()
    {
        Artisan::call('posts:import-notion');
        return response()->json(['message' => 'Import process has been started.']);
    }
}