<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class PagesController extends Controller
{
    public function index(){

        $message = "Someone Access!";

        Log::emergency($message);
        Log::alert($message);
        Log::critical($message);
        Log::error($message);
        Log::warning($message);
        Log::notice($message);
        Log::info($message);
        Log::debug($message);
        return ('Down for Maintenance');
    }

    public function maintenance(){
        return "Down for Maintenance";
    }
}
