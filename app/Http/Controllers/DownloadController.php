<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DownloadController extends Controller
{
    public function downloadBackup(Request $request)
    {
        // Only authenticated users can download backups
        if (! Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $token = $request->get('token');

        // Retrieve the file path from cache using the token
        $cachedData = Cache::get('backup_download_'.$token);

        // Check if the token exists in cache
        if (! $cachedData) {
            abort(404, 'File not found');
        }

        // Delete the token after retrieving it (one-time use)
        Cache::forget('backup_download_'.$token);

        $filePath = $cachedData['file_path'];

        // Validate the file path to prevent directory traversal attacks
        if (! $filePath || ! str_starts_with(realpath($filePath) ?: $filePath, realpath(storage_path('app/private')))) {
            abort(404, 'File not found');
        }

        // Additional security check - make sure it's a backup file
        $realPath = realpath($filePath);
        if (! $realPath || ! str_contains($realPath, '人民发艺') || ! str_ends_with($realPath, '.zip')) {
            abort(404, 'File not found');
        }

        if (! file_exists($realPath)) {
            abort(404, 'File not found');
        }

        return response()->download($realPath);
    }
}
