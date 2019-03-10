<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Reserva;
use App\Http\Resources\ReservaResource as ReservaResource;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReservaResource::collection(Reserva::all());
    }

    public function reservasByAmbiente($id_ambiente){
        return ReservaResource::collection(Reserva::where('ambiente_id',$id_ambiente)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reserva = new Reserva;

        $reserva->fecha = $request->fecha;
        $reserva->hora_inicio = $request->hora_inicio;
        $reserva->hora_fin = $request->hora_fin;
        $reserva->motivo = $request->motivo;
        $reserva->ambiente_id = $request->ambiente_id;
        $reserva->user_id = $request->user_id;
        $reserva->save();
        return (new ReservaResource($reserva))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
    }
}
