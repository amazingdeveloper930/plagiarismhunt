@extends('backend.layouts.default')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="x_panel" style="min-height: 700px;">
            <div class="x_title">
                    <h2>Counter Stats</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <h3>Total Generated Code : {{ count($counter_list) }}</h3>
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                            <th>Token</th>
                            <th>Design Model</th>
                            <th>Created At</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        @foreach ($counter_list as $counter)
                            <tr>
                                <td>{{ $counter['token'] }}</td>
                                <td>{{ $counter['model'] }}</td>
                                <td>{{ $counter['created_at'] }}</td>
                                <td><a href = "{{'https://plagiarismchecker.eu/click-counter/' . $counter['token'] }}" class="btn btn-success" target="_blank">View</a></td>
                            </tr>
                        @endforeach
                        <tbody>

                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop