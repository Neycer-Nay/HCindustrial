<div class="card">
    <div class="card-header bg-whitesmoke">
        <h4><i class="fas fa-desktop"></i> Equipo(s) a Recepcionar</h4>
        <div class="card-header-action">
            <button type="button" class="btn btn-primary" id="addEquipo">
                <i class="fas fa-plus"></i> Agregar Equipo
            </button>
        </div>
    </div>
    <div class="card-body" id="equiposContainer">
        <!-- Los equipos se agregarán aquí dinámicamente -->
    </div>
</div>

<!-- Plantilla para nuevos equipos (hidden) -->
<template id="equipoTemplate">
    <div class="card mb-3 equipo-item">
        <div class="card-header d-flex justify-content-between align-items-center ">
            <h5 class="mb-0">
                <i class="fas fa-desktop"></i> Equipo #<span class="equipo-count">1</span>
            </h5>
            <button type="button" class="btn btn-icon btn-danger remove-equipo">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Campos que siempre se muestran -->
                <div class="form-group col-md-6">
                    <label><strong>Articulo</strong> <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][nombre]" required>
                </div>
                <!-- ocultar mientras tanto no se implemente el número de serie
                 <div class="form-group col-md-6">
                    <label><strong>Número de Serie</strong></label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][serie]">
                </div>-->

                <!-- Selector de categoría de equipo -->
                <div class="form-group col-md-4">
                    <label><strong>Categoría de Equipo</strong><span class="text-danger">*</span></label>
                    <select class="form-control selectric" name="equipos[__INDEX__][tipo]" id="tipoEquipo__INDEX__"
                        required onchange="mostrarCamposPorTipo('__INDEX__')">
                        <option class="d-none" value="">Seleccione...</option>
                        <option value="MOTOR_ELECTRICO">Motor Eléctrico</option>
                        <option value="MAQUINA_SOLDADORA">Máquina Soldadora</option>
                        <option value="GENERADOR_DINAMO">Generador/Dinamo</option>
                        <option value="OTROS">Otros</option>
                    </select>
                </div>

                <!-- Campos comunes que se muestran según el tipo -->
                <div class="form-group col-md-4" id="marca__INDEX__" style="display: none;">
                    <label><strong>Marca</strong></label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][marca]" required>
                </div>
                <div class="form-group col-md-4" id="modelo__INDEX__" style="display: none;">
                    <label><strong>Tipo modelo</strong></label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][modelo]">
                </div>
                <div class="form-group col-md-4" id="color__INDEX__" style="display: none;">
                    <label><strong>Colores</strong><span class="text-danger">*</span></label>
                    <select class="form-control select-colores" name="equipos[__INDEX__][color][]" multiple>
                        <option value="Rojo">Rojo</option>
                        <option value="Azul">Azul</option>
                        <option value="Verde">Verde</option>
                        <option value="Amarillo">Amarillo</option>
                        <option value="Naranja">Naranja</option>
                        <option value="Morado">Morado</option>
                        <option value="Rosado">Rosado</option>
                        <option value="Negro">Negro</option>
                        <option value="Blanco">Blanco</option>
                        <option value="Gris">Gris</option>
                        <option value="Marrón">Marrón</option>
                        <option value="Cian">Cian</option>
                    </select>
                    <small class="form-text text-muted">Puedes seleccionar hasta 2 colores.</small>
                </div>
                <div class="form-group col-md-3" id="voltaje__INDEX__" style="display: none;">
                    <label><strong>Voltaje</strong></label>
                    <input type="number" class="form-control" name="equipos[__INDEX__][voltaje]">
                </div>

                <!-- Campos específicos para cada tipo -->
                <!-- Motor Eléctrico -->
                <div class="form-group col-md-3" id="hp__INDEX__" style="display: none;">
                    <label><strong>HP</strong></label>
                    <input type="number" class="form-control" name="equipos[__INDEX__][hp]">
                </div>
                <div class="form-group col-md-3" id="rpm__INDEX__" style="display: none;">
                    <label><strong>RPM</strong></label>
                    <input type="number" class="form-control" name="equipos[__INDEX__][rpm]">
                </div>
                <div class="form-group col-md-3" id="hz__INDEX__" style="display: none;">
                    <label><strong>Hz</strong></label>
                    <input type="number" class="form-control" name="equipos[__INDEX__][hz]">
                </div>
                <!--<div class="form-group col-md-3" id="kvaKw__INDEX__" style="display: none;">
                    <label><strong>Kva/Kw</strong></label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][kva_kw]">
                </div>-->

                <!-- Máquina Soldadora -->
                <div class="form-group col-md-3" id="amp__INDEX__" style="display: none;">
                    <label><strong>AMP</strong></label>
                    <input type="number" class="form-control" name="equipos[__INDEX__][amperaje]">
                </div>
                <div class="form-group col-md-3" id="cablePositivo__INDEX__" style="display: none;">
                    <label><strong>Cable +</strong></label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][cable_positivo]" value="No incluye"
                        readonly>
                </div>
                <div class="form-group col-md-3" id="cableNegativo__INDEX__" style="display: none;">
                    <label><strong>Cable -</strong></label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][cable_negativo]" value="No incluye"
                        readonly>
                </div>

                <!-- Generador/Dinamo -->
                <div class="form-group col-md-3" id="kvaKw__INDEX__" style="display: none;">
                    <label><strong>Kva/Kw</strong></label>
                    <input type="text" class="form-control" name="equipos[__INDEX__][kva_kw]">
                </div>

                <!-- Otros -->
                <div class="form-group col-md-3" id="potencia__INDEX__" style="display: none;">
                    <label><strong>Potencia</strong></label>
                    
                    <input type="number" class="form-control" name="equipos[__INDEX__][potencia]">
                    <select class="form-control" name="equipos[__INDEX__][potencia_unidad]">
                        <option value="Watts">Watts</option>
                        <option value="HP/CV">HP/CV</option>
                        <option value="KW">KW</option>
                    </select>
                </div>

                <!-- Campos que siempre se muestran
                <div class="form-group col-12">
                    <label><strong>Partes Faltantes</strong></label>
                    <textarea class="form-control" name="equipos[__INDEX__][partes_faltantes]" rows="2"></textarea>
                </div>

                <div class="form-group col-12">
                    <label><strong>Observaciones</strong></label>
                    <textarea class="form-control" name="equipos[__INDEX__][observaciones]" rows="2"></textarea>
                </div> -->
                <div class="form-group col-12">
                    <label><strong>Fotos del Equipo</strong> <span class="text-danger">*</span></label>
                    <small class="form-text text-muted mb-2">
                        <i class="fas fa-info-circle"></i> Es obligatorio agregar al menos una foto por equipo
                    </small>

                    <!-- Pestañas para seleccionar modo -->
                    <ul class="nav nav-tabs" id="fotoTabs__INDEX__" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="archivo-tab__INDEX__" data-toggle="tab"
                                href="#archivo__INDEX__" role="tab">
                                <i class="fas fa-folder-open"></i>Selección de archivo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="camara-tab__INDEX__" data-toggle="tab" href="#camara__INDEX__"
                                role="tab">
                                <i class="fas fa-camera"></i> Tomar foto
                            </a>
                        </li>
                    </ul>
                    <div class="form-text mt-2">
                        Puede seleccionar hasta 8 fotos incluyendo tomadas de camara y
                        seleccionados (JPEG, PNG, JPG, GIF) - Máx. 8MB cada una
                    </div>

                    <div class="tab-content" id="fotoTabContent__INDEX__">
                        <!-- Pestaña de archivos -->

                        <div class="tab-pane fade show active" id="archivo__INDEX__" role="tabpanel">
                            <div class="custom-file mb-3 mt-3" style="height: 120px;">
                                <input type="file" class="custom-file-input" id="fileInput__INDEX__"
                                    name="equipos[__INDEX__][fotos][]" multiple
                                    accept="image/jpeg,image/png,image/jpg,image/gif"
                                    style="height: 100%; opacity: 0; position: absolute; cursor: pointer;">
                                <label
                                    class="custom-file-label text-black py-4 px-3 rounded shadow-sm border border-2 border-primary"
                                    style="height: 100%; display: flex; align-items: center; justify-content: center; cursor: pointer; border-style: dashed !important;">
                                    <div class="text-center">
                                        <i class="fas fa-cloud-upload-alt d-block mb-2" style="font-size: 1.5rem;"></i>
                                        Toca o haz clic para subir tus fotos
                                    </div>
                                </label>

                            </div>
                        </div>
                        <!-- Pestaña de cámara -->
                        <div class="tab-pane fade" id="camara__INDEX__" role="tabpanel">
                            <div class="camera-container mt-3">
                                <div class="d-flex justify-content-center mb-3">
                                    <video id="cameraVideo__INDEX__" width="300" height="225" autoplay
                                        style="border: 2px solid #ddd; border-radius: 8px; display: none;"></video>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" id="startCamera__INDEX__">
                                        <i class="fas fa-video"></i> Activar cámara
                                    </button>
                                    <button type="button" class="btn btn-success" id="capturePhoto__INDEX__"
                                        style="display: none;">
                                        <i class="fas fa-camera"></i> Tomar foto
                                    </button>
                                    <button type="button" class="btn btn-danger" id="stopCamera__INDEX__"
                                        style="display: none;">
                                        <i class="fas fa-stop"></i> Detener cámara
                                    </button>
                                </div>
                                <canvas id="cameraCanvas__INDEX__" width="300" height="225"
                                    style="display: none;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Contenedor de previsualizaciones mejorado -->
                    <label for="">Vista previa:</label>
                    <div id="allPreviews__INDEX__" class="preview-container">

                        <div class="empty-state" id="emptyState__INDEX__"
                            style="width: 100%; text-align: center; padding: 40px; color: #6c757d;">
                            <i class="fas fa-images fa-3x mb-3" style="opacity: 0.5;"></i>
                            <p class="mb-0"><strong>No hay fotos agregadas</strong></p>
                            <small>Selecciona archivos o toma fotos para previsualizarlas aquí</small>
                        </div>
                        <!-- Previsualizaciones de archivos -->
                        <div id="filePreviews__INDEX__"></div>
                        <!-- Previsualizaciones de cámara -->
                        <div id="cameraPreviews__INDEX__"></div>
                    </div>

                    <!-- Campos ocultos para fotos de cámara -->
                    <div id="cameraInputs__INDEX__"></div>
                </div>

            </div>
        </div>
    </div>
</template>
<!-- Modal para editar fotos -->
<div class="modal fade" id="photoEditorModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-crop"></i> Recortar Foto
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="img-container">
                            <img id="cropperImage" style="max-width: 100%;">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="preview-container">
                            <h6>Vista previa:</h6>
                            <div class="preview"
                                style="width: 150px; height: 150px; overflow: hidden; border: 1px solid #ddd; margin-bottom: 10px;">
                            </div>
                            <div class="btn-group-vertical w-100">
                                <button type="button" class="btn btn-sm btn-secondary" onclick="resetCrop()">
                                    <i class="fas fa-undo"></i> Resetear
                                </button>
                                <button type="button" class="btn btn-sm btn-info" onclick="rotateImage(-90)">
                                    <i class="fas fa-undo"></i> Rotar ↺
                                </button>
                                <button type="button" class="btn btn-sm btn-info" onclick="rotateImage(90)">
                                    <i class="fas fa-redo"></i> Rotar ↻
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="cropAndSave">
                    <i class="fas fa-check"></i> Recortar y Guardar
                </button>
            </div>
        </div>
    </div>
</div>
<style>
    /* Estilos mejorados para previsualizaciones */
    .preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 15px;
        max-height: 300px;
        overflow-y: auto;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border: 2px dashed #dee2e6;
    }

    .preview-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        background: white;
        border: 3px solid #e9ecef;
    }

    .preview-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        border-color: #007bff;
    }

    .preview-item img {
        width: 160px;
        height: 160px;
        object-fit: cover;
        display: block;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .preview-item img:hover {
        transform: scale(1.05);
    }

    .preview-controls {
        position: absolute;
        top: 8px;
        right: 8px;
        display: flex;
        gap: 5px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .preview-item:hover .preview-controls {
        opacity: 1;
    }

    .preview-controls .btn {
        width: 32px;
        height: 32px;
        padding: 0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        border: 2px solid white;
    }

    .preview-badge {
        position: absolute;
        bottom: 8px;
        left: 8px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: bold;
    }

    /* Responsive para móviles */
    @media (max-width: 768px) {
        .preview-container {
            gap: 10px;
            max-height: 250px;
            padding: 8px;
        }

        .preview-item img {
            width: 120px;
            height: 120px;
        }

        .preview-controls {
            opacity: 1;
            /* Siempre visible en móviles */
        }

        .preview-controls .btn {
            width: 28px;
            height: 28px;
            font-size: 10px;
        }
    }

    @media (max-width: 480px) {
        .preview-item img {
            width: 100px;
            height: 100px;
        }

        .preview-container {
            gap: 8px;
            padding: 6px;
        }
    }

    /* Modal para vista ampliada */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        animation: fadeIn 0.3s ease;
    }

    .image-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-modal-content {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        border-radius: 8px;
        box-shadow: 0 0 50px rgba(255, 255, 255, 0.1);
    }

    .image-modal-close {
        position: absolute;
        top: 20px;
        right: 30px;
        color: white;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .image-modal-close:hover {
        color: #ff6b6b;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* Espaciado adicional para los botones */
    .mt-4 {
        margin-top: 2rem !important;
    }

    /* Estilo para cámara fullscreen */
    .camera-fullscreen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.95);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .camera-fullscreen video {
        max-width: 100%;
        max-height: 80vh;
        width: auto;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
    }

    .camera-fullscreen .controls {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 20px;
        z-index: 10000;
    }

    .camera-fullscreen .controls button {
        padding: 15px 25px;
        font-size: 18px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .camera-fullscreen .controls button:hover {
        transform: scale(1.1);
    }

    .camera-fullscreen .close-btn {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid white;
        color: white;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .camera-fullscreen .close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    .camera-info {
        position: absolute;
        top: 20px;
        left: 20px;
        color: white;
        font-size: 18px;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    }

    /* Responsivo para móviles */
    @media (max-width: 768px) {
        .camera-fullscreen .controls {
            bottom: 70px;
            gap: 15px;
        }

        .camera-fullscreen .controls button {
            padding: 12px 20px;
            font-size: 16px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let equipoCount = 0;
        const equiposContainer = document.getElementById('equiposContainer');
        const equipoTemplate = document.getElementById('equipoTemplate').innerHTML;

        function checkPhotoRequirement(index) {
            const fileInput = document.getElementById(`fileInput${index}`);
            const cameraPreviewContainer = document.getElementById(`cameraPreviews${index}`);
            const photoLabel = document.querySelector(`#equiposContainer .equipo-item:nth-child(${index + 1}) label[for*="fotos"]`);

            const hasFilePhotos = fileInput && fileInput.files && fileInput.files.length > 0;
            const hasCameraPhotos = cameraPreviewContainer && cameraPreviewContainer.children.length > 0;

            // Mostrar/ocultar estado vacío
            toggleEmptyState(index, hasFilePhotos || hasCameraPhotos);

            // Agregar/quitar clase de error visual
            if (!hasFilePhotos && !hasCameraPhotos) {
                if (photoLabel) {
                    photoLabel.classList.add('text-danger');
                    photoLabel.innerHTML = '<strong>Fotos del Equipo</strong> <span class="text-danger">* (Requerido)</span>';
                }
            } else {
                if (photoLabel) {
                    photoLabel.classList.remove('text-danger');
                    photoLabel.innerHTML = '<strong>Fotos del Equipo</strong> <span class="text-danger">*</span>';
                }
            }
        }

        // Función para mostrar/ocultar estado vacío
        function toggleEmptyState(index, hasPhotos) {
            const emptyState = document.getElementById(`emptyState${index}`);
            if (emptyState) {
                emptyState.style.display = hasPhotos ? 'none' : 'block';
            }
        }

        // Función para previsualizar archivos
        function previewFiles(input, index) {
            const previewContainer = document.getElementById(`filePreviews${index}`);
            const cameraPreviewContainer = document.getElementById(`cameraPreviews${index}`);
            previewContainer.innerHTML = '';
            const MAX_SIZE_MB = 8;
            const MAX_SIZE_BYTES = MAX_SIZE_MB * 1024 * 1024;

            // ✅ VALIDAR TOTAL DE FOTOS (ARCHIVOS + CÁMARA)
            const totalCameraPhotos = cameraPreviewContainer.children.length;
            const totalFilePhotos = input.files ? input.files.length : 0;
            const totalPhotos = totalFilePhotos + totalCameraPhotos;

            if (totalPhotos > 8) {
                Swal.fire({
                    icon: 'error',
                    title: 'Límite de fotos superado',
                    text: `No puedes seleccionar más fotos. Ya tienes ${totalCameraPhotos} fotos de cámara y ${totalFilePhotos} seleccionados. El límite máximo es de 8 fotos por equipo.`,
                    confirmButtonText: 'Entendido'
                });
                input.value = '';
                const label = input.nextElementSibling;
                label.textContent = 'Seleccionar fotos';
                return;
            }

            if (input.files && input.files.length > 8) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error cantidad de fotos superada',
                    text: 'No puedes seleccionar más de 8 fotos. Por favor, selecciona hasta 8 archivos.',
                    confirmButtonText: 'Entendido'
                });
                input.value = '';
                const label = input.nextElementSibling;
                label.textContent = 'Seleccionar fotos';
                return;
            }

            if (input.files) {
                let hasInvalidSize = false;

                Array.from(input.files).forEach(file => {
                    if (file.size > MAX_SIZE_BYTES) {
                        hasInvalidSize = true;
                    }
                });

                if (hasInvalidSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error tamaño superado',
                        text: `Una o más fotos superan el tamaño máximo de ${MAX_SIZE_MB}MB. Por favor, selecciona archivos más pequeños.`,
                        confirmButtonText: 'Entendido'
                    });
                    input.value = '';
                    const label = input.nextElementSibling;
                    label.textContent = 'Seleccionar fotos';
                    return;
                }

                // Actualizar en la función previewFiles, cambiar esta parte:
                Array.from(input.files).forEach((file, fileIndex) => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const div = document.createElement('div');
                        div.className = 'preview-item';
                        div.innerHTML = `
            <img src="${e.target.result}" onclick="showImageModal('${e.target.result}')" title="Clic para ver en tamaño completo">
            <div class="preview-controls">
                <button type="button" class="btn btn-warning btn-sm" onclick="openPhotoEditor('${e.target.result}', ${index}, 'file', ${fileIndex})" title="Editar foto">
                    <i style="font-size: 20px;" class="fas fa-crop"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm" onclick="removePreview(this)" title="Eliminar foto">
                    <i style="font-size: 20px;" class="fas fa-times"></i>
                </button>
            </div>
            <div class="preview-badge">
                <i class="fas fa-file"></i> Archivo
            </div>                        `;
                        previewContainer.appendChild(div);

                        // Ocultar estado vacío
                        toggleEmptyState(index, true);
                    }
                    reader.readAsDataURL(file);
                });

                const label = input.nextElementSibling;
                label.textContent = input.files.length > 1 ?
                    `${input.files.length} archivos seleccionados` :
                    input.files[0].name;
            }
        }

        // Función para manejar la cámara con fullscreen
        function setupCamera(index) {
            const video = document.getElementById(`cameraVideo${index}`);
            const canvas = document.getElementById(`cameraCanvas${index}`);
            const startBtn = document.getElementById(`startCamera${index}`);
            const captureBtn = document.getElementById(`capturePhoto${index}`);
            const stopBtn = document.getElementById(`stopCamera${index}`);
            const previewContainer = document.getElementById(`cameraPreviews${index}`);
            const inputContainer = document.getElementById(`cameraInputs${index}`);

            let stream = null;
            let cameraPhotoCount = 0;
            let fullscreenContainer = null;

            // Activar cámara en fullscreen
            startBtn.addEventListener('click', async function () {
                try {
                    // Verificar si getUserMedia está disponible
                    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                        throw new Error('getUserMedia no está soportado en este navegador');
                    }

                    // Verificar permisos primero
                    const permissions = await navigator.permissions.query({ name: 'camera' });
                    console.log('Permisos de cámara:', permissions.state);

                    if (permissions.state === 'denied') {
                        throw new Error('Permisos de cámara denegados');
                    }

                    // Obtener dispositivos de cámara disponibles
                    const devices = await navigator.mediaDevices.enumerateDevices();
                    const cameras = devices.filter(device => device.kind === 'videoinput');

                    if (cameras.length === 0) {
                        throw new Error('No se encontraron cámaras disponibles');
                    }

                    console.log('Cámaras disponibles:', cameras);

                    // Intentar diferentes configuraciones
                    let stream = null;
                    const constraints = [
                        // Configuración ideal
                        {
                            video: {
                                width: { ideal: 1920 },
                                height: { ideal: 1080 },
                                facingMode: 'environment'
                            }
                        },
                        // Configuración básica
                        {
                            video: {
                                width: { ideal: 1280 },
                                height: { ideal: 720 }
                            }
                        },
                        // Configuración mínima
                        {
                            video: true
                        }
                    ];

                    for (const constraint of constraints) {
                        try {
                            stream = await navigator.mediaDevices.getUserMedia(constraint);
                            console.log('Stream obtenido con:', constraint);
                            break;
                        } catch (constraintError) {
                            console.log('Error con constraint:', constraint, constraintError);
                            continue;
                        }
                    }

                    if (!stream) {
                        throw new Error('No se pudo obtener stream de cámara con ninguna configuración');
                    }

                    // Crear contenedor fullscreen
                    fullscreenContainer = document.createElement('div');
                    fullscreenContainer.className = 'camera-fullscreen';
                    fullscreenContainer.innerHTML = `
                        <div class="camera-info">
                            <i class="fas fa-camera"></i> Equipo #${index + 1} - Tomar Foto
                        </div>
                        <button class="close-btn" onclick="closeCameraFullscreen(${index})">
                            <i class="fas fa-times"></i>
                        </button>
                        <video id="fullscreenVideo${index}" autoplay playsinline></video>
                        <div class="controls">
                            <button type="button" class="btn btn-success btn-lg" onclick="captureFullscreenPhoto(${index})">
                                <i class="fas fa-camera"></i> Capturar
                            </button>
                            <button type="button" class="btn btn-danger btn-lg" onclick="closeCameraFullscreen(${index})">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                        </div>
                    `;

                    document.body.appendChild(fullscreenContainer);
                    document.body.style.overflow = 'hidden';

                    // Asignar stream al video fullscreen
                    const fullscreenVideo = document.getElementById(`fullscreenVideo${index}`);
                    fullscreenVideo.srcObject = stream;

                    // Ocultar botones originales
                    startBtn.style.display = 'none';
                    captureBtn.style.display = 'none';
                    stopBtn.style.display = 'none';

                } catch (err) {
                    console.error('Error detallado:', err);

                    let errorMessage = 'Error desconocido al acceder a la cámara.';
                    let errorTitle = 'Error de cámara';

                    switch (err.name) {
                        case 'NotAllowedError':
                            errorTitle = 'Permisos denegados';
                            errorMessage = 'Has denegado el acceso a la cámara. Por favor, permite el acceso en la configuración del navegador.';
                            break;
                        case 'NotFoundError':
                            errorTitle = 'Cámara no encontrada';
                            errorMessage = 'No se detectó ninguna cámara en tu dispositivo.';
                            break;
                        case 'NotReadableError':
                            errorTitle = 'Cámara en uso';
                            errorMessage = 'La cámara está siendo usada por otra aplicación. Cierra otras aplicaciones que puedan estar usando la cámara.';
                            break;
                        case 'OverconstrainedError':
                            errorTitle = 'Configuración no compatible';
                            errorMessage = 'La configuración de cámara solicitada no es compatible con tu dispositivo.';
                            break;
                        case 'SecurityError':
                            errorTitle = 'Error de seguridad';
                            errorMessage = 'El acceso a la cámara fue bloqueado por razones de seguridad. Asegúrate de estar usando HTTPS o localhost.';
                            break;
                        default:
                            errorMessage = `${err.message || err}`;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: errorTitle,
                        html: `
                            <p>${errorMessage}</p>
                            <hr>
                            <small><strong>Detalles técnicos:</strong><br>
                            ${err.name}: ${err.message}<br>
                            Navegador: ${navigator.userAgent.split(' ')[0]}<br>
                            Protocolo: ${location.protocol}</small>
                        `,
                        width: '500px',
                        confirmButtonText: 'Entendido'
                    });
                }
            });

            // Función global para cerrar fullscreen
            window.closeCameraFullscreen = function (equipoIndex) {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }

                if (fullscreenContainer) {
                    document.body.removeChild(fullscreenContainer);
                    fullscreenContainer = null;
                }

                document.body.style.overflow = 'auto'; // Restaurar scroll

                // Mostrar botón de inicio
                startBtn.style.display = 'inline-block';
                captureBtn.style.display = 'none';
                stopBtn.style.display = 'none';
            };

            // Función global para capturar foto en fullscreen
            window.captureFullscreenPhoto = function (equipoIndex) {
                // Validar límite de 8 fotos total
                const fileInput = document.getElementById(`fileInput${equipoIndex}`);
                const totalFilePhotos = fileInput.files ? fileInput.files.length : 0;
                const totalCameraPhotos = previewContainer.children.length;
                const totalPhotos = totalFilePhotos + totalCameraPhotos;

                if (totalPhotos >= 8) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Límite de fotos superado',
                        text: 'No puedes tomar más fotos. El límite máximo es de 8 fotos por equipo.',
                        confirmButtonText: 'Entendido'
                    });
                    return;
                }

                const fullscreenVideo = document.getElementById(`fullscreenVideo${equipoIndex}`);

                // Crear canvas temporal para captura
                const tempCanvas = document.createElement('canvas');
                const context = tempCanvas.getContext('2d');

                // Obtener dimensiones del video
                tempCanvas.width = fullscreenVideo.videoWidth;
                tempCanvas.height = fullscreenVideo.videoHeight;

                // Dibujar frame actual del video
                context.drawImage(fullscreenVideo, 0, 0);

                // Convertir a blob
                tempCanvas.toBlob(function (blob) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        // Crear preview
                        const div = document.createElement('div');
                        div.className = 'preview-item';
                        div.innerHTML = `
                    <img src="${e.target.result}" onclick="showImageModal('${e.target.result}')" title="Clic para ver en tamaño completo">
                    <div class="preview-controls">
                        <button type="button" class="btn btn-warning btn-sm" onclick="openPhotoEditor('${e.target.result}', ${equipoIndex}, 'camera', ${previewContainer.children.length})" title="Editar foto">
                            <i class="fas fa-crop"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeCameraPhoto(this, ${equipoIndex}, ${cameraPhotoCount})" title="Eliminar foto">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="preview-badge">
                        <i class="fas fa-camera"></i> Cámara
                    </div>
                `;
                        previewContainer.appendChild(div);

                        // Ocultar estado vacío
                        toggleEmptyState(equipoIndex, true);

                        // Crear input hidden con la imagen
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = `equipos[${equipoIndex}][camera_photos][]`;
                        input.value = e.target.result;
                        input.id = `cameraPhoto${equipoIndex}_${cameraPhotoCount}`;
                        inputContainer.appendChild(input);

                        cameraPhotoCount++;

                        // Cerrar fullscreen
                        closeCameraFullscreen(equipoIndex);

                        // Mostrar mensaje de confirmación
                        Swal.fire({
                            icon: 'success',
                            title: 'Foto capturada',
                            text: `Foto ${totalPhotos + 1} de 8 capturada correctamente.`,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    };
                    reader.readAsDataURL(blob);
                }, 'image/jpeg', 0.9); // Calidad alta
            };

            // Detener cámara (función original mantenida por compatibilidad)
            stopBtn.addEventListener('click', function () {
                closeCameraFullscreen(index);
            });
        }
       
        // Función global para remover preview (mejorada)
window.removePreview = function (button) {
    const previewItem = button.closest('.preview-item');
    const equipoContainer = previewItem.closest('.equipo-item');
    const equipoIndex = Array.from(equipoContainer.parentNode.children).indexOf(equipoContainer);
    
    // Obtener el índice de la foto eliminada dentro del contenedor de archivos
    const filePreviewContainer = document.getElementById(`filePreviews${equipoIndex}`);
    const fileIndex = Array.from(filePreviewContainer.children).indexOf(previewItem);
    
    // Obtener el input de archivo
    const fileInput = document.getElementById(`fileInput${equipoIndex}`);
    
    if (fileInput && fileInput.files) {
        // Crear un nuevo DataTransfer para reconstruir la lista de archivos
        const dt = new DataTransfer();
        
        // Agregar todos los archivos excepto el eliminado
        Array.from(fileInput.files).forEach((file, index) => {
            if (index !== fileIndex) {
                dt.items.add(file);
            }
        });
        
        // Actualizar el input con los archivos restantes
        fileInput.files = dt.files;
        
        // Actualizar el label del input
        const label = fileInput.nextElementSibling;
        if (fileInput.files.length === 0) {
            label.innerHTML = `
                <div class="text-center">
                    <i class="fas fa-cloud-upload-alt d-block mb-2" style="font-size: 1.5rem;"></i>
                    Toca o haz clic para subir tus fotos
                </div>
            `;
        } else {
            label.textContent = fileInput.files.length > 1 ? 
                `${fileInput.files.length} archivos seleccionados` : 
                fileInput.files[0].name;
        }
    }
    
    // Animación de salida y eliminación del preview
    previewItem.style.animation = 'fadeOut 0.3s ease';
    setTimeout(() => {
        previewItem.remove();
        // Verificar si quedan fotos y mostrar estado vacío si es necesario
        checkEmptyStateAfterRemoval(equipoIndex);
        
        // Mostrar mensaje de confirmación
        Swal.fire({
            icon: 'info',
            title: 'Foto eliminada',
            text: 'La foto ha sido eliminada correctamente.',
            timer: 1000,
            showConfirmButton: false
        });
    }, 300);
};

        // Función global para remover foto de cámara
        window.removeCameraPhoto = function (button, equipoIndex, photoIndex) {
            const previewItem = button.closest('.preview-item');
            const input = document.getElementById(`cameraPhoto${equipoIndex}_${photoIndex}`);

            // Animación de salida
            previewItem.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => {
                previewItem.remove();
                if (input) input.remove();
                // Verificar si quedan fotos y mostrar estado vacío si es necesario
                checkEmptyStateAfterRemoval(equipoIndex);
            }, 300);

            // ✅ MOSTRAR MENSAJE DE CONFIRMACIÓN
            Swal.fire({
                icon: 'info',
                title: 'Foto eliminada',
                text: 'La foto ha sido eliminada correctamente.',
                timer: 1000,
                showConfirmButton: false
            });
        };

        // Función para verificar estado vacío después de eliminar
        function checkEmptyStateAfterRemoval(equipoIndex) {
            const fileInput = document.getElementById(`fileInput${equipoIndex}`);
            const cameraPreviewContainer = document.getElementById(`cameraPreviews${equipoIndex}`);
            const filePreviewContainer = document.getElementById(`filePreviews${equipoIndex}`);

            const hasFilePhotos = filePreviewContainer && filePreviewContainer.children.length > 0;
            const hasCameraPhotos = cameraPreviewContainer && cameraPreviewContainer.children.length > 0;

            toggleEmptyState(equipoIndex, hasFilePhotos || hasCameraPhotos);
        }

        // Agregar nuevo equipo
        document.getElementById('addEquipo').addEventListener('click', function () {
            const newEquipoHTML = equipoTemplate.replace(/__INDEX__/g, equipoCount);
            const newEquipoElement = document.createElement('div');
            newEquipoElement.innerHTML = newEquipoHTML;
            equiposContainer.appendChild(newEquipoElement.firstElementChild);

            // Inicializar Select2 para colores
            $(`select[name="equipos[${equipoCount}][color][]"]`).select2({
                placeholder: "Seleccione colores",
                maximumSelectionLength: 2,
                width: '100%'
            });

            // Configurar cámara para este equipo
            setupCamera(equipoCount);

            // Mostrar campos básicos inicialmente
            mostrarCamposPorTipo(equipoCount);

            equipoCount++;
            reindexEquipos();

            // Inicializar selectric
            if (typeof $.fn.selectric !== 'undefined') {
                $('.selectric').selectric('destroy');
                $('.selectric').selectric();
            }

            // Animación
            const lastEquipo = equiposContainer.lastElementChild;
            lastEquipo.style.opacity = '0';
            let opacity = 0;
            const fadeIn = setInterval(() => {
                opacity += 0.1;
                lastEquipo.style.opacity = opacity;
                if (opacity >= 1) clearInterval(fadeIn);
            }, 50);
        });

        // Eliminar equipo
        equiposContainer.addEventListener('click', function (e) {
            if (e.target.closest('.remove-equipo')) {
                const equipoItem = e.target.closest('.equipo-item');

                // Detener cámara si está activa
                const video = equipoItem.querySelector('video');
                if (video && video.srcObject) {
                    video.srcObject.getTracks().forEach(track => track.stop());
                }

                equipoItem.style.opacity = '1';
                let opacity = 1;
                const fadeOut = setInterval(() => {
                    opacity -= 0.1;
                    equipoItem.style.opacity = opacity;
                    if (opacity <= 0) {
                        clearInterval(fadeOut);
                        equipoItem.remove();
                        reindexEquipos();
                    }
                }, 50);
            }
        });

        // Función para reindexar equipos
        function reindexEquipos() {
            const equipos = equiposContainer.querySelectorAll('.equipo-item');
            equipos.forEach((equipo, index) => {
                equipo.querySelector('.equipo-count').textContent = index + 1;

                equipo.querySelectorAll('[name^="equipos["]').forEach(input => {
                    const currentName = input.name;
                    const newName = currentName.replace(/equipos\[\d+\]/, `equipos[${index}]`);
                    input.name = newName;
                });

                // Actualizar IDs
                const elementos = equipo.querySelectorAll('[id*="__INDEX__"]');
                elementos.forEach(elemento => {
                    if (elemento.id) {
                        elemento.id = elemento.id.replace(/__INDEX__/, index);
                    }
                });

                const tipoSelect = equipo.querySelector('[name^="equipos["][name$="[tipo]"]');
                if (tipoSelect) {
                    tipoSelect.onchange = function () {
                        mostrarCamposPorTipo(index);
                    };
                }
            });

            equipoCount = equipos.length;
        }

        // Manejar cambio en inputs de archivo
        equiposContainer.addEventListener('change', function (e) {
            if (e.target.matches('.custom-file-input')) {
                const index = e.target.id.replace('fileInput', '');
                previewFiles(e.target, index);
            }
        });

        // Validación del formulario
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function (e) {
                let isValid = true;
                const equipos = equiposContainer.querySelectorAll('.equipo-item');

                if (equipos.length === 0) {
                    Swal.fire('Error', 'Debe agregar al menos un equipo', 'error');
                    isValid = false;
                }

                equipos.forEach((equipo, index) => {
                    const tipo = equipo.querySelector('[name^="equipos["][name$="[tipo]"]').value;
                    const marca = equipo.querySelector('[name^="equipos["][name$="[marca]"]');

                    // ✅ VALIDACIÓN DE FOTOS OBLIGATORIAS
                    const fileInput = equipo.querySelector('input[type="file"]');
                    const cameraPreviewContainer = equipo.querySelector(`#cameraPreviews${index}`);

                    const hasFilePhotos = fileInput && fileInput.files && fileInput.files.length > 0;
                    const hasCameraPhotos = cameraPreviewContainer && cameraPreviewContainer.children.length > 0;

                    if (!hasFilePhotos && !hasCameraPhotos) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Fotos requeridas',
                            text: `El equipo #${index + 1} debe tener al menos una foto. Por favor, sube una foto desde archivo o toma una con la cámara.`,
                            confirmButtonText: 'Entendido'
                        });
                        isValid = false;
                        return;
                    }

                    if (!tipo) {
                        Swal.fire('Error', `El tipo del equipo #${index + 1} es requerido`, 'error');
                        isValid = false;
                    }

                    if (marca && !marca.value) {
                        Swal.fire('Error', `La marca del equipo #${index + 1} es requerida`, 'error');
                        isValid = false;
                    }

                    // Detener cámaras antes de enviar
                    const video = equipo.querySelector('video');
                    if (video && video.srcObject) {
                        video.srcObject.getTracks().forEach(track => track.stop());
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                }
            });
        }
    });

    // Función para mostrar campos por tipo
    function mostrarCamposPorTipo(index) {
        const tipo = document.getElementById(`tipoEquipo${index}`)?.value;
        if (!tipo) return;

        const campos = {
            comunes: ['marca', 'modelo', 'color', 'voltaje'],
            MOTOR_ELECTRICO: ['hp', 'rpm', 'hz'],
            MAQUINA_SOLDADORA: ['amp', 'cablePositivo', 'cableNegativo'],
            GENERADOR_DINAMO: ['kvaKw', 'hz', 'rpm'],
            OTROS: ['potencia', 'potencia_unidad']
        };

        const todosCampos = [...campos.comunes, ...campos.MOTOR_ELECTRICO, ...campos.MAQUINA_SOLDADORA,
        ...campos.GENERADOR_DINAMO, ...campos.OTROS];

        todosCampos.forEach(campo => {
            const elemento = document.getElementById(`${campo}${index}`);
            if (elemento) {
                elemento.style.display = 'none';
                if (campo !== 'marca') {
                    const input = elemento.querySelector('input, select, textarea');
                    if (input) input.required = false;
                }
            }
        });

        campos.comunes.forEach(campo => {
            const elemento = document.getElementById(`${campo}${index}`);
            if (elemento) {
                elemento.style.display = 'block';
                if (campo === 'marca') {
                    const input = elemento.querySelector('input');
                    if (input) input.required = true;
                }
            }
        });

        if (campos[tipo]) {
            campos[tipo].forEach(campo => {
                const elemento = document.getElementById(`${campo}${index}`);
                if (elemento) elemento.style.display = 'block';
            });
        }
    }
    // Variables globales para el editor
    let cropper = null;
    let currentEditingEquipo = null;
    let currentEditingType = null; // 'file' o 'camera'
    let currentEditingIndex = null;

    // Función para abrir el editor de fotos
    function openPhotoEditor(imageSrc, equipoIndex, type, fileIndex = null) {
        currentEditingEquipo = equipoIndex;
        currentEditingType = type;
        currentEditingIndex = fileIndex;

        const cropperImage = document.getElementById('cropperImage');
        cropperImage.src = imageSrc;

        $('#photoEditorModal').modal('show');

        // Inicializar cropper cuando se abra el modal
        $('#photoEditorModal').on('shown.bs.modal', function () {
            if (cropper) {
                cropper.destroy();
            }

            cropper = new Cropper(cropperImage, {
                aspectRatio: NaN, // Permitir cualquier aspecto
                viewMode: 1,
                dragMode: 'crop',
                autoCropArea: 0.8,
                restore: false,
                guides: true,
                center: true,
                highlight: true,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                preview: '.preview'
            });
        });
    }

    // Función para resetear el recorte
    function resetCrop() {
        if (cropper) {
            cropper.reset();
        }
    }

    // Función para rotar imagen
    function rotateImage(degrees) {
        if (cropper) {
            cropper.rotate(degrees);
        }
    }

    // Función para recortar y guardar
    document.getElementById('cropAndSave').addEventListener('click', function () {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            width: 800,
            height: 600,
            imageSmoothingEnabled: false,
            imageSmoothingQuality: 'high',
        });

        canvas.toBlob(function (blob) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const croppedImageSrc = e.target.result;

                if (currentEditingType === 'camera') {
                    // Actualizar foto de cámara
                    updateCameraPhoto(croppedImageSrc, currentEditingEquipo, currentEditingIndex);
                } else {
                    // Actualizar foto de archivo
                    updateFilePhoto(croppedImageSrc, currentEditingEquipo, currentEditingIndex);
                }

                $('#photoEditorModal').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Foto editada',
                    text: 'La foto ha sido recortada correctamente.',
                    timer: 1500,
                    showConfirmButton: false
                });
            };
            reader.readAsDataURL(blob);
        }, 'image/jpeg', 0.8);
    });

    // Función para actualizar foto de cámara
    function updateCameraPhoto(newImageSrc, equipoIndex, photoIndex) {
        const previewContainer = document.getElementById(`cameraPreviews${equipoIndex}`);
        const photoDiv = previewContainer.children[photoIndex];
        const img = photoDiv.querySelector('img');
        const input = document.getElementById(`cameraPhoto${equipoIndex}_${photoIndex}`);

        if (img) {
            img.src = newImageSrc;
            // Actualizar el onclick para que use la imagen recortada
            img.setAttribute('onclick', `showImageModal('${newImageSrc}')`);
        }
        if (input) input.value = newImageSrc;
    }

    // Función para actualizar foto de archivo
    function updateFilePhoto(newImageSrc, equipoIndex, fileIndex) {
        const previewContainer = document.getElementById(`filePreviews${equipoIndex}`);
        const photoDiv = previewContainer.children[fileIndex];
        const img = photoDiv.querySelector('img');

        if (img) {
            img.src = newImageSrc;
            // Actualizar el onclick para que use la imagen recortada
            img.setAttribute('onclick', `showImageModal('${newImageSrc}')`);
        }

        // Crear nuevo archivo blob y actualizar el input
        fetch(newImageSrc)
            .then(res => res.blob())
            .then(blob => {
                const file = new File([blob], `edited_photo_${Date.now()}.jpg`, { type: 'image/jpeg' });
                const fileInput = document.getElementById(`fileInput${equipoIndex}`);
                const dt = new DataTransfer();

                // Mantener otros archivos y reemplazar el editado
                for (let i = 0; i < fileInput.files.length; i++) {
                    if (i === fileIndex) {
                        dt.items.add(file);
                    } else {
                        dt.items.add(fileInput.files[i]);
                    }
                }

                fileInput.files = dt.files;
            });
    }

    // Limpiar cropper al cerrar modal
    $('#photoEditorModal').on('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    });
    // Agregar al final del script, antes del cierre
    document.addEventListener('keydown', function (e) {
        // Si hay una cámara fullscreen activa
        if (document.querySelector('.camera-fullscreen')) {
            switch (e.key) {
                case 'Enter':
                case ' ': // Barra espaciadora
                    e.preventDefault();
                    // Buscar el botón de captura y hacer clic
                    const captureBtn = document.querySelector('.camera-fullscreen .btn-success');
                    if (captureBtn) captureBtn.click();
                    break;
                case 'Escape':
                    e.preventDefault();
                    // Buscar el botón de cancelar y hacer clic
                    const cancelBtn = document.querySelector('.camera-fullscreen .btn-danger');
                    if (cancelBtn) cancelBtn.click();
                    break;
            }
        }

        // Si hay un modal de imagen activo
        if (document.querySelector('.image-modal.show')) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        }
    });

    // Función para mostrar imagen en modal ampliado
    function showImageModal(imageSrc) {
        // Crear modal si no existe
        let modal = document.getElementById('imageModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'imageModal';
            modal.className = 'image-modal';
            modal.innerHTML = `
                <span class="image-modal-close" onclick="closeImageModal()">&times;</span>
                <img class="image-modal-content" id="modalImage">
            `;
            document.body.appendChild(modal);

            // Cerrar modal al hacer clic fuera de la imagen
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeImageModal();
                }
            });
        }

        // Mostrar imagen
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageSrc;
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    // Función para cerrar modal de imagen
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    }

    // Añadir animaciones CSS
    const animationStyles = document.createElement('style');
    animationStyles.textContent = `
        @keyframes fadeOut {
            from { 
                opacity: 1; 
                transform: scale(1); 
            }
            to { 
                opacity: 0; 
                transform: scale(0.8); 
            }
        }
        
        .preview-item {
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: scale(0.8); 
            }
            to { 
                opacity: 1; 
                transform: scale(1); 
            }
        }
    `;
    document.head.appendChild(animationStyles);
</script>