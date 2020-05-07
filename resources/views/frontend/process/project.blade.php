@extends('frontend.process.layouts.default')

@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3 id = "file-name">{{substr($project ->uploaded_data, 0, 30) . (strlen($project -> uploaded_data) > 30 ? '...':'')}}</h3>           
        </div>
        <div class="title_right">
                <button class="btn btn-success btn-round" id = "upload-button">Upload File</button>
                <form action="{{route('check_file')}}" id = "upload-form" enctype="multipart/form-data" class="align-items-center" method="POST">
                    {{ csrf_field() }}
                    <input type = "file" id = "file-input" name = "file[]" class = "form-control-file border" accept=".docx">
                </form>
        </div>

        
    </div>

    <div class="clearfix title-img"></div>

    <div class="row page-body">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="x_panel">
                    <input hidden value="{{$project->project_token}}" id="project-token" />
                    <input hidden value="{{route('project.status', array('token' => $project->project_token))}}"
                        id="project-status-url" />
                    <input hidden value="{{csrf_token()}}" id="_token" />
                    <input hidden value="{{$project->email}}" id="project-email"/>
                <table class="table table-striped projects col-md-8 col-sm-12 ">
                        <tbody>
                    @foreach ($processes as $process)
                    @if(isset($process->method))
                    <tr class="widget_plag_good_box"
                        data-process="{{$process -> processing_token}}" data-status="{{$process -> status}}"
                        data-markable="{{$process -> markable}}"
                        data-detailshowable="{{$process -> detailshowable}}"
                        data-mark="{{$process -> mark}}"
                        data-method-isactived={{$process -> method -> isactive}}>
                        <td><img class="method-icon" src="{{ asset('admin/images/' . $process ->method->icon_url) }}"/></td>
                        <td><h2 class="method-name">{{$process->method->method_name}}</h2></td>
                        <td><h3 class="rate status"></h3><div class="loader"></div></td>
                        <td><button type="button" class="btn  btn-danger btn-round btn-action"
                            data-process="{{$process -> processing_token}}"></button>
                            @if(!($project -> is_paid_openreport))
                                <button class="btn btn-link btn-payment-openreport" href="{{route('payment', array('token' => $project -> project_token, 'mode' => 1))}}">Open Detailed Report {{$price_open_report}} USD <i class="fa fa-angle-right"></i></button>
                            @else
                                <button class="btn btn-link btn-payment-openreport"href="{{route('project.opentopresult', array('token' => $project -> project_token))}}">Open Detailed Report</button>
                            @endif

                            <span class="label label-danger pull-right ribbon">Top</span>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                        </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 ">
            <div class="x_panel" id = "other-pan">
                    @if(!($project -> is_paid_checkothers))
                    <h4 style="padding: 10px">We check with one plagiarism checker free of charge. <br/>You can check with other plagiarism checkers or with all available checkers by clicking button.</h4>
                    <button class="btn btn-success btn-round btn-lg" id = "btn-payment-checkothers" href="{{route('payment', array('token' => $project -> project_token, 'mode' => 2))}}">Check with all checker {{$price_check_all}} USD</button>
                    @endif
            </div>
        </div>
</div>
</div>
<script src="{{ asset('js/paneltheme/project.js')}}"></script>
@stop
