@extends('layouts.main')

@section('contenido')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="color:#151414">Ingresos</h1>
                <div class="section-header-breadcrumb">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalNuevoIngreso">
                        <i class="fas fa-plus"></i> Nuevo Ingreso
                    </a>
                    <a href="#" class="btn btn-info ml-2" data-toggle="modal" data-target="#modalFiltros">
                        <i class="fas fa-filter"></i> Filtros
                    </a>
                </div>
            </div>
            <!-- Tarjeta de Totales -->
            <div class="section-body">
                <div class="row mb-4">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-calculator"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Subtotal</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalSubtotal, 2) }} Bs
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-percentage"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Descuentos</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalDescuento, 2) }} Bs
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-money-bill-alt"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total de Ingresos</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalIngresos, 2) }} Bs
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p style="font-size: 1.2em;">Puedes exportar los ingresos en formato Excel y PDF.</p>
            </div>
            <div class=" table-responsive">
                <table class="table table-striped table-sm" id="table-ingresos">
                    <thead>
                        <tr class="thead-dark">

                            <th>Fecha</th>
                            <th>Tipo de Ingreso</th>
                            <th>Glosa</th>
                            <th>Razón Social</th>
                            <th>N° de Recibo</th>
                            <th>Método de Pago</th>
                            <th>Subtotal</th>
                            <th>Descuento</th>
                            <th>Total</th>
                            <th>Estado Pago</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ingresos as $ingreso)
                            <tr>

                                <td>{{ $ingreso->created_at->format('d/m/Y')}}</td>
                                <td>{{ $ingreso->tipo_ingreso }}</td>
                                <td>{{ $ingreso->glosa }}</td>
                                <td>{{ $ingreso->razon_social }}</td>
                                <td>{{ Str::upper($ingreso->nro_recibo) }}</td>
                                <td>{{ $ingreso->metodo_pago }}</td>
                                <td>{{ number_format($ingreso->subtotal, 2) }}Bs</td>
                                <td>{{ number_format($ingreso->descuento, 2) }}Bs</td>
                                <td>{{ number_format($ingreso->total, 2) }}Bs</td>
                                <td>{{ $ingreso->estado_pago }}</td>
                                <td>
                                    <!-- Botón para editar método de pago -->
                                    <button type="button" class="btn btn-primary btn-sm"
                                        data-toggle="modal"
                                        data-target="#modalMetodoPago{{ $ingreso->id }}"
                                        title="Editar Método de Pago">
                                        <i class="fas fa-credit-card"></i>
                                    </button>
                                    <form action="{{ route('ingresos.destroy', $ingreso->id) }}" method="POST"
                                        style="display: inline;" class="form-eliminar">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #f8f9fa; font-weight: bold; border-top: 2px solid #dee2e6;">
                            <td colspan="7" class="text-right"><strong>TOTALES:</strong></td>
                            <td><strong>{{ number_format($totalSubtotal, 2) }} Bs</strong></td>
                            <td><strong>{{ number_format($totalDescuento, 2) }} Bs</strong></td>
                            <td><strong>{{ number_format($totalIngresos, 2) }} Bs</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

            </div>

        </section>
    </div>
    @foreach ($ingresos as $ingreso)
<!-- Modal editar método de pago -->
<div class="modal fade" id="modalMetodoPago{{ $ingreso->id }}" tabindex="-1" role="dialog" aria-labelledby="modalMetodoPagoLabel{{ $ingreso->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('ingresos.update', $ingreso->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMetodoPagoLabel{{ $ingreso->id }}">Editar Método de Pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Método de Pago</label>
                        <select name="metodo_pago" class="form-control" required>
                            <option value="Efectivo" {{ $ingreso->metodo_pago == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="Banco" {{ $ingreso->metodo_pago == 'Banco' ? 'selected' : '' }}>Banco</option>
                            <option value="Por cobrar" {{ $ingreso->metodo_pago == 'Por cobrar' ? 'selected' : '' }}>Por cobrar</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
    <!-- Modal de Nuevo Ingreso -->
    <div class="modal fade" id="modalNuevoIngreso" tabindex="-1" role="dialog" aria-labelledby="modalNuevoIngresoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document"><!-- modal-lg para mayor ancho -->
            <form action="{{ route('ingresos.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNuevoIngresoLabel">Registrar Nuevo Ingreso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="color: #151414;">
                            <div class="form-group col-md-6">
                                <label>Tipo de Ingreso</label>
                                <select class="form-control" name="tipo_ingreso" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Venta">Venta</option>
                                    <option value="Servicios">Servicios</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Glosa</label>
                                <input type="text" class="form-control" name="glosa" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Razón Social</label>
                                <input type="text" class="form-control" name="razon_social" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>N° de Recibo</label>
                                <input type="text" class="form-control" name="nro_recibo" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Método de Pago</label>
                                <select class="form-control" name="metodo_pago" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Banco">Banco</option>
                                    <option value="Por cobrar">Por cobrar</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Subtotal</label>
                                <input type="number" step="0.01" class="form-control" name="subtotal" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Descuento</label>
                                <input type="number" step="0.01" class="form-control" name="descuento" value="0">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Estado de Pago</label>
                                <select name="estado_pago" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Anticipo">Anticipo</option>
                                    <option value="Saldo">Saldo</option>
                                    <option value="Completo">Completo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Filtros -->
    <div class="modal fade" id="modalFiltros" tabindex="-1" role="dialog" aria-labelledby="modalFiltrosLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('ingresos.index') }}" method="GET">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFiltrosLabel">Filtrar Ingresos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha Inicio</label>
                                    <input type="date" class="form-control" name="fecha_inicio"
                                        value="{{ request('fecha_inicio') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha Fin</label>
                                    <input type="date" class="form-control" name="fecha_fin"
                                        value="{{ request('fecha_fin') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo de Ingreso</label>
                                    <select class="form-control" name="tipo_ingreso">
                                        <option value="">Todos los tipos</option>
                                        @foreach($tiposIngreso as $tipo)
                                            <option value="{{ $tipo }}" {{ request('tipo_ingreso') == $tipo ? 'selected' : '' }}>
                                                {{ $tipo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Método de Pago</label>
                                    <select class="form-control" name="metodo_pago">
                                        <option value="">Todos los métodos</option>
                                        @foreach($metodosPago as $metodo)
                                            <option value="{{ $metodo }}" {{ request('metodo_pago') == $metodo ? 'selected' : '' }}> {{ $metodo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-info">Aplicar Filtros</button>
                        <a href="{{ route('ingresos.index') }}" class="btn btn-warning">Limpiar Filtros</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Acción completada',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                    timer: 3000
                });
            });
        </script>
        {{ session()->forget('success') }}
    @endif
    <script>
        $(document).ready(function () {
            $('#table-ingresos').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "order": [[0, "desc"]], // Ordenar por fecha descendente
                "pageLength": 25,
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                "responsive": true,
                "dom": 'Blfrtip',
                "buttons": [
                    {
                        extend: 'copy',
                        text: 'Copiar',
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-success',
                         exportOptions: {
                            columns: ':not(:last-child)',
                            modifier: {
                                search: 'applied',
                                order: 'applied',
                                page: 'all'
                            }
                        },
                        customizeData: function (data) {
                            data.body.push([
                                '', '', '', '', '', '', // columnas vacías según tu tabla
                                '{{ number_format($totalSubtotal, 2) }} Bs',
                                '{{ number_format($totalDescuento, 2) }} Bs',
                                '{{ number_format($totalIngresos, 2) }} Bs',
                                ''
                            ]);
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger',
                        orientation: 'landscape',
                         exportOptions: {
                            columns: ':not(:last-child)',
                            modifier: {
                                search: 'applied',
                                order: 'applied',
                                page: 'all'
                            }
                        },
                        customize: function (doc) {
                            doc.images = doc.images || {};
                            doc.images.logo = 'data:image/png;base64,{{ base64_encode(file_get_contents(public_path("img/logoHc.png"))) }}';

                            doc.content.unshift({
                                columns: [
                                    {
                                        image: 'logo',
                                        width: 100,
                                        alignment: 'left',
                                        margin: [0, 0, 0, 0]
                                    },
                                    {
                                        stack: [
                                            { text: 'HC SERVICIO INDUSTRIAL', alignment: 'center', fontSize: 16, bold: true, margin: [0, 10, 0, 0] },
                                            { text: 'Reporte de Ingresos', alignment: 'center', fontSize: 18, margin: [0, 5, 0, 0] }
                                        ],
                                        width: '100%',
                                        alignment: 'center'
                                    }
                                ],
                                margin: [0, 0, 0, 12]
                            });

                            // Elimina el título por defecto de DataTables
                            doc.content.splice(1, 1);

                            // Agregar totales al final del PDF
                            doc.content.push({
                                text: '\n',
                                margin: [0, 10, 0, 0]
                            });

                            doc.content.push({
                                table: {
                                    widths: ['4%', '4%', '4%', '4%', '8%', '10%', '10%', '11%', '11%', '11%'],
                                    body: [
                                        [
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: 'subtotal', style: 'tableHeader', border: [false, false, false, false] },
                                            { text: 'descuento', style: 'tableHeader', border: [false, false, false, false] },
                                            { text: 'total', style: 'tableHeader', border: [false, false, false, false] }
                                        ],
                                        [
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: 'TOTALES:', style: 'tableHeader', alignment: 'right', border: [false, false, false, false] },
                                            { text: '{{ number_format($totalSubtotal, 2) }} Bs', style: 'tableHeader', alignment: 'center', border: [false, false, false, false] },
                                            { text: '{{ number_format($totalDescuento, 2) }} Bs', style: 'tableHeader', alignment: 'center', border: [false, false, false, false] },
                                            { text: '{{ number_format($totalIngresos, 2) }} Bs', style: 'tableHeader', alignment: 'center', border: [false, false, false, false] }
                                        ]
                                    ]
                                },
                                layout: {
                                    fillColor: '#f8f9fa',
                                    hLineWidth: function (i, node) {
                                        return 2;
                                    },
                                    vLineWidth: function (i, node) {
                                        return 1;
                                    }
                                },
                                margin: [0, 5, 0, 0]
                            });
                        }
                    }
                ]
            });
        });

        // Función para confirmar eliminación
        $(document).on('submit', '.form-eliminar', function (e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Estás seguro de que quieres eliminar este ingreso? Esta acción no se puede deshacer y también se actualizará el libro diario automáticamente.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush