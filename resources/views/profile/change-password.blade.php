@extends('layouts.admin.main')

@section('seo-title')
    <title>
        Threedium | Change Password
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
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_2" role="tab">
                            <i class="flaticon-share m--hide"></i>
                            {{trans('admin.change_password')}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            
            <div class="tab-pane active" id="m_user_profile_tab_2">
                <form method="post" id="password" action="{{route('profile.change-pasword')}}" class="m-form m-form--fit m-form--label-align-right">
                    {{csrf_field()}}
                    <div class="m-portlet__body">
                        <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label for="old_password">
                                {{trans('admin.old_password')}}
                            </label>
                            <input class="form-control m-input m-input--square" name="old_password" placeholder="{{trans('admin.old_password')}}" type="password">
                            @if ($errors->has('old_password'))
                            <div class="form-control-feedback text-danger">
                                {{ $errors->first('old_password') }}
                            </div>
                            @endif
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="password">
                                {{trans('admin.change_password')}}
                            </label>
                            <input class="form-control m-input m-input--square" name="password" placeholder="{{trans('admin.password')}}" type="password">
                            @if ($errors->has('password'))
                            <div class="form-control-feedback text-danger">
                                {{ $errors->first('password') }}
                            </div>
                            @endif
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="password_confirmation">
                                {{trans('admin.password_confirmation')}}
                            </label>
                            <input class="form-control m-input m-input--square" name="password_confirmation" placeholder="{{trans('admin.password_confirmation')}}" type="password">
                            @if ($errors->has('password_confirmation'))
                            <div class="form-control-feedback text-danger">
                                {{ $errors->first('password_confirmation') }}
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
$('#password').validate({
    
    'rules':{
        
        'old_password':{
            required:true
        },
        'password':{
            required:true,
            minlength: 7
        },
        'password_confirmation':{
            required:true,
            minlength: 7
        }
        
        
    }, 
    'messages':{
        'old_password':{
            required:"Old password field is required!"
        },
        'password':{
            required:"Password field is required!",
            minlength:"Password must be at least 7 characters long!"
        },
        'password_confirmation':{
            required:"Password Confirmation field is required!",
            minlength:"Password must be at least 7 characters long!"
        }
    }
});
</script>
@endpush