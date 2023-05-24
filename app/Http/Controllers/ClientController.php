<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of all the clients and the services recruited by each one of them.
     */
    public function index()
    {
        //
        $clients = Client::all();

        if ($clients -> count() > 0) {
            return response() -> json([
                'status' => 200,
                'clients' => $clients
            ], 200);
        } else {
            return response() -> json([
                'status' => 404,
                'message' => 'No clients found'
            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a new client at the database.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request -> all(), [
            'name' => 'required|max:50',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits_between:9,15',
            'address' => 'required|max:250'
        ]);

        if($validator -> fails()) {
            return response() -> json([
                'status' => 422,
                'errors' => $validator -> messages(),
            ], 422);
        } else {
            $client = Client::create([
                'name' => $request -> name,
                'email' => $request -> email,
                'phone' => $request -> phone,
                'address' => $request -> address
            ]);

            if($client) {
                return response() -> json([
                    'status' => 201,
                    'message' => 'Client created successfully'
                ], 201);
            } else {
                return response() -> json([
                    'status' => 500,
                    'message' => 'Unexpected error'
                ], 500);
            }
        }
    }

    /**
     * Get the client information and all the services recruited using a client ID as a parameter.
     */
    public function show($clientId)
    {
        $client = Client::find($clientId);

        if ($client) {

            return response() -> json([
                'status' => 200,
                'client' => $client
            ], 200);

        } else {

            return response() -> json([
                'status' => 404,
                'message' => "The ID doesn't matches with any client"
            ], 404);

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($clientId)
    {
        $client = Client::find($clientId);

        if ($client) {

            return response() -> json([
                'status' => 200,
                'client' => $client
            ], 200);

        } else {

            return response() -> json([
                'status' => 404,
                'message' => "The ID doesn't matches with any client"
            ], 404);

        }
    }

    /**
     * Update the client information using its ID as parameter.
     */
    public function update(Request $request, int $clientId)
    {
        $validator = Validator::make($request -> all(), [
            'name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'phone' => 'required|digits_between:9,15',
            'address' => 'required|max:250'
        ]);

        if($validator -> fails()) {
            return response() -> json([
                'status' => 422,
                'errors' => $validator -> messages(),
            ], 422);
        } else {
            $client = Client::find($clientId);

            if($client) {

                $client -> update([
                    'name' => $request -> name,
                    'email' => $request -> email,
                    'phone' => $request -> phone,
                    'address' => $request -> address
                ]);

                return response() -> json([
                    'status' => 200,
                    'message' => 'Client updated successfully'
                ], 200);
            } else {
                return response() -> json([
                    'status' => 404,
                    'message' => 'The ID is not associated with any client'
                ], 404);
            }
        }
    }

    /**
     * Removes a client from the database using the client's ID.
     */
    public function destroy($clientId)
    {
        $client = Client::find($clientId);

        if($client)
        {
            $client -> delete();
            return response() -> json(
                [
                    'status' => 200,
                    'message' => 'Client deleted successfully',
                ], 200
            );
        }
        else {
            return response() -> json(
                [
                    'status' => 404,
                    'message' => "The ID doesn't match any client"
                ], 404
            );
        }

    }


    /**
     * Attach a service to a client.
     */

    public function attach(Request $request)
    {
        $validator = Validator::make($request -> all(), [
            'client_id' => 'required|integer',
            'service_id' => 'required|integer'
        ]);

        if ($validator -> fails()) {
            return response() -> json([
                'status' => 422,
                'errors' => $validator -> messages()
            ], 422);
        } else {
            $client = Client::find($request -> client_id);
            $service = Service::find($request -> service_id);

            if (!$client || !$service) {
                return response() -> json([
                    'status' => 404,
                    'message' => 'The client or the service ID is not valid'
                ], 404);
            } else {
                $exists = $client -> services -> contains($service);
                if ($exists) {
                    return response() -> json([
                        'status' => 400,
                        'message' => 'The client is already attached to this service'
                    ], 400);
                } else {
                    $client -> services() -> attach($service);
                    return response() -> json([
                    'status' => 201,
                    'message' => 'The service has been attached successfully'
                    ], 201);
                }
            }
        }
    }

    /**
     * Detach a service to a client.
     */
    public function detach(Request $request)
    {
        $validator = Validator::make($request -> all(), [
            'client_id' => 'required|integer',
            'service_id' => 'required|integer'
        ]);

        if ($validator -> fails()) {
            return response() -> json([
                'status' => 422,
                'errors' => $validator -> messages()
            ], 422);
        } else {
            $client = Client::find($request -> client_id);
            $service = Service::find($request -> service_id);

            if (!$client || !$service) {
                return response() -> json([
                    'status' => 404,
                    'message' => 'The client or the service ID is not valid'
                ], 404);
            } else {
                if ($client -> services() -> exists($client)) {
                    $client -> services() -> detach($service);
                    return response() -> json([
                    'status' => 201,
                    'message' => 'The service has been detached successfully'
                    ], 201);
                } else {
                    return response() -> json([
                        'status' => 400,
                        'message' => 'The client has been already detached to this service'
                    ], 400);
                }
            }
        }
    }
}
