@extends('backend.layouts.default')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Admin Dashboard</h2>
                <ul class="nav navbar-right panel_toolbox">
                    
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content well p-t-30">
                <div class="row top_tiles ">
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                        <div class="icon"><i class="fa fa-users"></i></div>
                        <div class="count">{{$count_verified_users}}</div>
                        <h3>Total Verified Users</h3>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                        <div class="icon"><i class="fa fa-money"></i></div>
                        <div class="count">{{$total_payment}}</div>
                        <h3>Total Payment (USD)</h3>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                        <div class="icon"><i class="fa fa-usd"></i></div>
                        <div class="count">{{$detailed_report_payment}}</div>
                        <h3>Report Payment (USD)</h3>
                        </div>
                    </div>
                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                        <div class="icon"><i class="fa fa-usd"></i></div>
                        <div class="count">{{$check_other_all}}</div>
                        <h3>Checker Payment (USD)</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                  <div class="x_title">
                                    <h2>Checker Dashboard</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                      </li>
                                    
                                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                                      </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                  </div>
                                  <div class="x_content">
                                        <div id="dashboard_chart" class="demo-placeholder"></div>
                                  </div>
                                </div>
                              </div>
                </div>
            </div>

        </div>
    </div>
</div>
   
     <!-- Chart.js -->
     <script src="{{ asset('vendors/Chart.js/dist/Chart.min.js') }}"></script>
     <!-- jQuery Sparklines -->
     <script src="{{ asset('vendors/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
     <!-- Flot -->
     <script src="{{ asset('vendors/Flot/jquery.flot.js') }}"></script>
     <script src="{{ asset('vendors/Flot/jquery.flot.pie.js') }}"></script>
     <script src="{{ asset('vendors/Flot/jquery.flot.time.js') }}"></script>
     <script src="{{ asset('vendors/Flot/jquery.flot.stack.js') }}"></script>
     <script src="{{ asset('vendors/Flot/jquery.flot.resize.js') }}"></script>
     <!-- Flot plugins -->
     <script src="{{ asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
     <script src="{{ asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
     <script src="{{ asset('vendors/flot.curvedlines/curvedLines.js') }}"></script>
     <!-- DateJS -->
     <script src="{{ asset('vendors/DateJS/build/date.js') }}"></script>
     <!-- bootstrap-daterangepicker -->
     <script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
     <script src="{{ asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script lang="javascript">
        var dashboard_chart_data = JSON.parse('{{json_encode($check_count_list)}}');

        var dashboard_chart_settings = {
			grid: {
				show: true,
				aboveData: true,
				color: "#3f3f3f",
				labelMargin: 10,
				axisMargin: 0,
				borderWidth: 0,
				borderColor: null,
				minBorderMargin: 5,
				clickable: true,
				hoverable: true,
				autoHighlight: true,
				mouseActiveRadius: 100
			},
			series: {
				lines: {
					show: true,
					fill: true,
					lineWidth: 1,
					steps: false
				},
				points: {
					show: true,
					radius: 4.5,
					symbol: "circle",
					lineWidth: 3.0
				}
			},
			legend: {
				position: "ne",
				margin: [0, -25],
				noColumns: 0,
				labelBoxBorderColor: null,
				labelFormatter: function(label, series) {
					return label + '&nbsp;&nbsp;';
				},
				width: 40,
				height: 1
			},
			colors: ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'],
			shadowSize: 0,
			tooltip: true,
			tooltipOpts: {
				content: "%s: %y.0",
				xDateFormat: "%d/%m",
			shifts: {
				x: -30,
				y: -50
			},
			defaultTheme: false
			},
			yaxis: {
				min: 0
			},
			xaxis: {
				mode: "time",
				minTickSize: [1, "day"],
				timeformat: "%d/%m/%y",
				min: dashboard_chart_data[0][0],
				max: dashboard_chart_data[20][0]
			}
		};	

        $.plot( $("#dashboard_chart"), 
			[{ 
				label: "", 
				data: dashboard_chart_data, 
				lines: { 
					fillColor: "rgba(150, 202, 89, 0.12)" 
				}, 
				points: { 
					fillColor: "#fff" } 
			}], dashboard_chart_settings);
    </script>
@stop