<?php

namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Api\GenericController as GenericController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use App\Models\Candidato;
    use Illuminate\Support\Facades\DB;

    class CandidatoController extends GenericController
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $candidatos = Candidato::all();
            $resp = $this->sendResponse($candidatos, "Listado de candidatos");
            return ($resp);
        }
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            
        }
        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            $validacion = Validator::make($request->all(), [
            'nombrecompleto' => 'unique:candidato|required|max:200',
            'sexo' =>'required']);

            if ($validacion->fails())
            return $this->sendError("Error de validacion", $validacion->errors());

            $fotocandidato=""; $perfilcandidato="";

            if ($request->hasFile('foto')){
            $foto = $request->file('foto');
            $fotocandidato= $foto->getClientOriginalName();
            }
            if ($request->hasFile('perfil')){
            $perfil = $request->file('perfil');
            $perfilcandidato = $perfil->getClientOriginalName();
            }

            $campos = array(
            'nombrecompleto' => $request->nombrecompleto,
            'sexo' => $request->sexo,
            'foto' => $fotocandidato,
            'perfil' => $perfilcandidato,
            );

            if ($request->hasFile('foto')) $foto->move(public_path('image'), $fotocandidato);
            if ($request->hasFile('perfil')) $perfil->move(public_path('pdf'), $perfilcandidato);

            $candidato = Candidato::create($campos);
            $resp = $this->sendResponse($candidato, "Guardado...");
            return($resp);
        } 
        //--- End store
        /**
         * Display the specified resource.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
        //
        }
        /**
         * Show the form for editing the specified resource.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            $id = intval($id);
            $candidato = Candidato::find($id);
            return $this->send($candidato,$id);
        }
        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {   
                $candidato = Candidato::find($id);
                
                $fotocandidato=""; $perfilcandidato="";
    
                if ($request->hasFile('foto')){
                $foto = $request->file('foto');
                $fotocandidato= $foto->getClientOriginalName();
                }
                if ($request->hasFile('perfil')){
                $perfil = $request->file('perfil');
                $perfilcandidato = $perfil->getClientOriginalName();
                }
    
                $campos = array(
                'nombrecompleto' => $request->nombrecompleto,
                'sexo' => $request->sexo,
                'foto' => $fotocandidato,
                'perfil' => $perfilcandidato,
                );
    
                if ($request->hasFile('foto')) $foto->move(public_path('image'), $fotocandidato);
                if ($request->hasFile('perfil')) $perfil->move(public_path('pdf'), $perfilcandidato);
    
                $candidato = Candidato::update($campos);
                $resp = $this->sendResponse($candidato, "Actualizado...");
                return($resp);
        }
        private function send($data,$id) {
            if($data){
                $resp=$this->sendResponse($data,
                "Operacion satisfactoria...");
            }else {
                $this->sendError("No se encontro el candidato $id");
            }
            return ($resp);
        }
         /**
         * Remove the specified resource from storage.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */
    
        public function destroy($id)
        {
            $candidato = Candidato::find($id);
            DB::beginTransaction();
            try {
                if ($candidato){
                    Votocandidato::where('candidato_id','=',$id)->delete();
                }
                Candidato::whereId($id)->delete();
                DB::commit();
            } catch(\Exception  $ex){
                DB::rollBack();
            }

                return $this->send($candidato,$id);

        }
}

