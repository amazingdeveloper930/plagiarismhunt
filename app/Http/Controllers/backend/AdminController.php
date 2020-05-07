<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Setting;
use App\Payment;
use App\Projects;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $verified_users = Projects::where('verified', 1)->get();
        $count_verified_users = count($verified_users);
        $total_payment = Payment::where('status', 'Payment Received')->sum('amount');
        $detailed_report_payment = Payment::where('status', 'Payment Received')->where('mode', 1)->sum('amount');
        $check_other_all = Payment::where('status', 'Payment Received')->where('mode', 2)->sum('amount');
        $check_count_list = [];
        for($index = 0; $index <= 20; $index ++)
        {
            $date = strtotime(date("Y-m-d", strtotime( ($index - 20) . " day"))) * 1000;
            $check_per_day = Projects::whereDate('created_at', '=', date("Y-m-d", strtotime( ($index - 20) . " day"))) 
                                        -> where('type', 'file')
                                        -> where('verified', 1) ->get();
            $count_check_per_day = count($check_per_day);
            $check_count_list []= [$date, $count_check_per_day];
        }

        $data = [
            'count_verified_users' => $count_verified_users,
            'total_payment' => $total_payment,
            'detailed_report_payment' => $detailed_report_payment,
            'check_other_all' => $check_other_all,
            'check_count_list' => $check_count_list,
        ];
        return view('backend.index', $data);
    }
    public function setting()
    {
        $settings = Setting::where('active', 1)->get();
        return view('backend.setting', ['settingvalues' => $settings]);
    }
    
    public function setSetting(Request $request)
    {
        $setttingValues = $request -> settingvalues;
        foreach ($setttingValues as $key => $value) {
            # code...
            $setting = Setting::where('key' , $key)->first();
            $setting -> value = $value;
            $setting -> save();
            
        }
        return redirect()->route('admin.setting');
    }

    public function payrecord()
    {
        $verified_users = Projects::where('verified', 1)->get();
        $count_verified_users = count($verified_users);
        $total_payment = Payment::where('status', 'Payment Received')->sum('amount');
        $detailed_report_payment = Payment::where('status', 'Payment Received')->where('mode', 1)->sum('amount');
        $check_other_all = Payment::where('status', 'Payment Received')->where('mode', 2)->sum('amount');
        $entry_payment = Payment::where('status', 'Payment Received')->get();
        // $entry_payment = Payment::all();
        $data = [
            'count_verified_users' => $count_verified_users,
            'total_payment' => $total_payment,
            'detailed_report_payment' => $detailed_report_payment,
            'check_other_all' => $check_other_all,
            'entry_payment' => $entry_payment
        ];
        return view('backend.payrecord', $data);
    }
/*
<script lang="javascript">
    var plag1_api_url = $("#plag1_api_url").val();
    $.ajax({
      type:'post',
      dataType: "json",
      url: plag1_api_url,
      data:{
        list_count: 10
          },
      success: function(response){
          alert(response);
      },
      error: function(jqXhr, textStatus, errorThrown) {
          alert('error
          ');
      }
    });
</script>
*/
    public function payrecord_global()
    {
        $data = ['list_count' => 10];
        $plag1_result = json_decode($this -> CallAPI('POST', 'https://plagiarismchecker.eu/api/v1/payment_list', $data), true);
        $plaglt_result = json_decode($this -> CallAPI('POST', 'https://plagiatas.lt/api/v1/payment_list', $data), true);
        $plaghunt_result = json_decode($this -> CallAPI('POST', 'https://plagiarismhunt.com/api/v1/payment_list', $data), true);
        $pollanimal_result = json_decode($this -> CallAPI('POST', 'https://pollanimal.com/api/v1/payment_list', $data), true);
        

        $result = [
            'plag1_result' => $plag1_result,
            'plaglt_result' => $plaglt_result,
            'plaghunt_result' => $plaghunt_result,
            'pollanimal_result' => $pollanimal_result
        ];
        return view('backend.payrecord_global', $result);
    }


    public function activity()
    {
        $plag1_result = json_decode($this -> CallAPI('POST', 'https://plagiarismchecker.eu/api/v1/activity_list', null), true);
        $activity_data = $plag1_result['entry'];

        $check_count_list = [];
        for($index = 0; $index <= 30; $index ++)
        {
            $date = strtotime(date("Y-m-d", strtotime( ($index - 30) . " day"))) * 1000;

            $date_text = date("Y-m-d", strtotime( ($index - 30) . " day"));
            $count_check_per_day = 0;
            foreach ($activity_data as $value) {
                # code...
                if($date_text == $value['dateData'])
                {
                    $count_check_per_day = $value['checkCount'];
                    break;
                }
            }
            $check_count_list []= [$date, (int)$count_check_per_day];
        }
        //var_dump($check_count_list);
        $data = [
            'check_count_list' => $check_count_list,
        ];

        return view('backend.activity', $data);
    }

    public function counter_stats()
    {
        $plag1_result = json_decode($this -> CallAPI('POST', 'https://plagiarismchecker.eu/api/v1/counter_list', null), true);
        $counter_data = $plag1_result['entry'];

        
        // //var_dump($check_count_list);
        $data = [
            'counter_list' => $counter_data,
        ];

        return view('backend.counter_stats', $data);
    }

    public function logout()
    {
    	Auth::logout(); // log the user out of our application
        return redirect('admin/login'); // redirect the user to the login screen
    }

    public function CallAPI($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }


    
}
