@extends('layouts.admin.main')

@section('seo-title')
    <title>
        Threedium | Articles List
    </title>
@endsection

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
            <input type="hidden" id="token" value="{{auth()->user()->api_token}}">
            <div class="form-group m-form__group mt-4 row">
                    <label class="col-form-label col-md-1 col-xs-6" for="filters">
                        <h6>Filter : </h6>
                    </label>
                    <div class="col-md-3 col-xs-6">
                    <select id="filters" name="filters" class="form-control m-input m-input--square" >
                        <option value=""
                        <span>All</span>
                        </option>
                        <option value="{{auth()->user()->id}}"
                        <span>My Articles</span>
                        </option>
                    </select>
                    </div>
                    <label class="col-form-label col-md-1 col-xs-6" for="filters">
                        <h6>Limit : </h6>
                    </label>
                    <div class="col-md-3 col-xs-6">
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
                    </div>
                <label class="col-form-label col-md-2 col-xs-6 text-right" for="filters">
                    <h6>Page : <span id="pagenum"></span></h6>
                </label>
                <div class="nav-btn-container col-md-2 col-xs-6 text-right" style="display: none">
                    <button class="prev-btn btn btn-info">Prev</button>
                    <button class="next-btn btn btn-info">Next</button>
                </div>
                @if ($errors->has('filters'))
                <div class="form-control-feedback text-danger">
                    {{ $errors->first('filters') }}
                </div>
                @endif
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

<script type="text/javascript">

    var token = $('#token').val();
    
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
            
            console.log(response);
            
            totalrecord = response.meta.total;
            
            console.log(totalrecord);
            
            $.each(response.data,function(i,article){
            $('#datatables tbody').append(`
            <tr>
                <td class="ml-1 mr-1">
                <div id="article-${article.id}">
                    <div class="m-portlet m-portlet--mobile">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption pl-4 ">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        ${article.title}
                                        <small>

                                        </small>
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools pr-3">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a data-id="${article.id}" href="javascript:;" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                        <i class="la la-edit"></i>
                                    </a>
                                </li>
                                <li class="m-portlet__nav-item">
                                    <a data-id="${article.id}" href="javascript:;" class="delete m-portlet__nav-link m-portlet__nav-link--icon">
                                        <i class="la la-trash"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        </div>
                        
                        <div class="m-portlet__body">
                            <div class="text-center">
                                <img class="mb-5" src="/templates/defaults/usericon.png">
                            </div>
                                <p>${article.description}</p>
                            <div id="galery-article-${article.id}" class="text-center">
                                    
                               <h4>Galery:</h4>
                                   
                            </div>
                        </div>
                    </div>
                </div>
                </td>
            </tr>
            `);
                $.each(article.images,function(image){
                    $('#galery-article-'+article.id).append('<img class="mb-5 mt-2 mr-4" style="width:50px;height:50px;" src="/templates/defaults/usericon.png">');
                });
            });
            $('.nav-btn-container').show();
            $('#pagenum').html(page);
       },
       error: function (e) {
            toastr.error(e.statusText);
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
    
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    
    
    callAjax();
    
    // handling the prev-btn
	$(".nav-btn-container .prev-btn").on("click", function(){
		if (page > 1) {
			page--;
                        $('#datatables tbody').empty();
			callAjax();
		}
		console.log("Prev Page: " + page);
	});

	// handling the next-btn
	$(".nav-btn-container .next-btn").on("click", function(){
		if (page * pagelimit < totalrecord) {
			page++;
                        $('#datatables tbody').empty();
			callAjax();
		}
		console.log("Next Page: " + page);
        });
    
    $('#datatables').on('click', '.delete', function (e) {
        
        e.preventDefault();
        
        var id = $(this).data('id');
        
        var url = '/api/article/delete/' + id;
        $.ajax({
            url : url,
            type :'POST',
            headers : {  
                'Authorization' : 'Bearer ' + token
            },
            success : function (response) {
                $('#article-'+id).remove();
                toastr.success(response.message);
                $('#datatables tbody').empty();
                callAjax();
            },
            error: function (e) {
                toastr.error(e.statusText);
            }
        });
    
    });
        
});
    
   

</script>

@endpush