<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Projects;


class ApiController extends Controller
{
    //
    public function payment_list(Request $request)
    {

        $count = 10;
        if(isset($request -> list_count))
            $count = $request -> list_count;
        $payment_entry = Payment::select('project_token', 'trans_id', 'method', 'amount', 'currency', 'status', 'decline_reason', 'updated_at')
                        -> orderBy('updated_at', 'DESC')
                        -> limit($count)
                        -> get();
        if(isset($payment_entry))
        {
            for($index = 0; $index < count($payment_entry); $index ++){

                $project_entry = Projects :: where("project_token", $payment_entry[$index] -> project_token) -> first();
                $payment_entry[$index] -> email = null;
                if(isset($project_entry))
                {
                    $payment_entry[$index] -> email = $project_entry -> email;
                }
            }
            
        }

        return response()->json([
            'entry' => $payment_entry
        ]);
    }



}
