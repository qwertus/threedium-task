@extends('layouts.auth')
@section('title')
Forgotten Password
@endsection

@section('content')
@if (session('status'))
<div class="text-center alert alert-success">
    {{ session('status') }}
</div>
@endif

<div class="m-login__head">
    <hr>
    <h3 class="m-login__title">
        {{trans('auth.forget_password')}}
    </h3>
    <hr>
    <div class="m-login__desc">
        {{trans('auth.reset_email')}}
    </div>
</div>
<form method="POST" id="row-form" class="m-login__form m-form" action="{{ route('password.email') }}">
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
    <div class="m-login__form-action">
        <button type="submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
            {{trans('auth.request')}}
        </button>
        <a href="{{route('login')}}" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
            {{trans('auth.cancel')}}
        </a>
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
        }
        
        
    }, 
    'messages':{
        'email':{
            required:"Email field is required!",
            email:"Please enter a valid Email!"
        }
    }
});
</script>
@endpush


