<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>PRO-FORMA N°: {{ $recepcion->numero_recepcion }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #151414;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo {
            float: left;
            width: 120px;
        }

        .empresa-info {
            text-align: right;
            font-size: 11px;
        }

        .clearfix {
            clear: both;
        }

        .section {
            margin-bottom: 10px;
        }

        .datos-empresa,
        .datos-cliente {
            width: 100%;
            margin-bottom: 10px;
        }

        .datos-empresa td,
        .datos-cliente td {
            font-size: 12px;
            padding: 2px 4px;
        }

        .titulo {
            background: #e0e7ef;
            font-weight: bold;
            padding: 4px;
        }

        .tabla-equipos,
        .tabla-repuestos {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .tabla-equipos th,
        .tabla-equipos td,
        .tabla-repuestos th,
        .tabla-repuestos td {
            border: 1px solid #b0b0b0;
            padding: 5px;
            font-size: 12px;
        }

        .tabla-equipos th,
        .tabla-repuestos th {
            background: #e0e7ef;
        }

        .tdfoto {
            margin-bottom: 25px;
            padding: 0;
        }

        .fotos {
            margin-top: 25px;

        }

        .fotos img {
            width: 90px;
            height: auto;
            margin-right: 5px;
            margin-bottom: 5px;
            border-radius: 4px;
            border: 1px solid #aaa;
            display: inline-block;
        }

        .condiciones {
            font-size: 10px;
            margin-top: 15px;
        }

        .totales {
            width: 250px;
            float: right;
            margin-top: 10px;
        }

        .totales td {
            font-size: 12px;
            padding: 3px 6px;
        }

        .footer {
            font-size: 10px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- Cabecera -->
    <div class="header">
        <table width="100%">
            <tr>
                <td width="30%">
                    <img src="{{ public_path('logo.jpeg') }}" alt="logo" width="100">
                </td>
                <td width="70%" class="empresa-info">
                    <strong>HC INDUSTRIAL</strong><br>
                    MANTENIMIENTO Y REPARACIÓN DE MAQUINARIA ELÉCTRICA INDUSTRIAL<br>
                    Dir: 4to Anillo entre Av. Alemana y Av. Costanera<br>
                    Cel: 76578154 - 72868051<br>
                    <strong>PRO-FORMA</strong><br>
                    <strong>Fecha:</strong>{{ \Carbon\Carbon::parse($cotizacion->fecha)->format('d/m/Y') }}
                </td>
            </tr>
        </table>
    </div>
    <div class="clearfix"></div>
    <h3>PRO-FORMA N°: {{ $recepcion->numero_recepcion }}</h3>
    <!-- Datos del cliente -->
    <table class="datos-empresa">
        <tr>
            <td class="titulo" colspan="4" style="background-color: #000d53; color: #fff; text-align: center;">DATOS DEL
                CLIENTE</td>
        </tr>
        <tr>
            <td><strong>Tipo de cliente:</strong>{{ $cliente->tipo ?? 'Particular' }}</td>
            <td><strong>Solicitante:</strong>{{ $cliente->nombre }}</td>
            <td><strong>N° Documento:</strong>{{ $cliente->numero_documento }}</td>
        </tr>
        <tr>
            <td>
                <strong>Articulo:</strong>{{ $cotizacion->equipos->first()->equipo->nombre ?? 'N/A' }}
            </td>
            <td><strong>Celular:</strong>{{ $cliente->telefono_1 }}  {{ $cliente->telefono_2 }}  {{ $cliente->telefono_3 }}
            </td>
            
            <td></td>
            <td>             
        </tr>
        
    </table>

    <!-- Información de equipos cotizados -->
    @foreach($cotizacion->equipos as $cotizacionEquipo)
        @php
            $equipo = $cotizacionEquipo->equipo;
            $fotosSeleccionadas = $cotizacionEquipo->fotos;
            $repuestos = $cotizacionEquipo->repuestos;
        @endphp

        <table class="tabla-equipos">
            <tr>
                <th colspan="5" style="background-color: #000d53; color: #fff;">DETALLES DEL EQUIPO:{{ Str::upper($equipo->nombre) }}</th>
            </tr>
            <tr>
                <td><strong>Categoria:</strong> {{  Str::title(str_replace('_', ' ', $equipo->tipo))}}</td>
                
                <td><strong>Marca:</strong> {{ $equipo->marca }}</td>
                <td><strong>Modelo:</strong> {{ $equipo->modelo }}</td>
                <td><strong>Color:</strong> {{ $equipo->color ?? 'N/A' }}</td>
                <td>-</td>
            </tr>
            <tr>
                <td><strong>Voltaje:</strong> {{ $equipo->voltaje ?? 'N/A' }}</td>

                @if($equipo->tipo == 'MOTOR_ELECTRICO')
                    <td><strong>HP:</strong> {{ $equipo->hp ?? 'N/A' }}</td>
                    <td><strong>RPM:</strong> {{ $equipo->rpm ?? 'N/A' }}</td>
                    <td><strong>Hz:</strong> {{ $equipo->hz ?? 'N/A' }}</td>
                    <td>-</td>

                @elseif($equipo->tipo == 'MAQUINA_SOLDADORA')
                    <td><strong>AMP:</strong> {{ $equipo->amperaje ?? 'N/A' }}</td>
                    <td><strong>Cable +:</strong> {{ $equipo->cable_positivo ?? 'N/A' }}</td>
                    <td><strong>Cable -:</strong> {{ $equipo->cable_negativo ?? 'N/A' }}</td>
                    <td>-</td>

                @elseif($equipo->tipo == 'GENERADOR_DINAMO')
                    <td><strong>RPM:</strong> {{ $equipo->rpm ?? 'N/A' }}</td>
                    <td><strong>Hz:</strong> {{ $equipo->hz ?? 'N/A' }}</td>
                    <td><strong>Kva/Kw:</strong> {{ $equipo->kva_kw ?? 'N/A' }}</td>
                    <td>-</td>

                @else($equipo->tipo == 'OTRO')
                    <td><strong>Potencia:</strong> {{ $equipo->potencia ?? 'N/A' }}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                @endif
            </tr>
            <tr>
                <td colspan="5"><strong>Descripción del trabajo:</strong> {{ $cotizacionEquipo->trabajo_realizar }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Precio del trabajo:</strong>
                    Bs.{{ number_format($cotizacionEquipo->precio_trabajo, 2) }}</td>
                <td colspan="3"><strong>Total repuestos:</strong>
                    Bs.{{ number_format($cotizacionEquipo->total_repuestos, 2) }}</td>
            </tr>
        </table>

        <!-- Tabla de repuestos -->
        <table class="tabla-repuestos">
            <tr>

                <th style="background-color: #000d53; color: #fff;">DESCRIPCIÓN DE LOS REPUESTOS</th>
                <th style="background-color: #000d53; color: #fff; ">CANT</th>
                <th style="background-color: #000d53; color: #fff;">U. UNITARIO</th>
                <th style="background-color: #000d53; color: #fff;">TOTAL</th>
            </tr>
            @if($repuestos && $repuestos->count())
                @foreach($repuestos as $repuesto)
                    <tr>

                        <td style="text-align: center;">{{ $repuesto->nombre }}</td>
                        <td style="text-align: center;">{{ $repuesto->cantidad }}</td>
                        <td>Bs. {{ number_format($repuesto->precio_unitario, 2) }}</td>
                        <td>Bs. {{ number_format($repuesto->cantidad * $repuesto->precio_unitario, 2) }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="text-align: center;">No se especificaron repuestos</td>
                </tr>
            @endif
            <!-- Tabla de servicios realizados -->


            <!-- Fotos seleccionadas -->
            <tr>
                <td colspan="4"><strong>IMAGEN {{ strtoupper($equipo->nombre) }}</strong></td>
            </tr>
            <tr>
                <td class="tdfoto" colspan="4">
                    <div class="fotos">
                        @if($fotosSeleccionadas && $fotosSeleccionadas->count())
                            @foreach($fotosSeleccionadas as $foto)
                                <img src="{{ public_path('storage/' . $foto->ruta) }}" alt="Foto del equipo">
                            @endforeach
                        @else
                            <span style="color: #666;">Sin fotos seleccionadas</span>
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    @endforeach
    <table class="tabla-repuestos">
        <tr>
            <th colspan="4" style="background-color: #000d53; color: #fff;">SERVICIOS REALIZADOS</th>
        </tr>

        @if($cotizacionEquipo->servicios && $cotizacionEquipo->servicios->count())
            @foreach($cotizacionEquipo->servicios as $i => $servicio)
                <tr>

                    <td colspan="4" ><strong>{{ $i + 1 }}</strong>.- {{ $servicio->nombre }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4">No se especificaron servicios</td>
            </tr>
        @endif
    </table>
    <!-- Totales -->
    <table class="totales">
        <tr>
            <td>Sub Total Bs</td>
            <td>{{ number_format($subtotal, 2) }}</td>
        </tr>
        <tr>
            <td>Descuento Bs</td>
            <td>{{ number_format($descuento, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Total Bs</strong></td>
            <td><strong>{{ number_format($total, 2) }}</strong></td>
        </tr>
    </table>
    <div class="clearfix"></div>

    <!-- Condiciones -->
    <div class="condiciones">
        <strong>Esta cotización está sujeta a los términos y condiciones que se enuncian a continuación:</strong><br>
        1. Tiempo de entrega 2 a 3 días hábiles<br>
        2. Vigencia de la oferta 15 días hábiles<br>
        3. Forma de pago 50% por adelantado y saldo contra entrega<br>
        4. Garantía del servicio 3 meses<br>
        5. Taller HC no se responsabiliza por el equipo dejado más de 90 días<br>
        <br>
        Agradecemos su preferencia y quedamos a su disposición para cualquier consulta adicional. Su satisfacción es
        nuestra prioridad y estamos comprometidos a proporcionar servicios de la más alta calidad.
    </div>

    <div class="footer">
        HC INDUSTRIAL - Mantenimiento y Reparación de Maquinaria Eléctrica Industrial
    </div>
</body>

</html>