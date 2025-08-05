@extends('layouts.main')

@section('contenido')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 style="color:#151414">Libro Diario</h1>
                <div class="section-header-breadcrumb">
                    <button class="btn btn-info" data-toggle="modal" data-target="#modalFiltros">
                        <i class="fas fa-filter"></i> Filtrar por Fecha
                    </button>
                </div>
            </div>
            <div class="section-body">
                <p style="font-size: 1.2em;">Registro cronológico de todos los ingresos y egresos.</p>

                <!-- Resumen de totales -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h6>Total Ingresos</h6>
                                <h4>{{ number_format($totalIngresos, 2) }} Bs</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h6>Total Egresos</h6>
                                <h4>{{ number_format($totalEgresos, 2) }} Bs</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card {{ $saldoFinal >= 0 ? 'bg-primary' : 'bg-warning' }} text-white">
                            <div class="card-body">
                                <h6>Saldo Final</h6>
                                <h4>{{ number_format($saldoFinal, 2) }} Bs</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h6>Total Movimientos</h6>
                                <h4>{{ count($libroDiario) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla del libro diario -->
            <div class="table-responsive">
                <table class="table table-striped table-sm" id="table-libro-diario">
                    <thead>
                        <tr class="thead-dark">
                            <th>Fecha</th>
                            <th>Cuenta</th>
                            <th>Factura-Recibo</th>
                            <th>Cliente</th>
                            <th>Detalle</th>
                            <th>Importe</th>
                            <th>Ingreso</th>
                            <th>Egreso</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($libroDiario as $movimiento)
                            <tr class="{{ $movimiento['tipo'] == 'ingreso' ? 'table-success' : 'table-danger' }}">
                                <td>{{ \Carbon\Carbon::parse($movimiento['fecha'])->format('d/m/Y') }}</td>
                                <td>{{ $movimiento['cuenta_nombre'] }}</td>
                                <td>{{ Str::upper($movimiento['numero_documento']) }}</td>
                                <td>{{ $movimiento['cliente'] }}</td>
                                <td>{{ $movimiento['detalle'] }}</td>
                                <td>{{ number_format($movimiento['importe'], 2) }} Bs</td>
                                <td>
                                    @if($movimiento['ingreso'] > 0)
                                        {{ number_format($movimiento['ingreso'], 2) }} Bs
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($movimiento['egreso'] > 0)
                                        {{ number_format($movimiento['egreso'], 2) }} Bs
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-primary font-weight-bold">
                                    {{ number_format($movimiento['saldo'], 2) }} Bs
                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                    @if(count($libroDiario) > 0)
                        <tfoot>
                            <tr>
                                <th colspan="6" class="text-right">TOTALES:</th>
                                <th>{{ number_format($totalIngresos, 2) }} Bs</th>
                                <th>{{ number_format($totalEgresos, 2) }} Bs</th>
                                <th class="text-primary">{{ number_format($saldoFinal, 2) }} Bs</th>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </section>
    </div>

    <!-- Modal para filtros de fecha -->
    <div class="modal fade" id="modalFiltros" tabindex="-1" role="dialog" aria-labelledby="modalFiltrosLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('libro-diario.index') }}" method="GET">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFiltrosLabel">Filtrar por Fecha</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="color: #151414;">
                            <div class="form-group col-md-6">
                                <label>Fecha Inicio</label>
                                <input type="date" class="form-control" name="fecha_inicio" value="{{ $fechaInicio }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Fecha Fin</label>
                                <input type="date" class="form-control" name="fecha_fin" value="{{ $fechaFin }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-info">Aplicar Filtro</button>
                        <a href="{{ route('libro-diario.index') }}" class="btn btn-warning">Limpiar Filtro</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#table-libro-diario').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
                },
                "order": [[0, "desc"]],
                "pageLength": 25,
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                "responsive": true,
                "dom": 'Blfrtip',
                "buttons": [
                    {
                        extend: 'copy',
                        text: 'Copiar',
                        className: 'btn btn-secondary',
                        exportOptions: {
                            modifier: {
                                search: 'applied',
                                order: 'applied',
                                page: 'all'
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                            modifier: {
                                search: 'applied',
                                order: 'applied',
                                page: 'all'
                            }
                        },
                        customizeData: function (data) {
                            // Agrega los totales al final del Excel
                            data.body.push([
                                '',
                                '',
                                '',
                                '',
                                '',
                                'TOTALES',
                                '{{ number_format($totalIngresos, 2) }} Bs',
                                '{{ number_format($totalEgresos, 2) }} Bs',
                                '{{ number_format($saldoFinal, 2) }} Bs'
                            ]);
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger',
                        orientation: 'landscape',
                        exportOptions: {
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
                                            { text: 'Libro Diario', alignment: 'center', fontSize: 18, margin: [0, 5, 0, 0] }
                                        ],
                                        width: '*'
                                    }
                                ],
                                margin: [0, 0, 0, 12]
                            });
                            var tablaPrincipal = doc.content.find(function (c) {
                                return c.table && c.table.body && c.table.body.length > 1;
                            });
                            if (tablaPrincipal) {
                                tablaPrincipal.table.widths = ['*', '*', '*', '*', '*', '*', '*', '*', '*'];
                            }
                            // Agrega los totales al final del PDF
                            doc.content.push({
                                table: {
                                    // Cambia los valores fijos por '*'
                                    widths: ['*', '*', '*', '*', '*', '*', '*', '*', '*'],
                                    body: [
                                        [
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: '', border: [false, false, false, false] },
                                            { text: 'Total Ingresos: {{ number_format($totalIngresos, 2) }} Bs', bold: true, alignment: 'right', border: [false, false, false, false] },
                                            { text: 'Total Egresos: {{ number_format($totalEgresos, 2) }} Bs', bold: true, alignment: 'right', border: [false, false, false, false] },
                                            { text: 'Saldo Final: {{ number_format($saldoFinal, 2) }} Bs', bold: true, alignment: 'right', border: [false, false, false, false] }
                                        ]
                                    ]
                                },
                                layout: 'noBorders',
                                margin: [0, 10, 0, 0]
                            });

                            // Elimina el título por defecto si aparece duplicado
                            if (doc.content.length > 1 && doc.content[1].text) {
                                doc.content.splice(1, 1);
                            }
                        }
                    }
                ]
            });
        });
    </script>
@endpush