<?php

namespace App\Http\Controllers\OAuth;

use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use App\Http\Controllers\Controller;
use Laravel\Passport\ClientRepository;

class ClientCredentialsController extends Controller
{
    private $clientRepository;

    public function __construct()
    {
        $this->clientRepository = new ClientRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Passport::client()
            ->where('user_id', null)
            ->where('personal_access_client', 0)
            ->where('password_client', 0)
            ->orderBy('name', 'asc')->paginate();

        return view('oauth.client-credentials.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('oauth.client-credentials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:oauth_clients,name'],
        ]);

        $client = $this->clientRepository->create(
            null,
            $request->name,
            ''
        );

        if ($client) {
            $request->session()->flash('success', "{$client->name} cadastrado com sucesso.");
            $request->session()->flash('warning', "A chave secreta do cliente será mostrada somente desta vez, não a perca!!!");
            $request->session()->flash('info', "Chave Secreta: {$client->plainSecret}");
        } else {
            $request->session()->flash('error', "Falha ao cadastrar Client Credendtials");
        }

        return redirect()->route('oauth.client-credentials.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = $this->clientRepository->find($id);

        return view('oauth.client-credentials.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = $this->clientRepository->findActive($id);
        $this->clientRepository->delete($client);

        if ($this->clientRepository->revoked($id)) {
            session()->flash('success', "{$client->name} revogado com sucesso.");
        } else {
            session()->flash('error', "Falha ao revogar Client Credendtials");
        }

        return redirect()->route('oauth.client-credentials.index');
    }
}
