<form method="POST" action="{{ route('financieroAddEst')}}" id="pagoForm" role="form" enctype="multipart/form-data">
    @method('POST')
    <input type="hidden" name="nConceptos" id="nConceptos" value="{{ $conceptos->count() }}">
    @csrf
    <h5 class="modal-title" id="modalChTitulo"></h5>
    <div class="row">
        <div class="col-6">
            <label for="" class="form-label">Documento</label>
            <input type="text" class="form-control" id="f_buscaDoc" value="{{ $datosUser->doc }}" required>
            <input type="hidden" name="userPay" id="idUserNpay">
        </div>

        <div class="col-3">
            <label for="" class="form-label">Recibo</label>
            <input type="text" class="form-control" name="idRecibo" id="f_idRecibo" value="{{ $nRecibo }}">
        </div>

        <div class="col-3">
            <label for="" class="form-label">Fecha</label>
            <input type="date" class="form-control" name="fecha" id="f_fecha" value="{{ (isset($conceptos->first()->fecha) ? $conceptos->first()->fecha : date('Y-m-d')) }}">
        </div>

        <div class="boxConceptoLw" style="display: none">
            <div class="row m-3 p-3" id="boxConcepto" style="border: 1px solid #00468C">
                <div class="col-2">
                    <label for="refID" class="form-label">Abona a deuda</label>
                    <select class="form-select refID" id="refID" name="pagareID[]"></select>
                </div>
                <div class="col-2">
                    <label for="cuota" class="form-label">Relación deuda</label>
                    <select class="form-select" onchange="fullNextInput(this)" name="cuota[]" id="cuota">
                        <option value="" selected>N/A</option>
                        @for ($i = 1; $i < 10; $i++)
                            <option value="{{ $i }}">Cuota {{ $i }}</option>
                            <option value="{{ $i + 100 }}">Mora Cuota {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-5">
                    <label for="f_concept" class="form-label">Concepto</label>
                    <input type="text" class="form-control" name="concept[]" id="f_concept">
                </div>
                <div class="col-3">
                    <label for="f_valor" class="form-label">Valor</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" name="valor[]" id="f_valor">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
            </div>
        </div>

        <div id="containerConceptos">
            @foreach ($conceptos as $item)
            <div class="row m-3 p-3" id="boxConcepto" style="border: 1px solid #00468C">
                <div class="col-2">
                    <label for="refID" class="form-label">Abona a deuda</label>
                    <select class="form-select refID" id="refID" data-selected-value="{{ $item->pagareID }}" name="pagareID_{{ $loop->iteration }}"></select>
                </div>
                <div class="col-2">
                    <label for="cuota" class="form-label">Relación deuda</label>
                    <select class="form-select" onchange="fullNextInput(this)" name="cuota_{{ $loop->iteration }}" id="cuota">
                        <option value="" selected>N/A</option>
                        @for ($i = 1; $i < 10; $i++)
                            <option value="{{ $i }}" @if ($item->cuota == $i) selected="selected" @endif>Cuota {{ $i }}</option>
                            <option value="{{ $i + 100 }}" @if ($item->cuota == $i + 100) selected="selected" @endif>Mora Cuota {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-5">
                    <label for="f_concept" class="form-label">Concepto</label>
                    <input type="text" class="form-control" name="concept_{{ $loop->iteration }}" id="f_concept" value="{{ $item->concept }}">
                </div>
                <div class="col-3">
                    <label for="f_valor" class="form-label">Valor</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" name="valor_{{ $loop->iteration }}" id="f_valor" value="{{ $item->valor }}">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-12 text-center mt-3">
            <button type="button" class="btn btn-sm btn-primary" onclick="addConcepto()">+ Add Concepto</button>
        </div>

        <div class="col-3">
            <label for="" class="form-label">Forma de Pago</label>
            <input type="text" class="form-control" name="formaPago" id="f_formaPago" value="{{ (isset($conceptos->first()->formaPago) ? $conceptos->first()->formaPago : '') }}">
        </div>

        <div class="col-6">
            <label for="" class="form-label">Observaciones</label>
            <input type="text" class="form-control" name="observ" id="f_observ" value="{{ (isset($conceptos->first()->observ) ? $conceptos->first()->observ : '') }}">
        </div>
        <div class="col-3" id="elArchivo">
            <label for="" class="form-label">Comprobante</label>
            <input type="hidden" name="comprobanteID" value="{{ (isset($conceptos->first()->idConcepto) ? $conceptos->first()->idConcepto : NULL) }}">
            @if (isset($conceptos->first()->idConcepto))
            <a href="/userfiles/financiero|{{ $conceptos->first()->idConcepto }}" target="_blank">[ Ver Comprobante ]</a>
            @endif
            <input type="file" class="form-control" name="comprobante" accept="image/*, application/pdf">
        </div>
    </div>

    <div class="text-center mt-4">
        <div class="d-grid gap-2">
          <button type="submit" name="" id="btPagoBox" class="btn btn-success">GUARDAR</button>
        </div>
    </div>
</form>

<script>
    var idConceptoN = {{ $conceptos->count() }};
    
    $('#f_buscaDoc').change(function() {
        buscaDoc();
    });

    $('#refID').change(function() {
        $('#pagareID').val($(this).val())
    })

    function buscaDoc() {

        $('#btPagoBox').hide();

        $.getJSON("/buscaest/" + $('#f_buscaDoc').val(), function(data) {
            if(data){
                $('#btPagoBox').show();
            }
            console.log("Procesar pago de " + (data.nombres + ' ' + data.apellidos).toUpperCase())

            $('#modalChTitulo').text("Procesar pago de " + (data.nombres + ' ' + data.apellidos).toUpperCase())
            $('#idUserNpay').val(data.id);
            $('.refID').append('<option value="">No</option>');
            data.refID.forEach(element => {
                $('.refID').append('<option value="' + element.contratoID + '">' + element.contratoID + '</option>');
            });
            $('#cajaBtProcesar').show();

            $('.refID').each(function() {
                $(this).val($(this).data('selected-value'));
            })
        });

    }

    function fullNextInput(tt) {
        let gg = $(tt).val();
        let nominal = ["", "PRIMERA", "SEGUNDA", "TERCERA", "CUARTA", "QUINTA", "SEXTA", "SÉPTIMA", "OCTAVA", "NOVENA",
            "DÉCIMA"
        ];
        var $input2 = $(tt).closest('.row').find('#f_concept');
        console.log("Fafafaaf")
        $input2.val((gg > 100 ? 'PAGO INTERESES ' + nominal[(gg - 100)] + ' CUOTA' : 'PAGO ' + nominal[gg] + ' CUOTA'));
    }

    function addConcepto() {
        idConceptoN++;

        var clonedDiv = $('#boxConcepto').clone();
        clonedDiv.find('input').val('');
        clonedDiv.find('select').val('');

        // Assign unique names to the input fields in the cloned div
        clonedDiv.find('input').each(function() {
            var originalName = $(this).attr('name');
            var newName = originalName.replace('[]', '_' + idConceptoN);
            $(this).attr('name', newName);
        });
        clonedDiv.find('select').each(function() {
            var originalName = $(this).attr('name');
            var newName = originalName.replace('[]', '_' + idConceptoN);
            $(this).attr('name', newName);
        });

        $('#containerConceptos').append(clonedDiv);
        $('#nConceptos').val(idConceptoN);
    }

    buscaDoc();
</script>
