@extends('layouts.app')

@section('content')
<a class="btn btn-sm btn-info mb-1" data-toggle="tooltip" data-placement="top" title="Voltar" role="button"
    href="{{ route('oauth.client-credentials.index') }}">
    <i class="fas fa-arrow-left"></i>
    Voltar
</a>
<table class="table table-sm">
    <thead class="thead-dark">
    <tr>
        <th scope="col" class="text-center">Client ID</th>
        <th scope="col" class="text-center">Nome</th>
        <th scope="col" class="text-center">Data de Cadastro</th>
        <th scope="col" class="text-center">Data da Última Atualização</th>
        <th scope="col" class="text-center">Ações</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td scope="row" class="text-center">{{ $client->id }}</td>
        <td class="text-center">{{ $client->name }}</td>
        <td class="text-center">{{ $client->created_at }}</td>
        <td class="text-center">{{ $client->updated_at }}</td>
        <td class="text-center">
            <a href="{{ route('oauth.client-credentials.edit', $client->id) }}" class="btn btn-sm btn-warning" title="Alterar cliente" data-toggle="tooltip" data-placement="top" role="button">
                <i class="fas fa-pencil-alt"></i>
            </a>
        </td>
    </tr>
    </tbody>
        </table>
@endsection
