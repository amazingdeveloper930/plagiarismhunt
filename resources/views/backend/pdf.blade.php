<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    
  </head>
  <style type="text/css">
  	body {
	    font-family: DejaVu Sans;
	}
  </style>
  <body>
      <div class="container">
<style type="text/css">
  body{
    background-color: white;
  }
  .text-title{
    display: block;
    background-color: #eee;
    padding: 10px 20px;
  }
  .text-item{
    margin-bottom: 30px;
    border-style: solid;
    border-width: 1px;
    border-color: #AAA;
    padding: 1px;
  }
  .text-content{
    padding: 10px;
  }
  .text-content .matchtile{
    color: #e91e63;
  }
  .text-content .refurl {
    color: #00bcd4;
    padding: 10px;
  }
  
</style>
  <div class="row">
      <div>
        <h3 class="title">File Name : {{$file_name}}</h3>
        <h3>Score : {{$score}}%</h3>
      </div>
  </div>
  @if(isset($result_raw_text_array))
    @foreach($result_raw_text_array as $result_raw_text_item)
      @if($result_raw_text_item['clusterid'] >= 0)
      <div class="row text-item">
        <div class="text-title">
          ...{{$result_raw_text_item['text']}}...
        </div>
        <div class="text-content">
          {!! $references[$result_raw_text_item['clusterid']]!!}
        </div>
      </div>  
      @endif
    @endforeach
  @else
    <div class="row">
      <div style="text-align: center;">
        <h4>There is no match data</h4>
      </div>
    </div>
  @endif
</div>
</body>
</html>