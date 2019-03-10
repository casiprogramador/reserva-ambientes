<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AmbienteRequest;
use App\Model\Ambiente;
use Illuminate\Http\Response;
use App\Http\Resources\Ambiente as AmbienteResource;

class AmbienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AmbienteResource(Ambiente::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AmbienteRequest $request)
    {
        $ambiente = new Ambiente;

        $ambiente->nombre = $request->nombre;
        $ambiente->direccion = $request->direccion;
        $ambiente->color = $request->color;

        $ambiente->save();
        //return response()->json($ambiente, Response::HTTP_CREATED);
        return (new AmbienteResource($ambiente))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new AmbienteResource(Ambiente::find($id));
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
        $ambiente = Ambiente::find($id);

        $ambiente->nombre = $request->nombre;
        $ambiente->direccion = $request->direccion;
        $ambiente->imagen = $request->imagen;

        $ambiente->save();
        return (new AmbienteResource($ambiente))->response()->setStatusCode(Response::HTTP_ACCEPTED);
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
