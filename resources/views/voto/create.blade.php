@extends('plantilla')
@section('content')
<style>
    .uper {
        margin-top: 40px;
    }
</style>
<div class="card uper">
    <div class="card-header">
        votos
    </div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
        @endif
        <form method="post" action="{{ route('voto.store') }} " 
        enctype="multipart/form-data">
        
            @csrf 
            <div class="form-group">
                <label for="eleccion">Eleción:</label>
                <select name="eleccion_id" id="eleccion">
                @foreach ($elecciones as $eleccion)
                    <option value="{{$eleccion->id}}">{{$eleccion->periodo}}</option>
                @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="casilla">Casilla:</label>
                <select name="casilla_id" id="casilla">
                @foreach ($casillas as $casilla)
                    <option value="{{$casilla->id}}">{{$casilla->ubicacion}}</option>
                @endforeach
                </select>
            </div>
            <div class="form-group">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Candidato</th>
                            <th>votos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidatos as $candidato)
                            <tr>
                                <td>{{$candidato->nombrecompleto}}</td>
                                <td>
                                    <input type="number" name="candidato_{{$candidato->id}}" >
                                </td>
                            </tr>                    
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="form-group">
                <label for="evidencia">Evidencia:</label>
                <input type="file" id="evidencia" accept="application/pdf" class="form-control" name="evidencia" onclick="loadFile()" />
                <div style="margin: 10px;"></div>
                <embed src="src" id="src" style="width: 55vw; min-width: 140px;">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</div>
<script>
    var MAX_SIZE = 2048;
    let loadFile = () => {
        //Obtener el file
        let a = document.getElementById("evidencia").files[0].size;
        //Dividir para tener una relacion con el tamaño de php.ini -> 2M
        a = (a / 1024);
        if (a > MAX_SIZE) {
            alert("archivo muy grande, tamaño actual ");
            //setear a null la eleccion
            document.getElementById('evidencia').value = null;
        } else {
            alert("Archivo aceptable ");
            let src = document.getElementById("src");
            console.log("Existe el -> "+ src)
            src.src= URL.createObjectURL(event.target.files[0])
        }
    }
</script> 
@endsection