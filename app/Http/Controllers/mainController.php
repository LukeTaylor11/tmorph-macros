<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class mainController extends Controller
{
    public function index(){
        return view('index');
    }
}
