<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class SitemapController extends Controller
{
    // 
    public function index()
    {
        return response()->view('sitemap')->header('Content-Type', 'text/xml');;
    }

}
