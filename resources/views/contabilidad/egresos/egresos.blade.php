@extends('layouts.main')

@section('contenido')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="color:#151414">Egresos</h1>
                <div class="section-header-breadcrumb">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalNuevoEgreso">Nuevo Egreso
                    </a>
                    <a href="#" class="btn btn-primary ml-2" data-toggle="modal" data-target="#modalNuevaCuenta">Agregar
                        Cuenta
                    </a>
                    <a href="#" class="btn btn-info ml-2" data-toggle="modal" data-target="#modalFiltros">
                        <i class="fas fa-filter"></i> Filtros
                    </a>
                </div>
            </div>
            <!-- Tarjetas de Totales -->
            <div class="section-body">
                <div class="row mb-4">

                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
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
                            <div class="card-icon bg-danger">
                                <i class="far fa-money-bill-alt"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total de Egresos</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalEgresos, 2) }} Bs
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p style="font-size: 1.2em;">Puedes exportar los egresos en formato Excel y PDF.</p>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm" id="table-egresos">
                    <thead >
                        <tr class="thead-dark">
                            <th>Fecha</th>
                            <th>Nombre Cuenta</th>
                            <th>Glosa</th>
                            <th>Razón Social</th>
                            <th>N° Factura</th>
                            <th>Responsable</th>
                            <th>Método de Pago</th>
                            <th>Subtotal</th>
                            <th>Descuento</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ejemplo de fila vacía, puedes agregar datos de prueba si lo deseas -->
                        @foreach ($egresos as $egreso)
                            <tr>
                                <td>{{ $egreso->created_at->format('d/m/Y') }}</td>
                                <td>{{ $egreso->cuenta->nombre_cuenta }}</td>
                                <td>{{ $egreso->glosa }}</td>
                                <td>{{ $egreso->razon_social }}</td>
                                <td>{{ Str::upper($egreso->nro_factura) }}</td>
                                <td>{{ $egreso->responsable }}</td>
                                <td>{{ $egreso->metodo_pago }}</td>
                                <td>{{ number_format($egreso->subtotal, 2) }}</td>
                                <td>{{ number_format($egreso->descuento, 2) }}</td>
                                <td>{{ number_format($egreso->total, 2) }}</td>
                                <td>
                                    <form action="{{ route('egresos.destroy', $egreso->id) }}" method="POST"
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
                            <td colspan="8" class="text-right"><strong>TOTALES:</strong></td>
                            <td><strong>{{ number_format($totalSubtotal, 2) }} Bs</strong></td>
                            <td><strong>{{ number_format($totalDescuento, 2) }} Bs</strong></td>
                            <td><strong>{{ number_format($totalEgresos, 2) }} Bs</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
    </div>

    <!-- Modal de Nuevo Egreso -->
    <div class="modal fade" id="modalNuevoEgreso" tabindex="-1" role="dialog" aria-labelledby="modalNuevoEgresoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('egresos.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNuevoEgresoLabel">Registrar Nuevo Egreso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="color: #151414;">
                            <div class="form-group col-md-6">
                                <label>Nombre Cuenta</label>
                                <select class="form-control" name="cuenta_id" required>
                                    <option value="">Seleccione...</option>
                                    @foreach ($cuentas as $cuenta)
                                        <option value="{{ $cuenta->id }}">{{ $cuenta->nombre_cuenta }}</option>
                                    @endforeach
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
                                <label>N° Factura</label>
                                <input type="text" class="form-control" name="nro_factura" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Responsable</label>
                                <select name="responsable" id="responsable" class="form-control" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Tito">Tito</option>
                                    <option value="Aldo">Aldo</option>
                                    <option value="Augusto">Augusto</option>
                                    <option value="Arnold">Arnold</option>
                                    <option value="Plinio">Plinio</option>
                                    <option value="Jose">Jose</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Método de Pago</label>
                                <select class="form-control" name="metodo_pago" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Banco">Banco</option>
                                    <option value="Por pagar">Por pagar</option>
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

    <!-- Modal Nueva Nombre Cuenta -->
    <div class="modal fade" id="modalNuevaCuenta" tabindex="-1" role="dialog" aria-labelledby="modalNuevaCuentaLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('cuentas.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNuevaCuentaLabel">Agregar Nombre Cuenta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre Cuenta</label>
                            <input type="text" class="form-control" name="nombre_cuenta" required>
                        </div>
                        <div class="form-group">
                            <label>Descripción</label>
                            <input type="text" class="form-control" name="descripcion" required>
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
            <form action="{{ route('egresos.index') }}" method="GET">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFiltrosLabel">Filtrar Egresos</h5>
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
                                    <label>Nombre Cuenta</label>
                                    <select class="form-control" name="cuenta_id">
                                        <option value="">Todas las cuentas</option>
                                        @foreach($cuentas as $cuenta)
                                            <option value="{{ $cuenta->id }}" {{ request('cuenta_id') == $cuenta->id ? 'selected' : '' }}> {{ $cuenta->nombre_cuenta }}</option>
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
                        <a href="{{ route('egresos.index') }}" class="btn btn-warning">Limpiar Filtros</a>
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
            $('#table-egresos').DataTable({
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
                                '{{ number_format($totalEgresos, 2) }} Bs'
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
                                            { text: 'HC SERVICIOS INDUSTRIAL', alignment: 'center', fontSize: 16, bold: true, margin: [0, 10, 0, 0] },
                                            { text: 'Reporte de Egresos', alignment: 'center', fontSize: 18, margin: [0, 5, 0, 0] }
                                        ],
                                        width: '*'
                                    }
                                ],
                                margin: [0, 0, 0, 12]
                            });

                            // Elimina el título por defecto si aparece duplicado
                            if (doc.content.length > 1 && doc.content[1].text) {
                                doc.content.splice(1, 1);
                            }

                            // Agregar totales al final del PDF
                            doc.content.push({
                                text: '\n',
                                margin: [0, 10, 0, 0]
                            });

                            doc.content.push({
                                table: {
                                    widths: ['4%', '4%', '12%', '12%', '8%', '10%', '10%', '9.33%', '9.33%', '9.34%'],
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
                                            { text: '{{ number_format($totalEgresos, 2) }} Bs', style: 'tableHeader', alignment: 'center', border: [false, false, false, false] }
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
        function confirmarEliminacion(tipo) {
            return Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Estás seguro de que quieres eliminar este ' + tipo + '? Esta acción no se puede deshacer y también se actualizará el libro diario automáticamente.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                return result.isConfirmed;
            });
        }
        $(document).on('submit', '.form-eliminar', function (e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer y también se actualizará el libro diario automáticamente.',
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