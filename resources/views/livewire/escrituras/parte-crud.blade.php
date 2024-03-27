<div>
    <div>
        @if ($this->libro == null)
            <div class="alert alert-info" role="alert">
                <i class="fa fa-info-circle"></i> Selecciona un libro de las escrituras para ver sus partes y
                modificarlas.
            </div>
        @endif
        <div class="text-small mb-3 row">
            <div class="col-3 text-end">Selecciona un libro: </div>
            <div class="col-9">
                <select wire:change="cambiarLibro($event.target.value)" class="form-control text-small"
                    style="width:200px">
                    <option value="">Seleccione un libro</option>
                    @foreach ($libros as $libro)
                        <option value="{{ $libro->id }}">{{ $libro->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    @if ($this->libro != null)
        <div class="card">
            <div class="card-header text-center">
                <h2 class="mb-0" id="libro_seleccionado">[{{ $this->libro->id }}] {{ $this->libro->nombre ?? '' }}
                </h2>
                <div><a href="{{ route('libros.show', $this->libro->nombre) }}" target="_blank">Ver libro de
                        {{ $this->libro->nombre ?? '' }}</a>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-6 px-1 mx-0">
                            <input type="text" id="textTitulo" name="textTitulo" class="form-control"
                                wire:model="titulo" placeholder="Título de la parte">
                        </div>
                        <div class="col-3 px-1 mx-0">
                            <select class="form-select form-control" id="capitulo_inicial" name="capitulo_inicial"
                                wire:model="capitulo_inicial_id">
                                <option value="">Capítulo Inicial</option>
                                @foreach ($capitulos as $capitulo)
                                    <option value="{{ $capitulo->id }}">{{ $capitulo->referencia }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3 px-1 mx-0">
                            <select class="form-select form-control" id="capitulo_final" name="capitulo_final"
                                wire:model="capitulo_final_id">
                                <option value="">Capítulo Final</option>
                                @foreach ($capitulos as $capitulo)
                                    <option value="{{ $capitulo->id }}">{{ $capitulo->referencia }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        @error('titulo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="text-end btn-group">
                        <button class="btn btn-small btn-success" id="btnGuardar" wire:click="guardar"
                            @if ($modoEdicion) style="display:none;" @endif>
                            <i class="fas fa-save"></i> Guardar
                        </button>
                        <button class="btn btn-small btn-warning" id="btnActualizar" wire:click="actualizar"
                            @unless ($modoEdicion) style="display:none;" @endunless>
                            <i class="fas fa-edit"></i> Actualizar
                        </button>
                        <button class="btn btn-small btn-secondary" id="btnLimpiar" onclick="limpiarFormulario()">
                            <i class="fas fa-eraser"></i> Limpiar
                        </button>
                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header text-center">
                    <h3>Estructura del libro de {{ $this->libro->nombre }}</h3>
                </div>
                <div class="card-body">
                    <div class="text-end">
                        <button class="btn btn-primary btn-sm mb-3" onclick="limpiarFormulario()"
                            title="Prepara el formulario para agregar una nueva parte">
                            <i class="fas fa-plus"></i> Nueva Parte
                        </button>
                    </div>
                    <div class="row" style="font-weight: bold;">
                        <div class="col-8 border">Parte</div>
                        <div class="col-1 border text-center">Inicial</div>
                        <div class="col-1 border text-center">Final</div>
                        <div class="col-1 border bg-dark">&nbsp;</div>
                        <div class="col-1 border bg-dark">&nbsp;</div>
                    </div>
                    @foreach ($partes as $parte)
                        <div class="row">
                            <div class="col-8 border">{{ $parte->nombre }}</div>
                            <div class="col-1 border text-center">
                                @if ($parte->capitulos->count() > 0)
                                    <a href="{{ route('capitulos.show', $parte->capitulos->first()->referencia) }}"
                                        style="text-decoration: none;" target="_blank">
                                        {{ $parte->capitulos->first()->num_capitulo ?? '' }}
                                    </a>
                                @else
                                    -
                                @endif
                            </div>
                            <div class="col-1 border text-center">
                                @if ($parte->capitulos->count() > 0)
                                    {{ $parte->capitulos->last()->num_capitulo ?? '' }}
                                @else
                                    -
                                @endif
                            </div>
                            <div class="col-1 border text-center">
                                <button class="btn btn-sm p-0" style="color: green;"
                                    onclick="entrarModoEdicion('{{ $parte->nombre }}','{{ $parte->id }}','{{ $parte->capitulos->first()->id }}','{{ $parte->capitulos->last()->id }}')"
                                    title="Editar esta parte">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </div>
                            <div class="col-1 border text-center">
                                <button class="btn btn-sm p-0" style="color: red;"
                                    wire:click="confirmarEliminacion({{ $parte->id }})" title="Eliminar esta parte">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
    @endif

    <script lang="javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Confirma la eliminación de la parte
            window.addEventListener('confirmarEliminacion', event => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esto.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, elimínala!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log('parteid');
                        console.log(event.detail.parteId);
                        @this.call('eliminar', event.detail[0].parteId);
                    }
                });
            });

            // Retroalimenta al usuario sobre el éxito o fracaso de una operación
            window.addEventListener('alertaOperacion', event => {
                console.log(event.detail[0]);
                Swal.fire({
                    icon: event.detail[0].type,
                    title: event.detail[0].title,
                    text: event.detail[0].text,
                    showConfirmButton: true,
                    timer: 1500
                });
            });

            // Despliega un mensaje de retroalimentación
            window.addEventListener('swal:modal', event => {
                console.log('Evento swal:modal');
                Swal.fire({
                    icon: event.detail[0].type,
                    title: event.detail[0].title,
                    text: event.detail[0].text,
                    confirmButtonText: 'Aceptar'
                });
            });

            window.addEventListener('reset-form', event => {
                limpiarFormulario();
            });

            // Limpia el formulario
            window.limpiarFormulario = function() {
                // Resetear el valor del título
                document.getElementById('textTitulo').value = '';

                // Resetear los selects de capítulo inicial y final
                document.getElementById('capitulo_inicial').value = '';
                document.getElementById('capitulo_final').value = '';

                // Ajustar visibilidad de botones
                document.getElementById('btnGuardar').style.display = 'block';
                document.getElementById('btnActualizar').style.display = 'none';
            }

            // Inicia la edición de una parte
            window.entrarModoEdicion = function(parteNombre, parteId, capitulo_inicial, capitulo_final) {
                @this.set('modoEdicion', true);

                console.log(capitulo_inicial);
                document.getElementById('textTitulo').value = parteNombre;
                document.getElementById('capitulo_inicial').value = capitulo_inicial;
                document.getElementById('capitulo_final').value = capitulo_final;

                // Establecer parte_id en Livewire
                @this.set('parte_id', parteId);

                // Ajustar visibilidad de botones
                document.getElementById('btnGuardar').style.display = 'none';
                document.getElementById('btnActualizar').style.display = 'block';
            }
        });
    </script>
</div>
