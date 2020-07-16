<div class="form-group row">
    {!! Form::label('name', 'Nome do Cliente', ['class' => 'col-md-4 col-form-label text-md-right']) !!}
    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => 'form-control' . (!empty($errors->first('name')) ? ' is-invalid' : ''), 'autofocus']) !!}
        @include('layouts._errors', ['field' => 'name'])
    </div>
</div>
