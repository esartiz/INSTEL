<div class="box box-info padding-1">
    <div class="box-body row">
        <div class="form-group col-md-3">
            <div class="mb-3">
              <label for="start_date" class="form-label">Mostrar desde:</label>
              <input type="datetime-local" class="form-control" name="start_date" id="start_date" value="{{ $mensaje->start_date }}" required>
            </div>
        </div>

        <div class="form-group col-md-3">
            <div class="mb-3">
              <label for="end_date" class="form-label">Mostrar hasta:</label>
              <input type="datetime-local" class="form-control" name="end_date" id="end_date" value="{{ $mensaje->end_date }}" required>
            </div>
        </div>

        <div class="form-group col-md-6">
            <div class="mb-3">
              <label for="asunto" class="form-label">Asunto:</label>
              <input type="text" class="form-control" name="asunto" id="asunto" value="{{ $mensaje->asunto }}" required>
            </div>
        </div>

        <div class="form-group col-md-12">
            <div class="mb-3">
              <label for="mensaje" class="form-label">Mensaje:</label>
              <textarea class="ckeditor" name="mensaje" id="mensaje" rows="8">{{ $mensaje->mensaje }}</textarea>
            </div>
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">ENVIAR</button>
    </div>
</div>

@section('scripts')
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
@endsection