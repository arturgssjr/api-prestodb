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
        <th scope="col" class="text-center">Status</th>
        <th scope="col" class="text-center">Data de Cadastro</th>
        <th scope="col" class="text-center">Data da Última Atualização</th>
        <th scope="col" class="text-center">Ações</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td scope="row" class="text-center">{{ $client->id }}</td>
        <td class="text-center">{{ $client->name }}</td>
        <td class="text-center">
            <span class="badge badge-{{ $client->revoked ? 'danger' : 'success' }}">{{ $client->revoked ? 'Revogado' : 'Ativo' }}</span>
        </td>
        <td class="text-center">{{ $client->created_at->format('d/m/Y H:i:s') }}</td>
        <td class="text-center">{{ $client->updated_at->format('d/m/Y H:i:s') }}</td>
        <td class="text-center">
            <a href="{{ route('oauth.client-credentials.edit', $client->id) }}" class="btn btn-sm btn-warning" title="Alterar cliente" data-toggle="tooltip" data-placement="top" role="button">
                <i class="fas fa-pencil-alt"></i>
            </a>
        </td>
    </tr>
    </tbody>
</table>
@if($client->tokens()->count() > 0)
<table class="table table-striped table-sm">
    <thead class="thead-dark">
        <tr>
            <th colspan="6" class="text-center" scope="col">Tokens</th>
        </tr>
        <tr>
            <th scope="col" class="text-center">ID</th>
            <th scope="col" class="text-center">Scopes</th>
            <th scope="col" class="text-center">Data de Criação</th>
            <th scope="col" class="text-center">Data de Expiração</th>
            <th scope="col" class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($client->tokens()->get() as $token)
        <tr>
            <td class="text-center">***{{ Str::substr($token->id, 10, 15) }}***</td>
            <td class="text-center">{{ empty($token->scopes) ? 'Scopes vazio.' : implode(', ', $token->scopes) }}</td>
            <td class="text-center">{{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s',$token->created_at)->format('d/m/Y H:i:s') }}</td>
            <td class="text-center">{{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s',$token->expires_at)->format('d/m/Y H:i:s') }}</td>
            <td class="text-center"><span class="badge badge-{{ $token->revoked ? 'danger' : 'success' }}">{{ $token->revoked ? 'Revogado' : 'Ativo' }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-info text-center">Nenhum token cadastrado para este Client Credentials.</div>
@endif
@endsection
