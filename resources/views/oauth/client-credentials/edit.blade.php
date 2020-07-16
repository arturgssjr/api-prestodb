@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">

        {!! Form::model($client, ['route' => ['oauth.client-credential.update', $client->id], 'method' => 'POST']) !!}
        @method('PUT')

        @include('oauth.client-credentials._form')

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                {!! Form::submit('Alterar', ['class' => 'btn btn-warning']) !!}
                <a href="{{ route('oauth.client-credentials.index') }}" class="btn btn-dark">Cancelar</a>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>
@endsection
