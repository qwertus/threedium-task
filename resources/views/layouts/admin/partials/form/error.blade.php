@if ($errors->has($field))
    <div class="form-control-feedback">
            {{ $errors->first($field) }}
    </div>
@endif
