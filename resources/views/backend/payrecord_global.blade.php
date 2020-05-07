@extends('backend.layouts.default')


<link href="{{ asset('css/process.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.cs')}}" rel="stylesheet">
<link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

@section('content')

<input type = "hidden" id = "plag1_api_url" value="https://plagiarismchecker.eu/api/v1/payment_list">
<input type = "hidden" id = "plaglt_api_url" value="https://plagiatas.lt/api/v1/payment_list">
<input type = "hidden" id = "plag2_api_url" value="https://plagiarismhunt.com/api/v1/payment_list">
<input type = "hidden" id = "pollanimal_api_url" value="https://pollanimal.com/api/v1/payment_list">

<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Payment List</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <?php
              $total = 0;
              ?>
              <div class="x_content">
                <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Trans ID</th>
                      <th>Email</th>
                      <th>Site URL</th>
                      <th>Date</th>
                      <th>Time</th>
                      <th>Method</th>
                      <th>Amount</th>
                      <th>Currency</th>
                      <th>Status</th>
                      <th>Decline Reason</th> 
                    </tr>
                  </thead> 
                  
                 
                  <tbody>
                      
                    @foreach ( $plag1_result as $plag1_entry)
                        @foreach ( $plag1_entry as $entry)
                        <tr>
                        <td>{{ $entry['trans_id'] }}</td>
                        <td>{{ $entry['email'] }}</td>
                        <td>PlagiarismChecker</td>
                        <?php
                        $datetime = new DateTime($entry['updated_at']);
                        ?>
                        <td>{{ $datetime -> format('Y-m-d') }}</td>
                        <td>{{ $datetime -> format('H:i') }}</td>
                        <td>{{ $entry['method'] }}</td>
                        <td>{{ $entry['amount'] }}</td>
                        <td>{{ $entry['currency'] }}</td>
                        <td>
                            @if($entry['status'] == 'Payment Initiated')
                                <span class='label label-warning'>{{ $entry['status'] }}</span>
                            @elseif($entry['status'] == 'Payment Approved')
                            <span class='label label-success'>{{ $entry['status'] }}</span>
                            @elseif($entry['status'] == 'Payment declined')
                            <span class='label label-danger'>{{ $entry['status'] }}</span>
                            @else
                            <span>{{ $entry['status'] }}</span>
                            @endif

                            <?php 
                            if($entry['status'] == 'Payment Approved')
                            if($entry['currency'] == "USD")
                                $total += $entry['amount'];
                            else
                                $total += $entry['amount'] * 1.1;
                            ?>
                        </td>
                        <td>{{ $entry['decline_reason'] }}</td>
                        </tr>
                        @endforeach
                    @endforeach

                    @foreach ( $plaglt_result as $plaglt_entry)
                        @foreach ( $plaglt_entry as $entry)
                        <tr>
                        <td>{{ $entry['trans_id'] }}</td>
                        <td>{{ $entry['email'] }}</td>
                        <td>Plagiatas</td>
                        <?php
                        $datetime = new DateTime($entry['updated_at']);
                        ?>
                        <td>{{ $datetime -> format('Y-m-d') }}</td>
                        <td>{{ $datetime -> format('H:i') }}</td>
                        <td>{{ $entry['method'] }}</td>
                        <td>{{ $entry['amount'] }}</td>
                        <td>{{ $entry['currency'] }}</td>
                        <td>
                            @if($entry['status'] == 'Payment Initiated')
                                <span class='label label-warning'>{{ $entry['status'] }}</span>
                            @elseif($entry['status'] == 'Payment Approved')
                            <span class='label label-success'>{{ $entry['status'] }}</span>
                            @elseif($entry['status'] == 'Payment declined')
                            <span class='label label-danger'>{{ $entry['status'] }}</span>
                            @else
                            <span>{{ $entry['status'] }}</span>
                            @endif
                            <?php 
                            if($entry['status'] == 'Payment Approved')
                            if($entry['currency'] == "USD")
                                $total += $entry['amount'];
                            else
                                $total += $entry['amount'] * 1.1;
                            ?>
                        </td>
                        <td>{{ $entry['decline_reason'] }}</td>
                        </tr>
                        @endforeach
                    @endforeach

                    @foreach ( $plaghunt_result as $plaghunt_entry)
                        @foreach ( $plaghunt_entry as $entry)
                        <tr>
                        <td>{{ $entry['trans_id'] }}</td>
                        <td>{{ $entry['email'] }}</td>
                        <td>PlagiarismHunt</td>
                        <?php
                        $datetime = new DateTime($entry['updated_at']);
                        ?>
                        <td>{{ $datetime -> format('Y-m-d') }}</td>
                        <td>{{ $datetime -> format('H:i') }}</td>
                        <td>{{ $entry['method'] }}</td>
                        <td>{{ $entry['amount'] }}</td>
                        <td>{{ $entry['currency'] }}</td>
                        <td>
                            @if($entry['status'] == 'Payment Initiated')
                                <span class='label label-warning'>{{ $entry['status'] }}</span>
                            @elseif($entry['status'] == 'Payment Received')
                            <span class='label label-success'>{{ $entry['status'] }}</span>
                            @elseif($entry['status'] == 'Payment declined')
                            <span class='label label-danger'>{{ $entry['status'] }}</span>
                            @else
                            <span>{{ $entry['status'] }}</span>
                            @endif
                            <?php 
                            if($entry['status'] == 'Payment Received')
                            if($entry['currency'] == "USD")
                                $total += $entry['amount'];
                            else
                                $total += $entry['amount'] * 1.1;
                            ?>
                        </td>
                        <td>{{ $entry['decline_reason'] }}</td>
                        </tr>
                        @endforeach
                    @endforeach
                    
                    @foreach ( $pollanimal_result as $pollanimal_entry)
                        @foreach ( $pollanimal_entry as $entry)
                        <tr>
                        <td>{{ $entry['trans_id'] }}</td>
                        <td>{{ $entry['email'] }}</td>
                        <td>Pollanimal</td>
                        <?php
                        $datetime = new DateTime($entry['updated_at']);
                        ?>
                        <td>{{ $datetime -> format('Y-m-d') }}</td>
                        <td>{{ $datetime -> format('H:i') }}</td>
                        <td>{{ $entry['method'] }}</td>
                        <td>{{ $entry['amount'] }}</td>
                        <td>{{ $entry['currency'] }}</td>
                        <td>
                            @if($entry['status'] == 'Payment Initiated')
                                <span class='label label-warning'>{{ $entry['status'] }}</span>
                            @elseif($entry['status'] == 'Payment Approved')
                            <span class='label label-success'>{{ $entry['status'] }}</span>
                            @elseif($entry['status'] == 'Payment declined')
                            <span class='label label-danger'>{{ $entry['status'] }}</span>
                            @else
                            <span>{{ $entry['status'] }}</span>
                            @endif
                            <?php 
                            if($entry['status'] == 'Payment Approved')
                            if($entry['currency'] == "USD")
                                $total += $entry['amount'];
                            else
                                $total += $entry['amount'] * 1.1;
                            ?>
                        </td>
                        <td>{{ $entry['decline_reason'] }}</td>
                        </tr>
                        @endforeach
                    @endforeach
                  </tbody>
                </table>
                
              </div>
        </div>
    </div>
</div>
<!-- Datatables -->
<script src="{{asset('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{ asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
<script src="{{ asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
<script src="{{ asset('vendors/jszip/dist/jszip.min.js')}}"></script>
<script src="{{ asset('vendors/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{ asset('vendors/pdfmake/build/vfs_fonts.js')}}"></script>



@stop