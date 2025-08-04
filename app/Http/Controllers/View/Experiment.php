<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class Experiment extends Controller {
    //

    public function read_file_json_reactview(Request $request) {
        // $file = json_decode($fileContent, true);
        $file = file_get_contents(public_path('data.json'));
        // try {
        //     $fileContent = file_get_contents(public_path('data.json'));
        //     $file = json_decode($fileContent, true);
        //     if (json_last_error() !== JSON_ERROR_NONE) {
        //         throw new \Exception('Invalid JSON format');
        //     }
        // } catch (\Exception $e) {
        //     \Log::error('Error reading JSON file: ' . $e->getMessage());
        //     $file = null;
        // }

        return Inertia::render('1.experiments/read_file_json/page', [
            'file' => json_decode($file)
        ]);
    }
}
