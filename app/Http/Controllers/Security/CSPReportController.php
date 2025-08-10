<?php
// ! Copyright @ Syahri Ramadhan Wiraasmara (ARI), ariwiraasmara.sc37@gmail.com, +628176896353. Year 2025
// ! All Rights Reserved
namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Libraries\jsr;

class CSPReportController extends Controller {
    //
    public function store(Request $request) {
        if( !empty($request->all()) ) {
            $data = [
                'date' => date('Y-m-d H:i:s'),
                'ip' => $request->ip(),
                'url' => $request->url(),
                'method' => $request->method(),
                'headers' => $request->headers->all(),
                'body' => $request->all(),
                'user_agent' => $request->header('User-Agent'),
            ]; // Ambil raw JSON
            $timestamp = date('Y-m-d-His');
            $filename = "report_{$timestamp}_".Str::random(5).".json";
            try {
                Storage::disk('csp')->put($filename, json_encode($data, JSON_PRETTY_PRINT));
                return response()->json(['success' => true, 'message' => 'CSP report saved.']);
            } catch (\Exception $e) {
                Log::error('CSP Report Saving Error', ['error' => $e->getMessage()]);
                return response()->json(['success' => false, 'message' => 'Failed to save CSP report.'], 500);
            }
        }
        return null;
    }
}
