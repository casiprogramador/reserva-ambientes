<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Reserva;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;
use App\Mail\ReservacionEmail;
use App\Http\Resources\ReservaResource as ReservaResource;
use App\Jobs\SendEmailJob;
use Log;

class ReservaController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JWT');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReservaResource::collection(Reserva::all());
    }

    public function reservasByAmbiente($id_ambiente,$mes){
        return ReservaResource::collection(Reserva::where('ambiente_id',$id_ambiente)->whereMonth('fecha', '=', $mes)->get());
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
        $this->enviarNotificacion($reserva);
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

        $destroy = Reserva::destroy($id);
        if ($destroy){
            $data=[
                'status'=>'1',
                'msg'=>'success'
            ];
        
        }else{
        
            $data=[
                'status'=>'0',
                'msg'=>'fail'
            ];
        
        }

        return response()->json($data, 200); 

    }

    public function enviarNotificacion($reserva){
        /* $when = now()->addMinutes(1);
        Mail::to("mchoque@coboser.com")->later($when,new ReservacionEmail());
        dump('procesando');
        return 'Mensaje enviado'; */
        $email = new ReservacionEmail($reserva);
        Log::info("Request cycle without Queues started");
        //$this->dispatch(new SendEmailJob());
        Mail::to("mchoque@coboser.com")->send($email);
        Log::info("Request cycle without Queues finished");
    }
}
