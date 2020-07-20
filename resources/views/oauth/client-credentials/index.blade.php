@extends('layouts.app')

@section('content')
@includeIf('layouts._confirmation-modal')
<a class="btn btn-sm btn-success mb-1" data-toggle="tooltip" data-placement="top" title="Cadastrar novo Client Credential"
    role="button" href="{{ route('oauth.client-credentials.create') }}">
    <i class="fas fa-plus-circle"></i>
    Novo Client Credential
</a>
@if($clients->count() > 0)
<table class="table table-striped table-sm">
    <thead class="thead-dark">
        <tr>
            <th scope="col" class="text-center">Client ID</th>
            <th scope="col" class="text-center">Nome</th>
            <th scope="col" class="text-center">Status</th>
            <th scope="col" class="text-center">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clients as $client)
        <tr>
            <td class="text-center">{{ $client->id }}</td>
            <td>{{ $client->name }}</td>
            <td class="text-center">
                <span class="badge badge-{{ $client->revoked ? 'danger' : 'success' }}">{{ $client->revoked ? 'Revogado' : 'Ativo' }}</span>
            </td>
            <td class="text-center">
                <a href="{{ route('oauth.client-credentials.show', $client->id) }}" class="btn btn-sm btn-info"
                    title="Visualizar cliente" data-toggle="tooltip" data-placement="top" role="button">
                    <i class="fa fa-info-circle"></i>
                </a>
                <a href="{{ route('oauth.client-credentials.edit', $client->id) }}" class="btn btn-sm btn-warning" title="Alterar cliente" data-toggle="tooltip" data-placement="top" role="button">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <button class="btn btn-sm btn-danger load-confirmation-modal"
                    data-toggle="tooltip"
                    data-placement="top" title="Excluir cliente" role="button"
                    data-url="{{ route('oauth.client-credentials.destroy', $client->id) }}" data-type="Client Credentials"
                    data-name="{{ $client->name }}" data-target="#confirmation-modal"
                    data-toggle="modal">
                <i class="fas fa-trash-alt"></i>
            </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info text-center">Nenhum Client Credentials cadastrado.</div>
@endif
@endsection
