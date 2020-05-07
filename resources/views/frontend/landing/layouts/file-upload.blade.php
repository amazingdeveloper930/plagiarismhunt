<div class="row">
        <div class="col-md-9">
                <form class="file-upload-content" action="{{route('check_text')}}" method = "POST">
                        {{ csrf_field() }}
                <div class="form-group">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="9" placeholder="Paste Your Paper Here..."  onkeyup="textCounter(this,'counter',1000);" name="sample_text"></textarea>
                    <span id = "counter"></span>
                    <button type="button" class="btn btn-primary" id = "check-text-btn">CHECK MY PAPER</button>
                  </div>
            </form>
            <div class="paper-cheque-btns">
                <a href="javascript:void(0)" id = "upload-button"><span><i class="fas fa-desktop"></i></span> IT’S ON MY COMPUTER</a>

                <form action="{{route('check_file')}}" id = "upload-form" enctype="multipart/form-data" class="align-items-center" method="POST">
                    {{ csrf_field() }}
                    <input type = "file" id = "file-input" name = "file[]" class = "form-control-file border" accept=".docx">
                </form>
                <a href="javascript:void(0)"><span><i class="fas fa-globe"></i></span> IT’S ON GOOGLE DRIVER</a>
            </div>
        </div>
    </div>