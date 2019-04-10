@extends('layouts.auth')
@section('title')
Threedium | Sing In
@endsection
@section('content')

<div class="m-login__head">
    <hr>
    <h3 class="m-login__title">
        {{trans('auth.login')}}
    </h3>
    <hr>
</div>

<form method="POST" id="row-form" class="m-login__form m-form" action="{{ route('login') }}">
    {{csrf_field()}}
    <div class="form-group m-form__group">
        <input class="form-control m-input" type="email" value="{{ old('email') }}" placeholder="Email" name="email" id="m_email" autocomplete="off">
        @if ($errors->has('email'))
        @foreach($errors->get('email') as $errorMessage)
        <span class="help-block">
        <div class="text-danger">
            {{ $errorMessage }}
        </div>
        </span>
        @endforeach
        @endif
    </div>
    <div class="form-group m-form__group">
        <input  class="form-control m-input" type="password" placeholder="Password" name="password" >
        @if ($errors->has('password'))
        @foreach($errors->get('password') as $errorMessage)
        <span class="help-block">
        <div class="text-danger">
            {{ $errorMessage }}
        </div>
        </span>
        @endforeach
        @endif
    </div>
    <div class="row m-login__form-sub">
        <div class="col m--align-right m-login__form-right">
            <a href="{{ route('password.request') }}" class="m-link">
                {{trans('auth.forget_password')}}
            </a>
        </div>
    </div>
    <div class="m-login__form-action">
        <button class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
            {{trans('auth.login')}}
        </button>
    </div>
</form>



@endsection

@push('custom-js')
<script src="/templates/metronic/assets/demo/default/custom/components/forms/validation/form-controls.js" type="text/javascript"></script>
<script>
    
    $('#row-form').validate({
    
    rules:{
        
        'email':{
            required:true,
            email:true
        },
        'password':{
            required:true
        }
        
        
    }, 
    'messages':{
        'email':{
            required:"Email field is required!",
            email:"Please enter a valid Email!"
        },
        'password':{
            required:"Password field is required!"
        }
    }
});
</script>
@endpush

