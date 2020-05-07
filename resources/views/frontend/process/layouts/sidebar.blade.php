<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
                <li><a href = "{{ route('project', ['token' => $project -> project_token])}}" class="{{ request()->is(route('project', ['token' => $project -> project_token])) ? 'active current-page' : '' }}"><i class="fa fa-file-text-o"></i> My Last Doc </a></li>
        <h3><i class="fa fa-caret-right"></i>Project Name : 
            {{substr($project ->uploaded_data, 0, 20) . (strlen($project -> uploaded_data) > 20 ? '...':'')}}</h3>
            
        <h3><i class="fa fa-caret-right"></i>Project Type : <i>{{$project -> type}}</i></h3>
            
            <h3><i class="fa fa-caret-right"></i>Created date : <i>{{ $project -> created_at}}</i></h3>
            
        <h3><i class="fa fa-caret-right"></i>Email Verified : <i>{{ $project -> verified ?  'yes' : 'no'}}</i></h3>
            
        <h3><i class="fa fa-caret-right"></i>Open Report Pay : <i>{{$project -> is_paid_openreport ?  'yes' : 'no'}}</i></h3>
            
        <h3><i class="fa fa-caret-right"></i>Check All Pay : <i>{{$project -> is_paid_checkothers ?  'yes' : 'no'}}</i></h3>
            

            @if(isset($project -> email))
           
            <li><a href = "{{ route('project.checked_list', [ 'project_token' => $project -> project_token])}}" class="{{ request()->is(route('project.checked_list', [ 'email' => $project -> email ])) ? 'active current-page' : '' }}"><i class="fa fa-list-alt"></i> Checked List </a></li>
            @endif
        </ul>
    </div>
    
    </div>
    <!-- /sidebar menu -->