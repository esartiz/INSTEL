@php
    $datosIter = ($tipo == 0 ? $user->modulosAsignados()->get() : $modulo->docentes());
@endphp

<table class="table table-striped usuariosTable">
    <thead>
        <tr>
            <th scope="col">{{ ($tipo == 0 ? 'Módulo' : 'Docente') }}</th>
            <th scope="col">Grupo</th>
            <th scope="col">Estudiantes</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datosIter as $item)
            <tr id="boxAsignacion_{{ $item->id }}">
                <td scope="row">
                    @if ($tipo == 0)
                    <a href="/modulos/{{ $item->modulo }}/edit">{{ $item->modulo()->titulo }}</a>
                    @else
                    <a href="/users/{{ $item->user }}/edit">{{ $item->user()->apellidos }} {{ $item->user()->nombres }}</a>
                    @endif
                </td>
                <td><span class="text-danger forGrupo" dt-f="{{ $item->grupo }}">{{ $item->grupo }}</span></td>
                <td>{{ $item->estudiantesAsignados()->where('grupo', $item->grupo)->count() }}</td>
                <td>
                    @if ($item->estado == 0)
                    <button type="button" onclick="editAsg({{ $item->id }}, 1)" class="btn btn-sm btn-primary" id="btn_{{ $item->id }}">Archivar</button>
                    @else
                    <button type="button" onclick="editAsg({{ $item->id }}, 0)" class="btn btn-sm btn-secondary"  id="btn_{{ $item->id }}">Desarchivar</button>
                    @endif
                </td>
                <td>
                    <button type="button" onclick="editAsg({{ $item->id }}, 'delete')" class="btn btn-sm btn-danger">Eliminar</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    function editAsg(vt, dt) {
            if (confirm('¿Estás seguro de que ' + (dt === 'delete' ? 'eliminar esta asignación?. Esta acción es definitiva y no puede reversarse' : 'cambiar esta asignación?'))) {
                $.ajax({
                    url: "{{ route('cambiarAsignacion') }}",
                    method: 'POST',
                    data: {
                        vt: vt,
                        dt: dt,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response);
                        if (dt === 'delete') {
                        document.getElementById("boxAsignacion_" + vt).style.display = 'none';
                        } else {
                            var button = document.getElementById("btn_" + vt);
                            if (dt == 1) {
                                button.classList.remove('btn-primary');
                                button.classList.add('btn-secondary');
                                button.textContent = 'Desarchivar';
                                button.setAttribute('estado', 1);
                            } else {
                                button.classList.remove('btn-secondary');
                                button.classList.add('btn-primary');
                                button.textContent = 'Archivar';
                                button.setAttribute('estado', 0);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Manejar errores aquí
                        console.error('Error:', xhr, status, error);
                    }
                });
            }
        }
</script>