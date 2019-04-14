@extends('layouts.admin.main')

@section('seo-title')
    <title>
        Threedium | Article Edit
    </title>
@endsection

@push('page-css')
<link href="/templates/custom/plugins/css/jquery.fancybox.min.css" rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Single Article
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-content">
            <div class="row">
                <div class="col-lg-12">
                        <!--begin::Portlet-->
                        <div id="article-{{$article->id}}">
                            <div class="m-portlet m-portlet--mobile">
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption  ">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text">
                                                {{$article->title}}
                                            </h3>
                                        </div>
                                    </div>
                                    <div class="m-portlet__head-tools pr-3">
                                    <ul class="m-portlet__nav">
                                        <li class="m-portlet__nav-item">
                                            <a data-id="{{$article->id}}" href="{{route('article.edit',$article->id)}}" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                                <i class="la la-edit"></i>
                                            </a>
                                        </li>
                                        <li class="m-portlet__nav-item">
                                            <a data-id="{{$article->id}}" href="javascript:;" id="delete" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                                <i class="la la-trash"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                </div>

                                <div class="m-portlet__body">
                                    <div class="text-center row">
                                        <img class="mb-5 col-12" src="{{$article->cover_photo}}">
                                    </div>
                                        <p>{{$article->description}}</p>
                                    <div id="galery-article-{{$article->id}}" class="text-center">
                                        @if($article->images->count() != 0)
                                        <h4 class="mb-5">Galery:</h4>
                                        @endif
                                            <div class="row">
                                                @if(isset($article->images))
                                                @foreach($article->images as $image)
                                                <div class="col-3 mb-5 text-center">
                                                    <a data-media-id="{{$article->id}}" data-fancybox="gallery-{{$article->id}}" href="{{$image->path}}">
                                                            <img src="{{$image->thumb}}" id="pic-{{$article->id}}-{{$loop->iteration}}" alt="{{$article->title}}-pic-{{$loop->iteration}}"/>
                                                    </a>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-js')

<script src="/templates/custom/plugins/js/jquery.fancybox.min.js" type="text/javascript"></script>

<script>

var token = '{{auth()->user()->api_token}}';

$('#delete').on('click', function (e) {
        
        e.preventDefault();
        
        var id = $(this).data('id');
        
        var url = '/api/article/delete/' + id;
        
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            confirmButtonText: 'Yes, delete it!',
            buttonsStyling: false
        }).then(function () {
        $.ajax({
            url : url,
            type :'POST',
            headers : {  
                'Authorization' : 'Bearer ' + token
            },
            success : function (response) {
                $('#article-'+id).remove();
                swal({
                    title: 'Deleted!',
                    text: 'Your article has been deleted.',
                    type: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).catch(swal.noop);
                $('#datatables tbody').empty();
                setTimeout(function() {
                    window.location.replace('/');
                }, 1500);
            },
            error: function (e) {
                swal({
                    title: 'Not Deleted!',
                    text: 'Your article doesn\'t deleted.',
                    type: 'error',
                    timer: 2000,
                    showConfirmButton: false
                }).catch(swal.noop);
            }
        });
    
    });
        
});

</script>

@endpush