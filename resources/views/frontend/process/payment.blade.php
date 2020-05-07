@extends('frontend.process.layouts.default')

@section('content')

<div class="">
        <div class="page-title">
          <div class="title_left">
          <h3>{{substr($project ->uploaded_data, 0, 30) . (strlen($project -> uploaded_data) > 30 ? '...':'')}}</h3>
          </div>
        </div>

        <div class="clearfix title-img"></div>

        <div class="row">
          <div class="col-md-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Result of checking paper <small>order:key {{$project->project_token}}</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  @if ($message = Session::get('success'))
  
                  <p>{!! $message !!}</p>
             
                  <?php Session::forget('success');?>
                  @endif
          
                  @if ($message = Session::get('error'))
                
                      <p>{!! $message !!}</p>
                  
                  <?php Session::forget('error');?>
                  @endif
                <form class="w3-container w3-display-middle w3-card-4 w3-padding-16" method="POST" id="payment-form"
                    action="{!! URL::to('paypal') !!}">
                    {{ csrf_field() }}
                    <input hidden name="mode" value = {{$mode}}>
                      <input hidden name="project_token" value = {{$project -> project_token}}>
                      @if($mode == 3)
                      <input hidden name="process_token" value = {{$process -> process_token}}>
                      @endif
                    <table class="table">
                      <tbody>
                        <tr>
                          <td><span>Pay with Paypal</span></td>
                          <td>
                              <span><b>
                                  <?php 
                                    if($mode == 2)
                                    echo "Check All Papers";
                                    if($mode == 1)
                                    echo "Open Detailed Report";
                                    if($mode == 3)
                                    echo "Check paper with this checker : " . $process -> method -> method_name;
                                  ?>
                                </b></span>
                          </td>
                          <td>
                              <label class="w3-text-blue"><b>Price</b></label>
                              <input class="w3-input w3-border" id="amount" type="text" name="amount" value= {{$price}} readonly>USD<br/>
                          </td>
                          <td>
                              <button class="btn btn-success btn-round">Pay with PayPal</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

@stop