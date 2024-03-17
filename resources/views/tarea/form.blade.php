<div class="box box-info padding-1">
    <div class="box-body row">
        <div class="form-group col-md-12">
            <div class="mb-3">
              <label for="" class="form-label">Enunciado de la Actividad</label>
              <textarea class="form-control" name="enunciado" id="enunciado" rows="3">{{$tarea->enunciado}}</textarea>
            </div>
        </div>
        
        <div class="form-group col-md-4">
            <div class="mb-3">
                <label for="act_rtatipo" class="form-label">Tipo de Respuesta</label>
                <select class="form-select" name="tipo_rta" id="act_rtatipo">
                <option value="texto">Texto</option>
                <option value="link">Link (Ej. Youtube)</option>
                <option value="audio">Audio</option>
                <option value="pdf">Archivo PDF</option>
                </select>
            </div>
        </div>

        <div class="form-group col-md-4">
            <div class="mb-3">
                <label for="act_fecha" class="form-label">Fecha máxima de entrega</label>
                <input type="datetime-local" class="form-control" name="limite" id="act_fecha" value="{{$tarea->limite}}">
            </div>
        </div>

        <div class="form-group col-md-4">
            <div class="mb-3">
              <label for="" class="form-label">Orden</label>
              <input type="number" class="form-control" name="ord" id="ord" value={{$tarea->ord}}>
            </div>
        </div>
        

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">GUARDAR INFORMACIÓN</button>
    </div>
</div>

@section('scripts')
        <script>
            $('.act_rtatipo').val("{{$tarea->tipo_rta}}");
        </script>
        @endsection