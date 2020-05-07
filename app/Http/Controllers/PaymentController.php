<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Projects;
use App\Method;
use App\Processing;

use Storage;
use Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use App\Setting;
use URL;
use App\Payment as paypalPayment;

class PaymentController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    public function index($token, $mode, $process_token = null)
    {
        $entry = null;
        $process_entry = null;
        if($mode == 1)
            $entry = Projects::where(['project_token' => $token, 'is_paid_openreport' => 0])->first();
        if($mode == 2)
            $entry = Projects::where(['project_token' => $token, 'is_paid_checkothers' => 0])->first();
        if($mode == 3)
        {
            $entry = Projects::where(['project_token' => $token])->first();
            $process_entry = Processing::where(['processing_token' => $process_token])->first();
        }

            
        if(isset($entry))
        {
            $price = 0;
            if($mode == 1)
            $price = Setting::getRecordByKey('price_open_report') -> value;
           if($mode == 2)
            $price =  Setting::getRecordByKey('price_check_all') -> value;
           if($mode == 3)//price_per_check
            $price = Setting::getRecordByKey('price_per_check') -> value;;
            $data = [
                'project' => $entry,
                'mode' => $mode,
                'process' => $process_entry,
                'price' => $price,
            ];
            return view('frontend.process.payment', $data);
        }
        else {
             return redirect() -> route('home');
        }
    }
    public function payWithpaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Item 1') /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount')); /** unit price **/

        $mode = $request -> mode;
        $process_token = null;
        if($mode == 3){
            $process_token = $request -> process_token;
        }
        
        $project_token = $request -> project_token;
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('paymentstatus')) /** Specify return URL **/
            ->setCancelUrl(route('paymentstatus'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                \Session::put('error', 'Connection timeout');
                return redirect() -> route('payment', ['token' => $project_token, 'mode' => $mode, 'process_token' => $process_token]);
            } else {
                \Session::put('error', 'Some error occur, sorry for inconvenient');
                return redirect() -> route('payment', ['token' => $project_token, 'mode' => $mode, 'process_token' => $process_token]);
            }
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            $payment = new paypalPayment;
			$payment->trans_id = 0;
			$payment->method = "paypal";
			$payment->amount = $request->get('amount');
			$payment->paid=0;
			$payment->status="Payment Initiated";
            $payment->created_at=date('Y-m-d H:i:s');
            $payment->mode = intval($mode);
            $payment->project_token = $project_token;
            $payment->process_token = $process_token;
            $payment->currency = "USD";
			$payment->save();
			
			Session::put('pid',$payment->id);
            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
        return redirect() -> route('payment', ['token' => $project_token, 'mode' => $mode, 'process_token' => $process_token]);
    }
    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        $cpid = Session::get('pid');
        $current_payment = paypalPayment::find($cpid);
        $project_token = $current_payment -> project_token;
        $process_token = $current_payment -> process_token;
        $mode = $current_payment -> mode;
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('error', 'Payment failed');
            return redirect() -> route('payment', ['token' => $project_token, 'mode' => $mode, 'process_token' => $process_token]);
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        $transactions = $payment->getTransactions();
		$relatedResources = $transactions[0]->getRelatedResources();
		$sale = $relatedResources[0]->getSale();
		$sale_data = $transactions[0]->getAmount();
		$payer = $payment->getPayer();
		$trans_id = $sale->getId();
		$currency = $sale_data->getCurrency();
		$final_amount = $sale_data->getTotal();
        if ($result->getState() == 'approved') {

            $payment = paypalPayment::find($cpid);
			$payment->trans_id = $trans_id;
			$payment->paid=1;
			$payment->status="Payment Received";
            $payment->created_at=date('Y-m-d H:i:s');
            $payment->save();
            
            $entry_project = Projects::where('project_token', $project_token)->first();
            if($mode == 1)
            {
                $entry_project -> is_paid_openreport = 1;
                $entry_project -> save();
                $processes = Processing::where('project_id', $entry_project -> project_id)->get();
                foreach ($processes as $process) {
                    # code...
                    $process -> detailshowable = 1;
                    $process -> save();
                }
            }
            if($mode == 2)
            {
                $entry_project -> is_paid_checkothers = 1;
                $entry_project -> save();
                $processes = Processing::where('project_id', $entry_project -> project_id)->get();
                foreach ($processes as $process) {
                    # code...
                    $process -> markable = 1;
                    $process -> save();
                }
            }
            if($mode == 3)
            {
                $entry_process = Processing::where('process_token', $process_token)->first();
                $entry_process -> markable = 1;
                $entry_process -> save();
            }
            /* Save order in database */
            \Session::flash('success', 'Payment success');
            return redirect() -> route('project', ['token' => $project_token]);
        }
        else {
            # code...
            $payment = new paypalPayment;
			$payment->user_id = $user_id;
			$payment->trans_id = $trans_id;
			$payment->method = "paypal";
			$payment->amount = $final_amount;
			$payment->paid=1;
			$payment->currency=$currency;
			$payment->status="Payment failed";
            $payment->created_at=date('Y-m-d H:i:s');
            $payment->mode = $mode;
            $payment->process_token = $process_token;
            $payment->project_token = $project_token;
            $payment->save();
            \Session::flash('error', 'Payment failed');
            return redirect() -> route('payment', ['token' => $project_token, 'mode' => $mode, 'process_token' => $process_token]);
        }
        
    }
}