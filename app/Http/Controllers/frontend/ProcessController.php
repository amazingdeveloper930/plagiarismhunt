<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use App\Projects;
use App\Method;
use App\Processing;
use App\Setting;

use Storage;
use Validator;
use PDF;
use App\Services\FileUtil;

use App\Http\Checkers\Copyscape;
use App\Http\Checkers\CheckerPlagiarism;
use App\Http\Checkers\Prepostseo;

use Nathanmac\Utilities\Parser\Parser;


class ProcessController extends Controller
{
    public function set_email($email, $token)
    {
        if(isset($email) && isset($token))
        {
            $entry = Projects::where('project_token', $token)->first();
            if(isset($entry))
            {
                $entry -> email = $email;
                $entry -> save();

                $verified_url = route('email_verify', ['email' => $email, 'token' => $token]);
                $data = ['url' => $verified_url];
                $subject = 'Plagiarismhunt Mail';
                // Mail::send('email.email_verify',$data, function ($message) use($email, $subject)
                // {
                //     $message->from('noreply@plagiarismhunt.com', 'Plagiarismhunt.com');
                //     $message->to($email);
                //     $message->subject($subject);
                // }); 
                return response()->json(['status'=>'success', 'url'=>$verified_url]);
            }
            else {
                # code...
                return response()->json(['status'=>'error', 'error_code' => 'There is no such project']);
            }
        }
        else {
            # code...
            return response()->json(['status'=>'error', 'error_code' => 'There is no email or project token']);
        }
    }

    public function destroy($token)
    {
        $del = Projects::where('project_token', $token) -> first();
        if(isset($del)){
            if($del -> type == 'file'){
                Storage::delete($token.$del->uploaded_data);
            }
            Processing::where('project_id', $del -> project_id)->delete();
            $del->delete();
            return response()->json(['status'=>'success', 'data' => 'file successfully deleted']);
        }
        else
        return response()->json(['status'=>'error', 'error_code' => 'There is no such project']);
       
    }

    
    //
    public function check_text(Request $request)
    {   

        $validator = Validator::make($request->all(), [
            'sample_text' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect() -> route('home');
        }
        $entry = new Projects();
        $entry -> project_token = Str::random(30);
        $entry -> data = $request -> sample_text;
        if(strlen($entry -> data) > 10)
            $entry -> uploaded_data = substr($entry -> data, 0, 10) . "...";
        else {
            # code...
            $entry -> uploaded_data = $entry -> data;
        }
        $entry -> type = "text";
        $entry -> save();

        $method_list = Method::all();
        foreach ($method_list as $method) {
            # code...
            $process_entry = new Processing();
            $process_entry -> project_id = $entry -> project_id;
            $process_entry -> processing_token = Str::random(30);
            $process_entry -> method_id = $method -> method_id;
            $process_entry -> status = 0;
            $process_entry -> markable = $method -> isfree;
            $process_entry -> detailshowable = 0;
            $process_entry -> mark = 0;
            $process_entry -> save();
        }
        return redirect()->route('project', ['token' => $entry -> project_token]);
        
    }

    public function check_file(Request $request)
    {
        /*

        This is for deleting original file
        */


        $old_entry = Projects::all();
        foreach ($old_entry as $old_project) {
            # code...
            $date1 = strtotime($old_project -> updated_at);  
            $date2 = strtotime(date("Y-m-d h:m:s")); 
            $diff = abs($date2 - $date1);
            if($diff / (60 * 60) > 3)
            {
                if($old_project -> type == 'file'){
                    Storage::delete($old_project ->project_token .$old_project->uploaded_data);
                }
            }
        }

        $files = $request -> file('file');
        if(!empty($files))
        {
            $returndata = array();
            $project_id = '';
            foreach($files as $file) {
                $entry = new Projects();
                $entry -> project_token = Str::random(30);
                $entry -> uploaded_data = $file -> getClientOriginalName();
                $entry -> type = "file";
                $entry -> save();
                $project_token = $entry -> project_token;
                Storage::put($entry -> project_token . $file->getClientOriginalName(), file_get_contents($file));
                $file_data = FileUtil::read_docx($entry -> project_token . $file->getClientOriginalName(), file_get_contents($file));
                $entry -> data = $file_data;
                $entry -> save();

            }
              
                
            return response()->json(['status'=>'success', 'token'=>$project_token]);
        }
        return response()->json(['status'=>'error', 'error_code' => 'There is no file']);
    }

    public function check_googledoc()
    {

    }

    public function project($token)
    {
       $entry = Projects::where('project_token', $token)->first();
       
       if(isset($entry))
       {
        if($entry -> type == 'text' || $entry -> verified)
        {
            $process_entry = Processing::where('project_id', $entry->project_id)->get();
            $price_open_report = Setting::getRecordByKey('price_open_report') -> value;
            $price_check_all = Setting::getRecordByKey('price_check_all') -> value;
            $data = [
                'project' => $entry,
                'processes' => $process_entry,
                'price_open_report' => $price_open_report,
                'price_check_all' => $price_check_all,
            ];
            // var_dump($process_entry);
            return view('frontend.process.project', $data);
        }
          
        else{
            return redirect()->route('home');
          }

       }
       else {
           # code...
           abort(404);
       }
        
    }
    public function verify($email, $token)
    {
        $entry = Projects::where(['email' => $email, 'project_token' => $token])->first();
        if(isset($entry))
        {
            if( $entry -> verified == true)
            {
                return redirect()->route('project', ['token' => $token]);
            }
            $entry -> verified = true;
            $entry -> save();
            $method_list = Method::all();
            foreach ($method_list as $method) {
                # code...
                $process_entry = new Processing();
                $process_entry -> project_id = $entry -> project_id;
                $process_entry -> processing_token = Str::random(30);
                $process_entry -> method_id = $method -> method_id;
                $process_entry -> status = 0;
                $process_entry -> markable = $method -> isfree;
                $process_entry -> save();
            }
            return redirect()->route('project', ['token' => $token]);
        }
        else {
            return redirect()->route('home');
        }
    }

    public function set_verify($email, $token)
    {
        $entry = Projects::where(['project_token' => $token])->first();
        if(isset($entry))
        {
            $entry -> email = $email;
            if( $entry -> verified == true)
            {
                return redirect()->route('project', ['token' => $token]);
            }
            $entry -> verified = true;
            $entry -> save();
            $method_list = Method::all();
            foreach ($method_list as $method) {
                # code...
                $process_entry = new Processing();
                $process_entry -> project_id = $entry -> project_id;
                $process_entry -> processing_token = Str::random(30);
                $process_entry -> method_id = $method -> method_id;
                $process_entry -> status = 0;
                $process_entry -> markable = $method -> isfree;
                $process_entry -> save();
            }
            $verified_url = route('email_verify', ['email' => $email, 'token' => $token]);
            $data = ['url' => $verified_url];
            $subject = 'Plagiarismhunt Mail';
            Mail::send('email.email_verify',$data, function ($message) use($email, $subject)
                {
                    $message->from('noreply@plagiarismhunt.com', 'Plagiarismhunt.com');
                    $message->to($email);
                    $message->subject($subject);
                });
            return redirect()->route('project', ['token' => $token]);
        }
        else {
            return redirect()->route('home');
        }
    }

    public function status($token)
    {
        $entry = Projects::where(['project_token' => $token])->first();
        if( isset($entry) )
        {
            $processes = Processing::where('project_id', $entry->project_id)->get();
            $data = [
                'project' => $entry,
                'processes' => $processes
            ];
            return response()->json(['status'=>'success', 'data' => $data]);
        }
        else {
            # code...
            return response()->json(['status'=>'error', 'error_code' => 'There is no project. <br/> Please contact with support team']);
        }
    }

    public function doAnalysis($token_project, $token_process)
    {   
        set_time_limit(600);
        $project_token = $token_project;
        $process_token = $token_process;
        $process_entry = Processing::where(['processing_token' => $process_token])->first();
        $project_entry = Projects::where(['project_token' => $project_token])->first();
        
        if( isset($project_entry) )
        {
            if( !(isset($process_entry)))
            {
                return response()->json(['status'=>'error', 'error_code' => 'There is no such process']);
            }
            if($process_entry -> status == 1){
                return response()->json(['status'=>'error', 'error_code' => 'Your paper is under inspection.']);
            }

            if($process_entry -> markable == 0)
                return response()->json(['status'=>'error', 'error_code' => 'To open this checker, you should unlock all checker']);

            if($process_entry -> status == 2)
            {
                $saved_data = unserialize($process_entry -> result_data);
                return response()->json(['status'=>'success', 'data' => $saved_data['result_data'], 'score' => $process_entry -> mark, 'references' => $saved_data['match_url']]);
            }
            // $entry -> status = 2;
            // $entry -> mark = 0;
            # delete Result file
            # end

            if(!($process_entry -> method -> isactive))
            {
                return response()->json(['status'=>'error', 'error_code' => 'This method is not yet actived']);
            }
           
            $process_entry -> status = 1;
            $process_entry -> save();
            
            if($process_entry -> method_id == 1)
            {
                $file_data = $project_entry -> data;
                $text = explode(' ', $file_data);


                $id = date('YmdHis') . $process_entry -> method_id;

                $postfields = array(
				    'controller' => 'plagapi',
				    'action' => 'upload',
				    'apikey' => env('PLAGIARISM_APIKEY'),
				    'id' => $id,
				    'text' => $text,
                );
                // var_dump($text);
                try {
				    $result = FileUtil::sendRequest(env('PLAGIARISM_APIURL'), $postfields);
				} catch (\Exception $e) {
				    // echo 'ERROR '.$e->getMessage()."\n";
				    // echo "<br/>";
                    $process_entry -> status = 3;
                    $process_entry -> save();
                    die("upload error\n");
				}

				$token = $result;
                $result = false;
                
                
				for($i = 0; $i < 100000; $i++) :
				    $postfields = array(
				        'controller' => 'plagapi',
				        'action' => 'getresults',
				        'apikey' => env('PLAGIARISM_APIKEY'),
				        'id' => $id,
				        'full' => true,
				    );

				    try {
				        $result = FileUtil::sendRequest(env('PLAGIARISM_APIURL'), $postfields);
				    } catch (\Exception $e) {
				        // echo $token.' ERROR '.$e->getMessage()."\n";
				        // echo "<br/>";
				    }
                    if($result) :

				        $data = $result;

				        $mergedclusters = $data['clusters'];
				        $markedtiles = $data['text'];
				        $references = $data['references'];

				        $postfields = array(
				            'controller' => 'plagapi',
				            'action' => 'getscores',
				            'apikey' => env('PLAGIARISM_APIKEY'),
				            'id' => $id,
				        );

				        try {
				            $result = FileUtil::sendRequest(env('PLAGIARISM_APIURL'), $postfields);
				        } catch (\Exception $e) {
				            // echo 'ERROR '.$e->getMessage()."\n";
				            // echo "<br/>";
                        }
                        
                    $iverciai = array(
                        'similarities' => $result['matches'],
                        'paraphrasing' => $result['paraphrasing'],
                        'score' => $result['score'],
                        'score_strict' => $result['strict'],
                        'score_citing' => $result['citing'],
                        'score_bad_citing' => $result['badciting'],
                        'longest_cluster' => $result['maxclusterlen'],
                        'concentration' => $result['concentration'],
                    );


                    $result_raw_text_array = array();
                    $temp_string = '';
                    $temp_cluster_id = -1;
                    $index = 0;
                    
                    for(; $index < count($markedtiles) ; $index ++)
				        {
				        	$temp_word = $markedtiles[$index];
				        	$cluster_id = -1;
				        	// $temp_string = $temp_word['word'];
				        	if(array_key_exists("clusterid", $temp_word))
				        	{
				        		$cluster_id = (int)($temp_word['clusterid']);
				        	}
				        	if($index == 0)
				        	{
				        		$temp_cluster_id = $cluster_id;
				        	}

				        	if($cluster_id != $temp_cluster_id)
				        	{
				        		$temp_array = array();
				        		$temp_array['text'] = $temp_string;
				        		$temp_array['clusterid'] = $temp_cluster_id;
				        		$result_raw_text_array []= $temp_array;
				        		$temp_string = $temp_word['word'];
				        		$temp_cluster_id = $cluster_id;
				        	}
				        	else
				        	{
				        		if($temp_string == '')
				        			$temp_string = $temp_word['word'];
				        		else
				        			$temp_string .= " " . $temp_word['word'];
				        	}
                        }
                        if($index > 0)
				        {
				        	$temp_array = array();
			        		$temp_array['text'] = $temp_string;
			        		$temp_array['clusterid'] = $temp_cluster_id;
			        		$result_raw_text_array [] = $temp_array;
				        }

				        $process_entry -> status = 2;
                        $process_entry -> mark = $iverciai['score'];
                        
                        $save_data = array();
				        $save_data['result_data'] = $result_raw_text_array;
				        $save_data['match_url'] = $references;
                        $process_entry -> result_data = serialize($save_data);
                        $process_entry -> save();
				        //This is for pdf

						$pdf = PDF::loadView('backend.pdf', ['result_raw_text_array' => $result_raw_text_array, 'references' => $references, 'score' => ($process_entry -> mark),  'file_name' => $project_entry -> uploaded_data ]);
						$pdf_filename =  $process_entry -> processing_token  . ".pdf";
						// $pdf->save(Storage::disk('local')->path("public/".$pdf_filename));
				        //End for pdf
                        $pdf->save(public_path() . '/uploads/'.$pdf_filename);
                      

				        return response()->json(['status'=>'success', 'data' => $result_raw_text_array, 'score' => $iverciai['score'], 'references' => $references]);
            
                        break;
                     endif;
                     sleep(5); // <- Important to add
                    endfor;
    
            }

            if($process_entry -> method_id == 2)
            {
                $copyscape = new Copyscape();
                $file_data = $project_entry -> data;


                $result = $copyscape -> doAnalysis($file_data);
                

                $process_entry -> status = 2;

                $parser = new Parser();

                $result = str_replace('<?xml version="1.0" encoding="utf-8"?>', '', $result);
                $parser = new Parser();

                $result_array = $parser -> xml($result);
                if(isset($result_array['error']))
                {
                    $process_entry -> status = 3;
                    $process_entry -> save();
                    die("No Credit\n");
                }
                else {
                    // # code...
                    $marks = $result_array['allpercentmatched'];
                    $process_entry -> result_data = serialize($result_array['result']);
                    $process_entry -> mark = $marks;
                    $process_entry -> save();
                    return response()->json(['status'=>'success', 'data' => $result_array['result'], 'score' => $marks]);
                }
            }

            if($process_entry -> method_id == 3)
            {
                $checkerplagiarism = new CheckerPlagiarism();
                $file_data = $project_entry -> data;
                $result = $checkerplagiarism -> doAnalysis($file_data);
                $process_entry -> status = 2;
                $process_entry -> result_data = serialize($result['details']);
                $process_entry -> mark = $result['plagPercent'];
                $process_entry -> save();
                return response()->json(['status'=>'success', 'data' => $result['details'], 'score' => $result['plagPercent']]);
            }

            if($process_entry -> method_id == 5)
            {
                $Prepostseo = new Prepostseo();
                $file_data = $project_entry -> data;
                $result = $Prepostseo -> doAnalysis($file_data);
                $process_entry -> status = 2;
                $process_entry -> result_data = serialize($result);
                $process_entry -> mark = $result['plagPercent'];
                $process_entry -> save();
                return response()->json(['status'=>'success', 'data' => $result, 'score' => $result['plagPercent']]);
            }




        }
        else {
            # code...
            return response()->json(['status'=>'error', 'error_code' => 'There is no project. <br/> Please contact with support team']);
        }
    } 
    
    public function openResult($token_project, $token_process)
    {
        $entry_project = Projects::where(['project_token' => $token_project])->first();
        if( isset($entry_project))
        {
            $entry_process = Processing::where(['processing_token' => $token_process, 'project_id' => $entry_project -> project_id])->first();
            
            if( isset($entry_process))
            {
                if($entry_process -> detailshowable)
                {
                    if($entry_process -> status != 2)
                        return response()->json(['status'=>'error', 'error_code' => 'There is no result']);
                    if(!($entry_process -> method -> isactive))
                        return response()->json(['status'=>'error', 'error_code' => 'That method is not actived']);
                    $data = [
                        'project' => $entry_project,
                        'process' => $entry_process
                    ];
                    if($entry_process -> method_id == 1)
                        return view('frontend.process.report', $data);
                    if($entry_process -> method_id == 2)
                        return view('frontend.process.report_copyscape', $data);
                    if($entry_process -> method_id == 3)
                        return view('frontend.process.report_checkplagiarism', $data);
                    
                    if($entry_process -> method_id == 5)
                        return view('frontend.process.report_prepostseo', $data);

                }
                else {
                    # code...
                    return response()->json(['status'=>'error', 'error_code' => 'This function is locked. <br/> Please buy this function to use that']);
                }
            }
            else {
                # code...
                return response()->json(['status'=>'error', 'error_code' => 'There is no process. <br/> Please contact with support team']);
            }
        }
        else {
            # code...
            return response()->json(['status'=>'error', 'error_code' => 'There is no project. <br/> Please contact with support team']);
        }

    }

    public function getResult($token_process)
    {
        $entry_process = Processing::where('processing_token', $token_process) -> first();
        if(isset($entry_process))
        {
            if($entry_process -> status != 2)
            {
                return response()->json(['status'=>'error', 'error_code' => 'The result data is not prepared']);
            }
            if($entry_process -> detailshowable != 1)
            {
                return response()->json(['status'=>'error', 'error_code' => 'This function is locked. <br/> Please buy this function to use that']);
            }
            $data = unserialize($entry_process -> result_data);
            if($entry_process -> method_id == 1)
                return response()->json(['status'=>'success', 'data' =>  $data['result_data'], 'score' => $entry_process -> mark, 'references' => $data['match_url']]);
            if($entry_process -> method_id == 2)
                return response()->json(['status'=>'success', 'data' =>  $data, 'score' => $entry_process -> mark]);
            if($entry_process -> method_id == 3)
                return response()->json(['status'=>'success', 'data' =>  $data, 'score' => $entry_process -> mark]);
            if($entry_process -> method_id == 5)
                return response()->json(['status'=>'success', 'data' =>  $data, 'score' => $entry_process -> mark]);
        }
        else {
            # code...
            return response()->json(['status'=>'error', 'error_code' => 'There is no such process']);
        }
    }

    public function opentopresult($token_project)
    {
        $entry_project = Projects::where(['project_token' => $token_project])->first();
        if( isset($entry_project))
        {
            $entry_process_top = Processing::where('project_id', ($entry_project -> project_id))
                                            -> where('status' , 2)
                                            -> where('detailshowable' , 1)
                                            -> orderBy('mark', 'desc')->first();
            if(isset($entry_process_top))
            {
                return redirect() -> route('project.openresult', ['token_project' => $entry_project -> project_token, 'token_process' => $entry_process_top -> processing_token]);
            }
            else {
                # code...
                return response()->json(['status'=>'error', 'error_code' => 'There is no processed result']);
            }
        }
        else {
            # code...
            return response()->json(['status'=>'error', 'error_code' => 'There is no project. <br/> Please contact with support team']);
        }

    }

    public function checked_list($project_token) {
        if(isset($project_token))
        {
            $entry_project = Projects::where(['project_token' => $project_token]) -> first();
            if(isset($entry_project -> email))
            {
                $email = $entry_project -> email;
                $entry_list = Projects::where('email', $email) -> where('project_token', '!=', $project_token) -> orderBy('created_at', 'DESC')-> get();;
                foreach ($entry_list as $entry) {
                    # code...
                    if( Processing::where('project_id', $entry -> project_id)
                        -> where('status', 2)
                        -> where('markable', 1)
                        ->exists())
                    $entry -> top_mark = Processing::where('project_id', $entry -> project_id)
                                                -> where('status', 2)
                                                -> where('markable', 1)
                                                -> max('mark') . "%";
                    else {
                        # code...
                        $entry -> top_mark = 'processing';
                    }                            
                }
                $data = ['projects_list' => $entry_list, 'email' => $email, 'project' => $entry_project];
                return view('frontend.process.checked_list', $data);
            }
            else {
                # code...
                abort(404);
            }
        }
        else {
            # code...
            abort(404);
        }
    }
}
