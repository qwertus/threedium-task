@extends('layouts.auth')
@section('title')
Password Reset
@endsection
@section('content')



<div class="m-login__head">
    <hr>
    <h3 class="m-login__title">
        {{trans('auth.password_reset')}}
    </h3>
    <hr>
</div>

<form class="m-login__form m-form" id="row-form" method="POST" action="{{ route('password.request') }}">
    {{ csrf_field() }}

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group m-form__group">
        <input required class="form-control m-input" type="email" placeholder="{{trans('auth.email')}}" name="email" value="{{ old('email') }}" autocomplete="off" >
        @if ($errors->has('email'))
        <hr>
        @foreach($errors->get('email') as $errorMessage)
        <div class="text-center text-danger">
            {{ $errorMessage }}
        </div>
        <hr>
        @endforeach
        @endif
    </div>

    <div class="form-group m-form__group">
        <input required class="form-control m-input" id="password" type="password" placeholder="{{trans('auth.password')}}" name="password" value="{{ old('password') }}" autocomplete="off" >
        @if ($errors->has('password'))
        <hr>
        @foreach($errors->get('password') as $errorMessage)
        <div class="text-center text-danger">
            {{ $errorMessage }}
        </div>
        <hr>
        @endforeach
        @endif
    </div>

    <div class="form-group m-form__group">
        <input required class="form-control m-input" type="password" placeholder="{{trans('auth.password_confirmation')}}" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="off" >
        @if ($errors->has('password_confirmation'))
        <hr>
        @foreach($errors->get('password_confirmation') as $errorMessage)
        <div class="text-center text-danger">
            {{ $errorMessage }}
        </div>
        <hr>
        @endforeach
        @endif
    </div>

    <div class="m-login__form-action">
        <button type="submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
            {{trans('auth.request')}}
        </button>
        &nbsp;&nbsp;
        <a href="{{route('login')}}" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
            {{trans('auth.cancel')}}
        </a>
        
    </div>
</form>

@endsection

@push('custom-js')
<script>
    $('#row-form').validate({
    
    rules:{
        
        'email':{
            required:true,
            email:true
        },
        'password':{
            required:true,
            minlength: 7
        },
        'password_confirmation':{
            required:true,
            equalTo:'#password'
        }
        
        
    }, 
    'messages':{
        'email':{
            required:"Email field is required!",
            email:"Please enter a valid Email!"
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