@extends('layouts.admin.main')

@section('seo-title')
    <title>
        Threedium | Articles List
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
                        List of Articles
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
            <div class="form-group m-form__group mt-4 row">
                    <label class="col-form-label col-lg-1 col-md-1 col-xs-6" for="filters">
                        <h6>Filter: </h6>
                    </label>
                    <div class="col-md-3 col-lg-3 col-xs-6">
                    <select id="filters" name="filters" class="form-control m-input m-input--square" >
                        <option value=""
                        <span>All</span>
                        </option>
                        <option value="{{auth()->user()->id}}"
                        <span>My Articles</span>
                        </option>
                    </select>
                        @if ($errors->has('filters'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('filters') }}
                        </div>
                        @endif
                    </div>
                    <label class="col-form-label col-lg-1 col-md-1 col-xs-6" for="filters">
                        <h6>Limit: </h6>
                    </label>
                    <div class="col-md-3 col-lg-3 col-xs-6">
                    <select id="pagelimit" name="pagelimit" class="form-control m-input m-input--square" >
                        <option value="5"
                        <span>5</span>
                        </option>
                        <option value="10"
                        <span>10</span>
                        </option>
                        <option value="20"
                        <span>20</span>
                        </option>
                        <option value="50"
                        <span>50</span>
                        </option>
                    </select>
                        @if ($errors->has('filters'))
                        <div class="form-control-feedback text-danger">
                            {{ $errors->first('filters') }}
                        </div>
                        @endif
                    </div>
                <label class="col-form-label col-lg-1 col-md-1 col-xs-6 text-right" for="filters">
                    <h6>Page:<span id="pagenum"></span></h6>
                </label>
                <div class="nav-btn-container col-lg-3 col-md-3 col-xs-6 text-right" style="display: none">
                    <button class="prev-btn btn btn-info">Prev</button>
                    <button class="next-btn btn btn-info">Next</button>
                </div>
            </div>
            </div>
            </div>
            <div id="table" class="row">
               
                <table id="datatables" class="latest-articles table  table-bordered table-hover col-12 " cellspacing="0" width="100%" style="width:100%">
                        <tbody class="col-12">
                            
                        </tbody>
                </table>
                
            </div>
        </div>
    </div>
@endsection

@push('custom-js')

<script src="/templates/custom/plugins/js/jquery.fancybox.min.js" type="text/javascript"></script>
<script type="text/javascript">

    var token = "{{auth()->user()->api_token}}";
    
    var page = 1,
        pagelimit = 5,
        totalrecord;
    
    var filters = '';
    
    function callAjax() {
        
    var input = {

        filters:filters,
        page: page,
        pagelimit: pagelimit

    };
        
    $.ajax({
        url:'/api/articles',
        dataType:'json',
        contentType:'aplication/json',
        data : JSON.stringify(input),
        type:'POST',
        headers: {  
            'Authorization' : 'Bearer ' + token
        },
        success : function (response) {
            
            totalrecord = response.meta.total;
            
                if(response.data.length == 0){
                    $('#datatables tbody').append(`
                    <div class="m-portlet m-portlet--mobile">
                        <div class="m-portlet m-portlet--mobile">
                            <div class="m-portlet__head text-center">
                                <h3 class="mt-4" >No records found!</h3>
                            </div>
                        </div>
                    </div>
                    `);
                }
            
            $.each(response.data,function(file,article){
                
            $('#datatables tbody').append(`
            <tr>
                <td class="ml-1 mr-1">
                <div id="article-${article.id}">
                    <div class="m-portlet m-portlet--mobile">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption pl-5 ">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        <a href="/article/${article.id}">${article.title}</a>
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools pr-3">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a data-id="${article.id}" title="Edit" href="/article/edit/${article.id}" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                        <i class="la la-edit"></i>
                                    </a>
                                </li>
                                <li class="m-portlet__nav-item">
                                    <a data-id="${article.id}" href="javascript:;" title="Delete" class="delete m-portlet__nav-link m-portlet__nav-link--icon">
                                        <i class="la la-trash"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        </div>
                        
                        <div class="m-portlet__body">
                            <div class="text-center row">
                                <img class="mb-5 col-12" src="${article.cover_photo}">
                            </div>
                                <p>${article.description}</p>
                            <div id="galery-article-${article.id}" class="text-center">
                                    
                                <h4 id="galery-text" class="mb-5">Galery:</h4>
                                    <div class="row">
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                </td>
            </tr>
            `);
                if(article.images.length === 0){
                    $('#galery-article-'+article.id).find('#galery-text').remove();
                };
                $.each(article.images,function(i,image){
                    $('#galery-article-' +article.id+ ' .row').append(`
                    <div class="col-3 mb-5 text-center">
                        <a data-media-id="${article.id}" data-fancybox="gallery-${article.id}" href="${image}">
                                <img src="" id="pic-${article.id}-${i}" alt="${article.title}"/>
                        </a>
                    </div>
                    `);
                });
                
                $.each(article.thumbs,function(i,thumb){
                    $('#pic-'+article.id+ '-' +i).attr('src',thumb);
                });
            });
            $('.nav-btn-container').show();
            $('#pagenum').html(page);
       },
    error: function (e) {
        swal({
            title: 'Not Deleted!',
            text: e.statusText,
            type: 'error',
            timer: 2000,
            showConfirmButton: false
        }).catch(swal.noop);
     }
    });}
    
    
    
$(document).ready(function() {
    
    $('#filters').on('change',function() {
        
        filters = $(this).val();
        page = 1;
        $('#datatables tbody').empty();
        
        callAjax();
    });
    
    $('#pagelimit').on('change',function() {
        
        pagelimit = $(this).val();
        page = 1;
        console.log(pagelimit);
        $('#datatables tbody').empty();
        
        callAjax();
    });
    
    callAjax();
    
    // handling the prev-btn
	$(".nav-btn-container .prev-btn").on("click", function(){
		if (page > 1) {
			page--;
                        $('#datatables tbody').empty();
			callAjax();
		}
	});

	// handling the next-btn
	$(".nav-btn-container .next-btn").on("click", function(){
		if (page * pagelimit < totalrecord) {
			page++;
                        $('#datatables tbody').empty();
			callAjax();
		}
        });
    
    $('#datatables').on('click', '.delete', function (e) {
        
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
    }).then(function (result) {
        if(result.value){
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
                callAjax();
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
        }
    }).catch(swal.noop);
        
});

});
    
   

</script>

@endpush