@extends('frontend.process.layouts.default')

@section('content')

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>{{substr($project ->uploaded_data, 0, 30) . (strlen($project -> uploaded_data) > 30 ? '...':'')}}</h3>
        </div>

        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

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
                    <div class="well">
                        <style type="text/css">
                            a {

                                /* These are technically the same, but use both */
                                overflow-wrap: break-word;
                                word-wrap: break-word;

                                -ms-word-break: break-all;
                                /* This is the dangerous one in WebKit, as it breaks things wherever */
                                word-break: break-all;
                                /* Instead use this non-standard one: */
                                word-break: break-word;

                                /* Adds a hyphen where the word breaks, if supported (No Blink) */
                                -ms-hyphens: auto;
                                -moz-hyphens: auto;
                                -webkit-hyphens: auto;
                                hyphens: auto;

                            }

                            .ball {
                                height: 50px;
                                width: 50px;
                                position: absolute;
                                left: 50%;
                                top: 50%;
                            }

                            .ball:before {
                                content: '';
                                position: absolute;
                                height: 100%;
                                width: 100%;
                                background: rgba(0, 255, 0, .5);
                                border-radius: 50%;
                                margin-left: -50%;
                                margin-top: -50%;
                                left: -100%;

                                animation: position 2s infinite cubic-bezier(.25, 0, .75, 1), size 2s infinite cubic-bezier(.25, 0, .75, 1);
                            }

                            .ball-1:before {
                                animation-delay: 0s, -.5s;
                            }

                            .ball-2:before {
                                animation-delay: -.5s, -1s;
                            }

                            .ball-3:before {
                                animation-delay: -1s, -1.5s;
                            }

                            .ball-4:before {
                                animation-delay: -1.5s, -2s;
                            }

                            .spinner {
                                height: 100%;
                                width: 100%;
                                position: absolute;
                                z-index: 3;
                            }

                            @keyframes position {
                                50% {
                                    left: 100%;
                                }
                            }

                            @keyframes size {
                                50% {
                                    transform: scale(.5, .5);
                                }
                            }

                            .loader {
                                height: 4px;
                                width: 100%;
                                position: relative;
                                overflow: hidden;
                                background-color: #ddd;
                            }

                            .loader:before {
                                display: block;
                                position: absolute;
                                content: "";
                                left: -200px;
                                width: 200px;
                                height: 4px;
                                background-color: #09c0e4;
                                animation: loading 2s linear infinite;
                            }

                            @keyframes loading {
                                from {
                                    left: -200px;
                                    width: 30%;
                                }

                                50% {
                                    width: 30%;
                                }

                                70% {
                                    width: 70%;
                                }

                                80% {
                                    left: 50%;
                                }

                                95% {
                                    left: 120%;
                                }

                                to {
                                    left: 100%;
                                }
                            }


                            .card-header button {
                                width: 35px;
                                height: 35px;
                                margin: 5px 0px;
                                padding: 0px;
                            }

                            #document-content {
                                min-height: 700px;
                                max-height: 900px;
                                overflow-y: auto;
                                padding: 30px;
                                overflow-x: hidden;
                                white-space: pre-wrap;
                                font-size: 18px;
                            }

                            #info-exist-box {
                                min-height: 700px;
                                max-height: 900px;
                                overflow-y: auto;
                                padding: 30px;
                                overflow-x: hidden;
                                font-size: 16px;
                            }

                            #document-content span {
                                font-size: 20px;
                                height: fit-content;

                                color: black;
                                display: inline;
                                padding: 0.45rem;
                                line-height: 2em;
                                white-space: pre-wrap;

                                /* Needs prefixing */
                                box-decoration-break: clone;
                                -webkit-box-decoration-break: clone;

                            }

                            .inexact-match {
                                border-bottom: 3px solid rgba(232, 123, 0, .42);

                            }

                            .match {
                                cursor: pointer;
                                padding: 2px 0;
                                transition: border-width .1s ease-in-out, background .2s ease;
                                border-radius: 2px 2px 0 0;
                            }

                            .exact-match {
                                /*border-bottom: 3px solid rgba(232,152,148,.75);*/
                                background-color: rgba(232, 152, 148, 0.5);
                            }

                            .exact-match:hover,
                            .exact-match.focus {
                                /*background-color: rgba(232,152,148,.1);*/
                                background-color: rgba(232, 152, 148);
                            }

                            .inexact-match:hover,
                            .inexact-match.focus {
                                background-color: rgba(232, 123, 0, .1);
                            }

                            #info-box a {
                                cursor: pointer;
                            }

                            i.matchtile {
                                color: #e91e63;
                                display: contents;
                            }

                            .refurl {
                                color: #00bcd4;
                            }

                            #match-reference .card-body {
                                font-size: 16px;
                            }

                            #match-reference-url .text-info {
                                margin-bottom: 20px;
                            }

                            #report-download-link {
                                width: 35px;
                                height: 35px;
                                margin: 5px 0px;
                                padding: 9px 2px;
                            }

                            .zoom-buttons {
                                background-color: transparent;
                                position: absolute;
                                right: 50px;
                            }

                            .btn-zoom {
                                width: 40px !important;
                                height: 40px !important;
                                text-align: center !important;
                                border-radius: 50% !important;
                                border-style: solid;
                                border-color: #999;
                                background: #AAA;
                                opacity: 0.6;
                                padding: 8px;
                                color: white;
                                cursor: point;
                                -webkit-transition: all 0.3s ease-in-out;
                                -moz-transition: all 0.3s ease-in-out;
                                -o-transition: all 0.3s ease-in-out;
                                -ms-transition: all 0.3s ease-in-out;
                                transition: all 0.3s ease-in-out;
                            }

                            .btn-zoom:hover {
                                opacity: 0.9;
                            }

                            .btn-zoom:focus {
                                outline: 0 !important;
                            }

                            .simiar-percent {
                                font-size: 2em;
                            }

                            /*.zoom-buttons i {
                              margin: 0.1em 0.1em;
                              background-color: DarkSeaGreen;
                              border: 1px SeaGreen solid;
                              width: 1.4em;
                              height: 1.4em;
                        
                              display: inline-block;
                              border-radius: 50%;
                              opacity: .8;
                              -webkit-transition: all 0.3s ease-in-out; 
                              -moz-transition: all 0.3s ease-in-out;
                              -o-transition: all 0.3s ease-in-out;
                              -ms-transition: all 0.3s ease-in-out;
                              transition: all 0.3s ease-in-out;
                            }
                            
                            .zoom-buttons i:hover {
                              opacity: 1;
                              cursor: pointer;
                            }*/
                            #current-reference {
                                padding: 10px;
                                display: inline-block;
                            }
                        </style>

                        <!-- This is for variables -->
                        <input id="processing_id" value="{{$process -> process_id}}" hidden>
                        {{-- <input id = "rawfiledataurl" value="{{route('report.rawfiledata')}}" hidden>
                        <input id="savedreportdataurl" value="{{route('report.getsavedreportdata')}}" hidden>
                        <input id="doanalysisurl" value="{{route('report.doanalysis')}}" hidden>
                        <input id="deletereporturl" value="{{route('report.delete')}}" hidden> --}}
                        <!-- End variables -->

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">

                                <div class="x_panel">
                                    <div class="x_content" id="typography">
                                        <div class="zoom-buttons">
                                            <button type="button" class="btn-zoom" onclick="zoom_in_text()"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span></button>
                                            <button type="button" class="btn-zoom" onclick="zoom_out_text()"><span class="glyphicon glyphicon-zoom-out" aria-hidden="true"></span></button>
                                        </div>
                                        <div id="document-content">
                                        </div>
                                    </div>
                                    <div class="spinner" id="document-content-loading-spinner">
                                        <div class="ball ball-1"></div>
                                        <div class="ball ball-2"></div>
                                        <div class="ball ball-3"></div>
                                        <div class="ball ball-4"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 " id="info-box">
                                <div class="x_panel">
                                    
                                    <div id="info-exist-box" class = "x_content">
                                        <div id="info-progressing-box">
                                                <span class="text-info">
                                                    <h3>Loading ...</h3>
                                                </span>
                                        </div>
                                        <div id="match-reference-url">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <style type="text/css">


                        </style>
                        <script type="text/javascript">
                        function sw_simple_alert(type, message)
                        {
                            Swal.fire({
                                type: type,
                                title: message,
                                showConfirmButton: true,
                            });
                        }
                        function setToLoadingStatus()
                        {
                            $('#document-content').css('opacity', 0.1);
                            $('#document-content-loading-spinner').show();
                            $('#info-progressing-box').show();
                            $('#match-reference-url').hide();
                        }
                        function setToOriginalStatus()
                        {
                            $('#document-content').css('opacity', 1.0);
                            $('#document-content-loading-spinner').hide();
                            $('#info-progressing-box').hide();
                            $('#match-reference-url').show();
                        }

                        function zoom_in_text()
                        {
                            var current_font_size = parseInt($('#document-content span').css("font-size"));
                            current_font_size = Math.ceil(current_font_size * 1.2);
                            $('#document-content span').css("font-size", current_font_size);
                        }

                        function zoom_out_text()
                        {
                            var current_font_size = parseInt($('#document-content span').css("font-size"));
                            current_font_size = Math.ceil(current_font_size / 1.2);
                            $('#document-content span').css("font-size", current_font_size);
                        } 

                        $( document ).ready(function() {
                            setToLoadingStatus();
                            var processing_id = $("#processing_id").val();

                            $.ajax({
                            type: "get",
                            dataType: "json",
                            url: "{{ route('project.getresult', $process -> processing_token)}}",
                         
                            success: function(response){
                                setToOriginalStatus();
                                $('#document-content').html('');
                                if(response.status == 'success')
                                {
                                    myfunction(response);
                                }  
                                else{
                                    sw_simple_alert(response.status, response.error_code);
                                }

                            },
                            error: function(jqXhr1, textStatus1, errorThrown1){
                                sw_simple_alert('error', 'unknown error');
                            }
                            });
                        });


                        function myfunction(response1)
                        {
                                    var text_datas = response1.data;
                                    $('#report-download-link').attr('href', response1.pdf_url);
                                    // $('#match-percent .progress-bar').css('width', response1.score+'%').attr('aria-valuenow', response1.score); 
                                    // $('#match-percent .progress-badge').html("<h1>" + response1.score + "%</h1>");
                                    $('.simiar-percent').html(response1.score + "%");
                                    $.each(text_datas.details, function(index, item){
                                        var str = '';
                                        if(item.unique == 'true')
                                        {
                                            str = "<span>";
                                        }
                                        else
                                            str = "<span class='match exact-match' >";
                                        str += item.query + " ";
                                        str += "</span>";
                                        $('#document-content').append(str);
                                    });
                                    $("#match-reference-url").html('');
                                    $.each(text_datas['sources'], function(index, item){
                                        $("#match-reference-url").append("<a target = '_blank' href = '" + item.link + "'>" + item.link + "</a><br/><br/>");
                                    });
                                    
                                    swal({ title:"Plagiarism rate is " + response1.score + "%", text: "", type: "success", buttonsStyling: false, confirmButtonClass: "btn btn-success"});

                        }
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <script src="{{ asset('js/paneltheme/report.js')}}"></script> --}}
@stop
