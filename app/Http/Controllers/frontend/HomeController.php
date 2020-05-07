<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Checkers\Prepostseo;
use Nathanmac\Utilities\Parser\Parser;


class HomeController extends Controller
{
    // 
    public function index()
    {
        return view('frontend.landing.index');
    }

    public function faq()
    {
        return view('frontend.landing.faq');
    }

    public function plag_checkprice()
    {
        return view('frontend.landing.plag_checkprice');
    }

    public function test()
    {
        // $checker = new CheckerThread('test');   
        // $checker -> start();
        // $prepostseo = new Prepostseo();

        // $exampletext='We hold these truths to be self-evident, that all men are created equal, that they are endowed by their '.
		// 	'Creator with certain unalienable rights, that among these are Life, Liberty, and the pursuit of Happiness. That to '.
        //     'secure these rights, Governments are instituted among Men, deriving their just powers from the consent of the ';
            
        //  $result = $prepostseo -> doAnalysis($exampletext);
         
        //  var_dump($result);
        echo rand(-3, 0);
    }

}
