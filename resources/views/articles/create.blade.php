@extends('layouts.admin.main')

@section('seo-title')
<title>
    Threedium | Article Edit
</title>
@endsection

@push('page-css')
<link href="/templates/custom/plugins/css/dropzone.css" rel="stylesheet" type="text/css"/>
<link href="/templates/custom/plugins/css/jquery.fancybox.min.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Create Article 
                                    <small>

                                    </small>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">

                        <form class="feed-form position-static col-xl-8 px-0 mx-auto" id="form" method="post" action="" enctype="multipart/form-data">
                            {{csrf_field()}}

                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class="form-group m-form__group">
                                        <label class="">Title</label>
                                        <input id="title" class="form-control" name="title" value="" placeholder="Title" type="text">
                                        <div class="error-msg"></div>
                                        @if ($errors->has('title'))
                                        <div class="error-msg">{{ $errors->first('title') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class="form-group m-form__group">
                                        <label for="exampleInputEmail1">
                                            Cover photo
                                        </label>
                                        <div></div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="cover_photo" id="cover_photo">
                                            <label class="custom-file-label" for="cover_photo">
                                                Choose file
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-4 ">
                                    <div class="form-group m-form__group">
                                        <label class="position-relative">Description</label>
                                        <textarea class="form-control" id="description" name="description" cols="7"></textarea>
                                        <div class="error-msg"></div>
                                        @if ($errors->has('description'))
                                        <div class="error-msg">{{ $errors->first('description') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!--
                            for DROPZONE use .gallery-dropzone class for inicialization
                            Inicialization is on bootom page. This is important becouse of style
                            -->
                            <h5 class="mb-0">Aditional photos</h5>

                            <div class="form-group gallery-dropzone mb-4" >

                                <div class="dz-message needsclick">
                                    Drop files here or click to upload.<br />
                                    <span class="note needsclick">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <a href="{{route('articles.index')}}" class="btn btn-primary">Close</a>

                                <button type="button" id="button" class="btn btn-primary">Create</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-js')

<script src="/templates/custom/plugins/js/dropzone.js" type="text/javascript"></script>
<script src="/templates/custom/plugins/js/jquery.fancybox.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
var token = "{{ csrf_token() }}";
var api_token = "{{auth()->user()->api_token}}";
var formData2 = new FormData();
Dropzone.autoDiscover = false;

var myDropzone = new Dropzone(".gallery-dropzone", {
    autoProcessQueue: false,
    url: "/api/article/new",
    params: {
        _token: token
    },
    dataType:'json',
    contentType:'aplication/json',
    type:'POST',
    headers: {  
        'Authorization' : 'Bearer ' + api_token
    },
    uploadMultiple: true,
    parallelUploads: 10,
    maxFiles: 10,
    acceptedFiles: "image/*",
    init: function () {

        var myDropzone = this;

        // Update selector to match your button
        
        
        this.on("addedfile", function (file) {

                    // Create the remove button
                    var removeButton = Dropzone.createElement("<button class='ml-5 btn btn-danger btn-sm'><span class='fa fa-trash-o'></span></button>");

                    // Listen to the click event
                    removeButton.addEventListener("click", function (e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();

                        // Remove the file preview.
                        myDropzone.removeFile(file);
                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                    });

                    // Add the button to the file preview element.
                    file.previewElement.appendChild(removeButton);
                });

        this.on('sendingmultiple', function(file, xhr, formData) {
            formData.append("title", $("#title").val());
            formData.append("cover_photo", $("#cover_photo")[0].files[0]);
            formData.append("description", $("#description").val());
            });
    },
    successmultiple: function (response) {
        swal({
                title: 'Created!',
                text: response.message,
                type: 'success',
                timer: 2000,
                showConfirmButton: false
            }).catch(swal.noop);
            setTimeout(function() {
                window.location.replace('/');
            }, 1500);
    },
    error: function (response) {
        console.log(response);
        var message = JSON.parse(response.xhr.responseText);
        myDropzone.removeAllFiles(true);
        swal({
                title: 'Error!',
                text: message.message,
                type: 'error',
                timer: 2000,
                showConfirmButton: false
            }).catch(swal.noop);
    }
});
$("#button").click(function (e) {

            e.preventDefault();
            e.stopPropagation();
            
            if(myDropzone.files.length > 0){
                myDropzone.processQueue();  
                        } else { 
                            formData2.append('title',$("#title").val());
                            formData2.append('cover_photo',$("#cover_photo")[0].files[0]);
                            formData2.append('description',$("#description").val());
                                $.ajax({
                                url:'/api/article/new',
                                dataType:'json',
                                contentType:false,
                                processData: false,
                                data : formData2,
                                type:'POST',
                                headers: {  
                                    'Authorization' : 'Bearer ' + api_token
                                },
                                success : function (response) {
                                    swal({
                                        title: 'Created!',
                                        text: response.message,
                                        type: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).catch(swal.noop);
                                    setTimeout(function() {
                                        window.location.replace('/');
                                      }, 1500);
                                },
                                error: function (response) {
                                    console.log(response);
                                    myDropzone.removeAllFiles(true);
                                    swal({
                                            title: 'Error!',
                                            text: response.responseJSON.message,
                                            type: 'error',
                                            timer: 2000,
                                            showConfirmButton: false
                                        }).catch(swal.noop);
                                }
                                });
                            }  
        });

});
</script>
@endpush