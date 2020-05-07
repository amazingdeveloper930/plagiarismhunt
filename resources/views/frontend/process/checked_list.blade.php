@extends('frontend.process.layouts.default')

@section('content')

<div class="">
        <div class="page-title">
          <div class="title_left" style="height: 10px;">
          
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

        <div class="row">
          <div class="col-md-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Checked List</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
                </ul>
                <div class="clearfix "></div>
              </div>
              <div class="x_content">
                        <div class="table-responsive">
                                <table class="table table-striped jambo_table">
                                  <thead>
                                    <tr class="headings">
                                      
                                      <th class="column-title">Name</th>
                                      <th class="column-title">Plagiarism Percentage</th>
                                      <th class="column-title">Uploaded Date</th>
                                      <th class="column-title"><span class="nobr">Action</span>
                                      </th>
                                      <th class="column-title no-link last">Action Needed</th>
                                    </tr>
                                  </thead>
          
                                  <tbody>
                                    <?php
                                        for($index = 0; $index < count( $projects_list ); $index ++){
                                    ?>
                                    <tr class="{{$index % 2 == 0? 'even':'odd'}} pointer" id = "{{ 'project-' . ($projects_list[$index] -> project_token) }}">
              
                                      <td class=" ">{{$projects_list[$index] -> uploaded_data}}</td>
                                      <td class=" ">{{$projects_list[$index] -> top_mark}}</td>
                                      <td class=" ">{{$projects_list[$index] -> created_at}}</td>
                                      <td class=" "><button class="btn btn-success btn-round"><a href="{{route('email_verify', ['email' => $projects_list[$index] -> email, 'token' => $projects_list[$index] -> project_token])}}"><span class="label">View</span></a>
                                      </td>
                                    <td class="last"><button class="btn btn-danger" onclick="deleteProject('{{$projects_list[$index] -> project_token }}')"><i class="fa fa-trash"></i></button></td>
                                    </tr>
                                    <?php 
                                        }
                                    ?>
                                  </tbody>
                                </table>
                              </div>
                  
              </div>
            </div>
          </div>
        </div>
      </div>
<script src="{{ asset('js/paneltheme/checked_list.js')}}"></script>
@stop