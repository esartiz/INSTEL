<div class="row" style="margin-top: 20px">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                {{ $boxM->getPrograma()->nombre }} - Tienes <b>{{ $misModulos->count() }} Módulos</b> por desarrollar
            </div>
            <div class="card-body row">
                @foreach ($misModulos as $item)
                    @php
                        $tiempos = AppHelper::timeModule($item->modulos_s, $dataMatriculaF->periodo);
                        foreach ($tiempos as $key) {
                            array_push($autoeval, [$item->modulos_s->titulo, $key[2], $item->modulos_s->id, 1]);
                            array_push($autoeval, [$item->modulos_s->titulo, $key[1], $item->modulos_s->id, 2]);
                        }
                        //echo $tiempos[0][0]. '----'.$tiempos[0][1];
                        $extraCss1 = '';
                        $extraCss2 = '';
                        $extraCss3 = '';
                        if (now() >= $tiempos[0][0] && now() <= $tiempos[0][1]) {
                            $extraCss1 = ' style="border: 3px solid #f23838 !important;"';
                            $extraCss2 = ' style="background-color: #f23838"';
                            $extraCss3 = ' style="color: #FFF"';
                        }
                        $notaPromedio = number_format($item->n1 * 0.3 + $item->n2 * 0.3 + $item->n3 * 0.4, 1, '.', '');
                    @endphp
                    <div class="col-md-4">
                        <div class="productCardContainer h-100">
                            <div class="productCardContent h-100" {!! $extraCss1 !!}>
                                <div class="productCardImage">
                                    <img src="{{ route('ft', 'img|modulos|' . $item->modulos_s->image) }}"
                                        alt="" />
                                    <a href="{{ route('estudiante.md', $item->modulos_s->id) }}"
                                        class="imageCardEffect"></a>
                                </div>
                                <div class="productCardDetails">
                                    <div class="productCardModel" {!! $extraCss2 !!}>
                                        <span class="modelCardEffect"></span>
                                        <a {!! $extraCss3 !!}
                                            href="{{ route('estudiante.md', $item->modulos_s->id) }}">{{ $item->modulos_s->titulo }}</a>
                                    </div>
                                    <div class="table-responsive-sm">
                                        <table class="table table-light text-center" style="font-size: 12px">
                                            <thead>
                                                <tr>
                                                    <th scope="col">AU 1<br>(30%)</th>
                                                    <th scope="col">AU 2<br>(30%)</th>
                                                    <th scope="col">AU 3<br>(40%)</th>
                                                    <th scope="col">DEF<br>(100%)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="">
                                                    <td class="notaMod">{{ $item->n1 }}</td>
                                                    <td class="notaMod">{{ $item->n2 }}</td>
                                                    <td class="notaMod">{{ $item->n3 }}</td>
                                                    <td class="notaMod">{{ $notaPromedio }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        Asistencias:
                                                        {{ Auth::user()->misAsistencias()->where('modulo', $item->modulos_s->id)->where('presencia', 1)->count() }}
                                                        de
                                                        {{ Auth::user()->misAsistencias()->where('modulo', $item->modulos_s->id)->count() }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="productCardPrice">
                                        <a href="{{ route('estudiante.md', $item->modulos_s->id) }}"
                                            class="btn">
                                            ENTRAR
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>