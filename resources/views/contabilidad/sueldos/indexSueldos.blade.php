@extends('layouts.main')

@section('contenido')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="color:#151414">Sueldos y Salarios</h1>
                <div class="section-header-breadcrumb">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalNuevoTrabajador">
                        <i class="fas fa-user-plus"></i> Nuevo Trabajador
                    </a>
                    <a href="#" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalNuevoSueldo">
                        <i class="fas fa-money-bill-wave"></i> Registrar Pago
                    </a>
                    <a href="#" class="btn btn-info ml-2" data-toggle="modal" data-target="#modalFiltros">
                        <i class="fas fa-filter"></i> Filtros
                    </a>
                </div>
            </div>
            <!-- Tarjetas de Totales -->
            <div class="section-body">
                <div class="row mb-4">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-calculator"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Salarios</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalSalarios, 2) }} Bs
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning">
                                <i class="fas fa-minus-circle"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Descuentos</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalDescuentos, 2) }} Bs
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-info">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Horas Extras</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalHorasExtras, 2) }} Bs
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-secondary">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Anticipos</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalAnticipos, 2) }} Bs
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-8 col-sm-12 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="far fa-money-bill-alt"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Líquido Pagado</h4>
                                </div>
                                <div class="card-body">
                                    {{ number_format($totalLiquido, 2) }} Bs
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p style="font-size: 1.2em;">Puedes exportar los sueldos en formato Excel y PDF.</p>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm" id="table-sueldos">
                    <thead>
                        <tr class="thead-dark">
                            <th>Fecha Pago</th>
                            <th>Trabajador</th>
                            <th>Cargo</th>
                            <th>Mes </th>
                            <th>Salario</th>
                            <th>Horas Extras</th>
                            <th>Descuentos</th>
                            <th>Anticipos</th>
                            <th>Total Líquido</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sueldos as $sueldo)
                            <tr>
                                <td>{{ $sueldo->fecha_pago->format('d/m/Y') }}</td>
                                <td>{{ $sueldo->trabajador->nombres }} {{ $sueldo->trabajador->apellidos }}</td>
                                <td>{{ $sueldo->trabajador->cargo }}</td>
                                <td>{{ $sueldo->mes_pago }}</td>
                                <td>{{ number_format($sueldo->salario, 2) }} Bs</td>
                                <td>{{ number_format($sueldo->horas_extras, 2) }} Bs</td>
                                <td>{{ number_format($sueldo->descuento, 2) }} Bs</td>
                                <td>{{ number_format($sueldo->anticipo, 2) }} Bs</td>
                                <td><strong>{{ number_format($sueldo->total_liquido, 2) }} Bs</strong></td>
                                <td>
                                    <form action="{{ route('sueldos.destroy', $sueldo->id) }}" method="POST"
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
                    <tfoot>
                        <tr style="background-color: #f8f9fa; font-weight: bold; border-top: 2px solid #dee2e6;">
                            <td colspan="4" class="text-right"><strong>TOTALES:</strong></td>
                            <td><strong>{{ number_format($totalSalarios, 2) }} Bs</strong></td>
                            <td><strong>{{ number_format($totalHorasExtras, 2) }} Bs</strong></td>
                            <td><strong>{{ number_format($totalDescuentos, 2) }} Bs</strong></td>
                            <td><strong>{{ number_format($totalAnticipos, 2) }} Bs</strong></td>
                            <td><strong>{{ number_format($totalLiquido, 2) }} Bs</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>
    </div>

    <!-- Modal de Nuevo Trabajador -->
    <div class="modal fade" id="modalNuevoTrabajador" tabindex="-1" role="dialog"
        aria-labelledby="modalNuevoTrabajadorLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('trabajadores.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNuevoTrabajadorLabel">Registrar Nuevo Trabajador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="color: #151414;">
                            <div class="form-group col-md-6">
                                <label>Nombres</label>
                                <input type="text" class="form-control" name="nombres" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Cargo</label>
                                <input type="text" class="form-control" name="cargo" required>
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

    <!-- Modal de Nuevo Sueldo -->
    <div class="modal fade" id="modalNuevoSueldo" tabindex="-1" role="dialog" aria-labelledby="modalNuevoSueldoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('sueldos.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNuevoSueldoLabel">Registrar Pago de Sueldo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="color: #151414;">
                            <div class="form-group col-md-6">
                                <label>Trabajador</label>
                                <select class="form-control" name="trabajador_id" required>
                                    <option value="">Seleccione un trabajador...</option>
                                    @foreach ($trabajadores as $trabajador)
                                        <option value="{{ $trabajador->id }}">
                                            {{ $trabajador->nombres }} {{ $trabajador->apellidos }} - {{ $trabajador->cargo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Mes de Pago</label>
                                <input type="text" class="form-control" name="mes_pago" placeholder="Ejemplo: Enero 2025"
                                    required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Salario Base</label>
                                <input type="number" step="0.01" class="form-control" name="salario" id="salario" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Horas Extras</label>
                                <input type="number" step="0.01" class="form-control" name="horas_extras" id="horas_extras"
                                    value="0">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Descuentos</label>
                                <input type="number" step="0.01" class="form-control" name="descuento" id="descuento"
                                    value="0">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Anticipos</label>
                                <input type="number" step="0.01" class="form-control" name="anticipo" id="anticipo"
                                    value="0">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Fecha de Pago</label>
                                <input type="date" class="form-control" name="fecha_pago" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Total Líquido (Calculado)</label>
                                <input type="text" class="form-control" id="total_liquido_display" readonly
                                    style="background-color: #e9ecef; font-weight: bold;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Registrar Pago</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Filtros -->
    <div class="modal fade" id="modalFiltros" tabindex="-1" role="dialog" aria-labelledby="modalFiltrosLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('sueldos.index') }}" method="GET">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFiltrosLabel">Filtrar Sueldos</h5>
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
                                    <label>Trabajador</label>
                                    <select class="form-control" name="trabajador_id">
                                        <option value="">Todos los trabajadores</option>
                                        @foreach($trabajadores as $trabajador)
                                            <option value="{{ $trabajador->id }}" {{ request('trabajador_id') == $trabajador->id ? 'selected' : '' }}>
                                                {{ $trabajador->nombres }} {{ $trabajador->apellidos }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mes de Pago</label>
                                    <select class="form-control" name="mes_pago">
                                        <option value="">Todos los meses</option>
                                        @foreach($mesesPago as $mes)
                                            <option value="{{ $mes }}" {{ request('mes_pago') == $mes ? 'selected' : '' }}>
                                                {{ $mes }}
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
                        <a href="{{ route('sueldos.index') }}" class="btn btn-warning">Limpiar Filtros</a>
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

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    showConfirmButton: true,
                    timer: 3000
                });
            });
        </script>
        {{ session()->forget('error') }}
    @endif

    <script>
        $(document).ready(function () {
            $('#table-sueldos').DataTable({
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
                                '', '', '', // columnas vacías según tu tabla
                                '{{ number_format($totalSalarios, 2) }} Bs',
                                '{{ number_format($totalHorasExtras, 2) }} Bs',
                                '{{ number_format($totalDescuentos, 2) }} Bs',
                                '{{ number_format($totalAnticipos, 2) }} Bs',
                                '{{ number_format($totalLiquido, 2) }} Bs'
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
                                            { text: 'Reporte de Sueldos', alignment: 'center', fontSize: 18, margin: [0, 5, 0, 0] }
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
                                    widths: ['8%', '10%', '8%', '10%', '11%', '11%', '11%', '11%', '11%'],
                                    body: [
                                        [
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: 'Salario', style: 'tableHeader', alignment: 'center' },
                                            { text: 'Horas Extras', style: 'tableHeader', alignment: 'center' },
                                            { text: 'Descuentos', style: 'tableHeader', alignment: 'center' },
                                            { text: 'Anticipos', style: 'tableHeader', alignment: 'center' },
                                            { text: 'Total Líquido', style: 'tableHeader', alignment: 'center' }
                                        ],
                                        [
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: 'TOTALES:', style: 'tableHeader', alignment: 'right', border: [false, false, false, false] },
                                            { text: '{{ number_format($totalSalarios, 2) }} Bs', style: 'tableHeader', alignment: 'center', border: [false, false, false, false] },
                                            { text: '{{ number_format($totalHorasExtras, 2) }} Bs', style: 'tableHeader', alignment: 'center', border: [false, false, false, false] },
                                            { text: '{{ number_format($totalDescuentos, 2) }} Bs', style: 'tableHeader', alignment: 'center', border: [false, false, false, false] },
                                            { text: '{{ number_format($totalAnticipos, 2) }} Bs', style: 'tableHeader', alignment: 'center', border: [false, false, false, false] },
                                            { text: '{{ number_format($totalLiquido, 2) }} Bs', style: 'tableHeader', alignment: 'center', border: [false, false, false, false] }
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

            // Calcular total líquido en tiempo real
            function calcularTotalLiquido() {
                const salario = parseFloat($('#salario').val()) || 0;
                const horasExtras = parseFloat($('#horas_extras').val()) || 0;
                const descuento = parseFloat($('#descuento').val()) || 0;
                const anticipo = parseFloat($('#anticipo').val()) || 0;

                const totalLiquido = salario + horasExtras - descuento - anticipo;
                $('#total_liquido_display').val(totalLiquido.toFixed(2) + ' Bs');
            }

            // Eventos para recalcular el total líquido
            $('#salario, #horas_extras, #descuento, #anticipo').on('input', calcularTotalLiquido);

            // Calcular al abrir el modal
            $('#modalNuevoSueldo').on('shown.bs.modal', function () {
                calcularTotalLiquido();
            });
        });

        // Función para confirmar eliminación
        $(document).on('submit', '.form-eliminar', function (e) {
            e.preventDefault();
            const form = this;
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¿Estás seguro de que quieres eliminar este registro de sueldo? Esta acción no se puede deshacer.',
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