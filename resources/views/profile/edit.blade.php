@extends('layouts.admin.main')

@section('seo-title')
    <title>
        Threedium | Edit Profile
    </title>
@endsection

@section('content')
<div class="m-content">
    @include('layouts.admin.partials.system-messages')
    <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                            <i class="flaticon-share m--hide"></i>
                            {{trans('admin.update_profile')}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="m_user_profile_tab_1">
                <form method="post" id="profile" action="{{route('profile.edit')}}" class="m-form m-form--fit m-form--label-align-right">
                    {{csrf_field()}}
                    <div class="m-portlet__body">
                        <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label for="name">
                                {{trans('admin.user-name')}}
                            </label>
                            <input class="form-control m-input m-input--square" name="name" placeholder="{{trans('admin.user-name')}}" type="text" value="{{old('name',$user->name)}}">
                            @if ($errors->has('name'))
                            <div class="form-control-feedback text-danger">
                                {{ $errors->first('name') }}
                            </div>
                            @endif
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="email">
                                {{trans('admin.email')}}
                            </label>
                            <input class="form-control m-input m-input--square" name="email" placeholder="{{trans('admin.email')}}" type="email" value="{{old('email',$user->email)}}">
                            @if ($errors->has('email'))
                            <div class="form-control-feedback text-danger">
                                {{ $errors->first('email') }}
                            </div>
                            @endif
                        </div>                                 
                        
                </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">
                        <button type="submit" class="btn btn-primary">
                            {{trans('admin.save_changes')}}
                        </button>
                        <a href="{{route('articles.index')}}" class="btn btn-secondary">
                            {{trans('admin.cancel')}}
                        </a>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
       

@endsection

@push('custom-js')
<script src="/templates/metronic/assets/demo/default/custom/components/forms/widgets/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="/templates/metronic/assets/demo/default/custom/components/forms/widgets/select2.js" type="text/javascript"></script>

<script>
    
$('#profile').validate({
    
    'rules':{
        
        'name':{
            required:true,
            minlength:3
        },
        'email':{
            required:true,
            email:true
        }
        
        
    }, 
    'messages':{
        'name':{
            required:"Name field is required!",
            minlength:"Name must be at least 3 characters long!"
        },
        'email':{
            required:"Email field is required!",
            email:"Please enter a valid Email!"
        }
    }
});



</script>
@endpush