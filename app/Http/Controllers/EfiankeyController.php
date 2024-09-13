<?php

namespace App\Http\Controllers;
use App\Http\Middleware\CheckDownloadRestriction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class EfiankeyController extends Controller
{
    public function __construct()
    {
        // Apply the middleware to the `download` method
        $this->middleware(CheckDownloadRestriction::class)->only('getImage');
    }
    public function viewHomePage()
    {
        session_start();
        $_SESSION['member'] = "false";
        
        return view('Efiankey', ['message' => $_SESSION['member'], 'message2' => "asd" ]);  
    }
    public function checkDownload()
    {
        if ($this->checktime()) {
            return true;
        }

        // Check if the member is allowed and the number of attempts is less than 1
        if (isset($_SESSION['member']) && $_SESSION['member'] && $_SESSION['attempt'] < 1) {
            return true;
        }

        // Otherwise, restrict the download
        return false;
    }

    public function getImage($filename)
    {
        
        session(['last_download_time' => now()->timestamp]);
        $filePath = public_path('logo/'.$filename);
        $headers = array(
            'Content-Type: application/pdf',
          );
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
    
        return abort(404); // Handle file not found
        // return view('Efiankey', ['message' => "123", 'message2' => "asd" ]);  
        
    }

    public function registerMember(){
        $_SESSION['member'] = true;
    }
    public function logout(){
        $_SESSION['member'] = false;
    }

}
