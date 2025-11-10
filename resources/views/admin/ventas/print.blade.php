<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Venta #{{ $venta->ticket_mina }}</title>
    <style>
        @page {
            size: 5.5in 8.5in;
            margin: 0.2in;
        }

        body {
            font-family: "Arial", sans-serif;
            font-size: 7pt;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .ticket {
            width: 100%;
            max-width: 5.1in;
            border: 2px solid #000;
            padding: 4px;
            position: relative;
            box-sizing: border-box;
            margin: 0 auto;
        }

        /* Número de ticket vertical en rojo - superior derecha */
        .ticket-number-vertical {
            position: absolute;
            right: 2px;
            top: 10px;
            writing-mode: vertical-rl;
            transform: rotate(0deg);
            font-size: 9pt;
            font-weight: bold;
            color: #c00;
            letter-spacing: 1px;
        }

        /* Header con logo y datos de empresa */
        .header {
            display: flex;
            align-items: flex-start;
            margin-bottom: 3px;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }

        .logo-section {
            width: 85px;
            border-right: 2px solid #000;
            padding-right: 4px;
            margin-right: 4px;
        }

        .logo-box {
            border: 2px solid #000;
            padding: 3px 2px;
            text-align: center;
            margin-bottom: 2px;
        }

        .logo-text {
            font-size: 7pt;
            font-weight: bold;
            color: #003;
            line-height: 1.1;
        }

        .dma-boxes {
            display: flex;
            gap: 2px;
            margin-top: 2px;
        }

        .dma-box {
            border: 1px solid #000;
            width: 20px;
            height: 14px;
            text-align: center;
            font-size: 6pt;
            padding-top: 1px;
            font-weight: bold;
        }

        .company-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-right: 15px;
        }

        .company-title {
            font-size: 10pt;
            font-weight: bold;
            color: #003;
            text-align: center;
            margin-bottom: 1px;
        }

        .company-details {
            font-size: 5.5pt;
            line-height: 1.2;
            text-align: center;
        }

        .company-details strong {
            font-size: 6pt;
        }

        /* Proveedor section */
        .proveedor-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2px 0;
            border-bottom: 1px solid #000;
            margin-bottom: 3px;
        }

        .proveedor-section span {
            font-size: 7pt;
            font-weight: bold;
        }

        .codigo-box {
            border: 1px solid #000;
            padding: 1px 6px;
            font-weight: bold;
            font-size: 6.5pt;
        }

        /* Secciones principales */
        .main-sections {
            display: flex;
            gap: 4px;
            margin-bottom: 4px;
        }

        .left-section {
            flex: 1;
            border: 1px solid #000;
            padding: 3px;
        }

        .right-section {
            flex: 1;
            border: 1px solid #000;
            padding: 3px;
        }

        .section-title {
            font-weight: bold;
            font-size: 6.5pt;
            text-align: center;
            margin-bottom: 3px;
            text-decoration: underline;
        }

        .field-row {
            margin-bottom: 2px;
            display: flex;
            align-items: center;
        }

        .field-label {
            font-weight: bold;
            font-size: 6.5pt;
            margin-right: 2px;
            white-space: nowrap;
        }

        .field-underline {
            flex: 1;
            border-bottom: 1px solid #000;
            min-height: 10px;
            font-size: 6.5pt;
            padding-left: 2px;
            display: flex;
            align-items: center;
        }

        /* Hora y N° Transporte */
        .time-transport {
            display: flex;
            gap: 4px;
            margin-bottom: 3px;
        }

        .time-box,
        .transport-box {
            flex: 1;
            display: flex;
            align-items: center;
        }

        .time-box .field-underline,
        .transport-box .field-underline {
            border: 1px solid #000;
            min-height: 14px;
            display: flex;
            align-items: center;
            padding: 0 4px;
        }

        /* Firmas */
        .signatures {
            display: flex;
            justify-content: space-around;
            margin-top: 8px;
            margin-bottom: 4px;
        }

        .signature-box {
            text-align: center;
            width: 30%;
        }

        .signature-title {
            font-weight: bold;
            font-size: 6.5pt;
            margin-bottom: 4px;
            text-decoration: underline;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 100%;
            height: 20px;
            margin-bottom: 2px;
        }

        .signature-field {
            font-size: 5.5pt;
            text-align: left;
            margin-bottom: 1px;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 5pt;
            margin-top: 4px;
            padding-top: 2px;
            border-top: 1px solid #000;
            line-height: 1.2;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Mensaje de estado antes de imprimir -->
    <div class="no-print" style="padding: 20px; background: #f0f0f0; margin: 20px;">
        <h2 style="color: #28a745;">✓ Venta guardada correctamente</h2>
        <p style="margin: 10px 0; color: #555;">El ticket está listo para imprimir. Se abrirá automáticamente el diálogo
            de impresión.</p>
        <div>
            <button onclick="window.print()"
                style="padding: 10px 20px; background: #28a745; color: white; border: none; cursor: pointer; margin-right: 10px;">
                🖨️ Imprimir Nuevamente
            </button>
            <button onclick="window.location='{{ route('admin.ventas.index') }}'"
                style="padding: 10px 20px; background: #6c757d; color: white; border: none; cursor: pointer;">
                ← Volver al Listado
            </button>
        </div>
    </div>

    <!-- Contenido del ticket -->
    <div class="ticket">
        <!-- Número de ticket vertical en ROJO - Tomado de ticket_mina -->
        <div class="ticket-number-vertical">{{ $venta->ticket_mina }}</div>

        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                <div class="logo-box">
                    <div style="font-weight: bold; font-size: 7pt; color: #003;">LA REALIDAD</div>
                    <div style="font-size: 5.5pt;">MINERÍA Y CONSTRUCCIÓN</div>
                </div>
                <div class="dma-boxes">
                    @php
                        $fecha = \Carbon\Carbon::parse($venta->fecha);
                    @endphp
                    <div class="dma-box">{{ $fecha->format('d') }}</div>
                    <div class="dma-box">{{ $fecha->format('m') }}</div>
                    <div class="dma-box">{{ $fecha->format('y') }}</div>
                </div>
            </div>
            <div class="company-info">
                <div class="company-title">VENTA DE MATERIAL PÉTREO</div>
                <div class="company-details">
                    Antonio Liori s/n y Cuenca - Telfs: 0999512971 - 0991372951 - 0997308231 - 0997308730<br>
                    <strong>Fijo: 062-806 378</strong> E-mail: efrencardenas13@gmail.com<br>
                    Coca - Orellana - Ecuador
                </div>
            </div>
        </div>

        <!-- Proveedor -->
        <div class="proveedor-section">
            <span>PROVEEDOR: EFREN CARDENAS</span>
            <div class="codigo-box">CÓDIGO 401296</div>
        </div>

        <!-- Hora y N° Transporte - Tomados de la base de datos -->
        <div class="time-transport">
            <div class="time-box">
                <span class="field-label">HORA:</span>
                <div class="field-underline">{{ substr($venta->hora, 0, 5) }}</div>
            </div>
            <div class="transport-box">
                <span class="field-label">N°. TRANSPORTE:</span>
                <div class="field-underline">{{ $venta->ticket_transporte ?? '' }}</div>
            </div>
        </div>

        <!-- Secciones principales -->
        <div class="main-sections">
            <!-- Sección Izquierda: IDENTIFICACIÓN VEHÍCULO/MAQUINARIA -->
            <div class="left-section">
                <div class="section-title">IDENTIFICACIÓN VEHÍCULO/MAQUINARIA</div>

                <div class="field-row">
                    <span class="field-label">PROPIETARIO:</span>
                    <div class="field-underline">{{ $venta->volqueta->propietario }}</div>
                </div>

                <div class="field-row">
                    <span class="field-label">CONDUCTOR:</span>
                    <div class="field-underline">{{ $venta->volqueta->conductor }}</div>
                </div>

                <div class="field-row">
                    <span class="field-label">VOLQUETE TIPO:</span>
                    <div class="field-underline">{{ $venta->tipo_volqueta }}</div>
                </div>

                <div class="field-row">
                    <span class="field-label">PLACA:</span>
                    <div class="field-underline">{{ $venta->volqueta->placa }}</div>
                </div>

                <div class="field-row">
                    <span class="field-label">CUBICAJE:</span>
                    <div class="field-underline">{{ number_format($venta->volqueta->cubicaje, 2) }}</div>
                </div>
            </div>

            <!-- Sección Derecha: IDENTIFICACIÓN DESTINO/PROYECTO -->
            <div class="right-section">
                <div class="section-title">IDENTIFICACIÓN DESTINO/PROYECTO</div>

                <div class="field-row">
                    <span class="field-label">CLIENTE:</span>
                    <div class="field-underline">{{ $venta->cliente->nombre }}</div>
                </div>

                <div class="field-row">
                    <span class="field-label">MATERIAL:</span>
                    <div class="field-underline">{{ $venta->material }}</div>
                </div>

                <div class="field-row">
                    <span class="field-label">ORIGEN:</span>
                    <div class="field-underline">{{ $venta->origen }}</div>
                </div>

                <div class="field-row">
                    <span class="field-label">DESTINO:</span>
                    <div class="field-underline">{{ $venta->destino }}</div>
                </div>

                <div class="field-row">
                    <span class="field-label">RESPONSABLE/SUMINISTRO:</span>
                    <div class="field-underline"></div>
                </div>

                <div class="field-row">
                    <span class="field-label">OBSERVACIONES:</span>
                    <div class="field-underline"></div>
                </div>
            </div>
        </div>

        <!-- Firmas -->
        <div class="signatures">
            <div class="signature-box">
                <div class="signature-title">DESPACHADOR</div>
                <div class="signature-line"></div>
                <div class="signature-field">NOMBRE: _________________________</div>
                <div class="signature-field">C.I.: _________________________</div>
            </div>

            <div class="signature-box">
                <div class="signature-title">CONDUCTOR</div>
                <div class="signature-line"></div>
                <div class="signature-field">NOMBRE: {{ $venta->volqueta->conductor }}</div>
                <div class="signature-field">C.I.: _________________________</div>
            </div>

            <div class="signature-box">
                <div class="signature-title">RECIBÍ CONFORME</div>
                <div class="signature-line"></div>
                <div class="signature-field">NOMBRE: _________________________</div>
                <div class="signature-field">C.I.: _________________________</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            "GRAPHIC FLORES PUBLICIDAD" -Impresión: {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }} *Formas
            de: 51201 a 53200 * ORIGINAL 2 COPIAS * E-mail: graficasflores@hotmail.com Telf.: 0982968976
        </div>
    </div>

    <script>
        function intentarImprimir() {
            try {
                window.print();
            } catch (e) {
                console.error('Error al imprimir:', e);
                alert('Por favor, presiona Ctrl+P para imprimir');
            }
        }

        // Múltiples eventos para asegurar que se dispare
        if (document.readyState === 'complete') {
            setTimeout(intentarImprimir, 300);
        } else {
            window.addEventListener('load', function() {
                setTimeout(intentarImprimir, 300);
            });
        }
    </script>
</body>

</html>
