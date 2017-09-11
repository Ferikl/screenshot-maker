<?php

namespace App\Http\Controllers;


use App\Helpers\ScreenshotMaker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class ScreenMakerController extends Controller
{
    public function index()
    {
        return view('index');
    }
    
    public function makeScreenshot(Request $request)
    {
        
        $siteUrl = $request->url;
        
        $validator = Validator::make(
            ['siteUrl' => $siteUrl],
            ['siteUrl' => 'required|url']
        );
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => 'Data validation failed. ' . $validator->errors()
            ]);
        }
        
        try {
            
            $date = Carbon::now();
            $imageName = md5($date . $siteUrl) . '.png';
            
            $data = [
                'siteUrl' => $siteUrl,
                'filePath' => storage_path('app/public/' . $imageName),
            ];
            
            $screenshotter = new ScreenshotMaker();
            $screenshotter->CreateSiteScreenshot($data);
            
            $result = [
                'date' => $date,
                'view_link' => '/storage/' . $imageName,
                'download_link' => env('APP_URL') . '/download?path=' . $imageName,
            ];
            
            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'success' => false
            ]);
        }
    }
    
    public function downloadFile(Request $request)
    {
        $filePath = storage_path('app/public/') . $request->path;
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}