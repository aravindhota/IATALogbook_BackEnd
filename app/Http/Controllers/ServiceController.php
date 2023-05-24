<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a list of all the services.
     */
    public function index()
    {
        //
        $services = Service::all();

        if ($services -> count() > 0) {
            return response() -> json([
                'status' => 200,
                'services' => $services
            ], 200);
        } else {
            return response() -> json([
                'status' => 404,
                'message' => 'No comercial services found'
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
     * Creates and post a new service to the database.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request -> all(), [
            'name' => 'required|max:30',
            'description' => 'required|max:500',
            'price' => 'required|digits_between:1,5'
        ]);

        if($validator -> fails()) {
            return response() -> json([
                'status' => 422,
                'errors' => $validator -> messages(),
            ], 422);
        } else {
            $service = Service::create([
                'name' => $request -> name,
                'description' => $request -> description,
                'price' => $request -> price
            ]);

            if($service) {
                return response() -> json([
                    'status' => 201,
                    'message' => 'Service created successfully'
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
     * Gets the information of a service using an ID as parameter.
     */
    public function show($serviceId)
    {
        $service = Service::find($serviceId);

        if ($service) {

            return response() -> json([
                'status' => 200,
                'service' => $service
            ], 200);

        } else {

            return response() -> json([
                'status' => 404,
                'message' => "The ID doesn't matches with any comercial service"
            ], 404);

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($serviceId)
    {
        $service = Service::find($serviceId);

        if ($service) {

            return response() -> json([
                'status' => 200,
                'service' => $service
            ], 200);

        } else {

            return response() -> json([
                'status' => 404,
                'message' => "The ID doesn't matches with any comercial service"
            ], 404);

        }
    }

    /**
     * Updates the information of a service using an ID as parameter.
     */
    public function update(Request $request, int $serviceId)
    {
        $validator = Validator::make($request -> all(), [
            'name' => 'required|max:30',
            'description' => 'required|max:500',
            'price' => 'required|digits_between:1,5'
        ]);

        if($validator -> fails()) {
            return response() -> json([
                'status' => 422,
                'errors' => $validator -> messages(),
            ], 422);
        } else {
            $service = Service::find($serviceId);

            if($service) {

                $service -> update([
                    'name' => $request -> name,
                    'description' => $request -> description,
                    'price' => $request -> price
                ]);

                return response() -> json([
                    'status' => 200,
                    'message' => 'Service updated successfully'
                ], 200);
            } else {
                return response() -> json([
                    'status' => 404,
                    'message' => 'The ID is not associated with any service'
                ], 404);
            }
        }
    }

    /**
     * Removes a service from the database.
     */
    public function destroy($serviceId)
    {
        $service = Service::find($serviceId);

        if($service)
        {
            $service -> delete();
            return response() -> json(
                [
                    'status' => 200,
                    'message' => 'Service deleted successfully',
                ], 200
            );
        }
        else {
            return response() -> json(
                [
                    'status' => 404,
                    'message' => "The ID doesn't match any service"
                ], 404
            );
        }
    }

    /**
     * Get the list of the clients who have hired a service using the service ID.
     */
    public function clients($serviceId)
    {
        $service = Service::find($serviceId);

        if ($service) {

            $clients = $service -> clients;

            if ($clients -> count() > 0) {
                return response() -> json([
                    'status' => 200,
                    'service' => $service,
                    'clients' => $clients
                ], 200);
            } else {
                return response() -> json([
                    'status' => 200,
                    'service' => $service,
                    'message' => 'No clients attached to the service selected.'
                ], 200);
            }

        } else {

            return response() -> json([
                'status' => 404,
                'message' => "The ID doesn't matches with any comercial service"
            ], 404);

        }
    }
}
