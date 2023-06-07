<?php

namespace App\Http\Controllers;

use App\Entities\VehicleEntity;
use App\Services\VehicleService;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function __construct(
        protected VehicleService $vehicleSvc
    ) {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->vehicleSvc->getVehicles();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * @var VehicleEntity
         */
        $data = VehicleEntity::validateAndCreate($request->all());

        $this->vehicleSvc->store($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->vehicleSvc->getVehicleByID($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /**
         * @var VehicleEntity
         */
        $data = VehicleEntity::validateAndCreate($request->all());

        $this->vehicleSvc->update($data, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->vehicleSvc->destroy($id);
    }
}
