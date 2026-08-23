<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    solicitud: {
        type: Object,
        required: true
    }
});

// Control del estado del modal y tipo de acción
const mostrarModal = ref(false);
const tipoAccion = ref('aprobar'); // 'aprobar' o 'rechazar'

const form = useForm({
    estado_id: '',
    observacion: ''
});

// Abrir modal con contexto específico
const abrirModal = (estadoId, accion) => {
    tipoAccion.value = accion;
    form.estado_id = estadoId;
    form.observacion = '';
    mostrarModal.value = true;
};

const cerrarModal = () => {
    mostrarModal.value = false;
    form.reset();
};

// Enviar datos
const guardarObservacion = () => {
    form.patch(route('admin.garantias.actualizar-estado', props.solicitud.id), {
        onSuccess: () => cerrarModal()
    });
};

// Descargar archivo de evidencias
const descargarEvidencias = () => {
    if (props.solicitud?.evidencias_url) {
        window.open(props.solicitud.evidencias_url, '_blank');
    } else {
        alert('Esta solicitud no contiene evidencias adjuntas.');
    }
};
</script>

<template>
    <AdminLayout title="Gestión Solicitud">
        <div class="min-h-[80vh] flex items-center justify-center py-10 px-4 relative">
            <div class="bg-white rounded-[28px] p-10 max-w-lg w-full shadow-lg border border-gray-100 font-['Poppins',sans-serif]">
                
                <!-- Título -->
                <h1 class="text-3xl font-black text-center text-black mb-10 tracking-tight">
                    Gestion Solicitud
                </h1>

                <!-- Detalle del Producto y Solicitud -->
                <div class="space-y-4 text-sm mb-10 px-2">
                    <p class="text-black">
                        <span class="font-extrabold">Cliente:</span> {{ solicitud.cliente || 'N/A' }}
                    </p>
                    <p class="text-black">
                        <span class="font-extrabold">Dispositivo:</span> {{ solicitud.dispositivo || 'N/A' }}
                    </p>
                    <p class="text-black">
                        <span class="font-extrabold">Capacidad:</span> {{ solicitud.capacidad || 'N/A' }}
                    </p>
                    <p class="text-black">
                        <span class="font-extrabold">Serial:</span> {{ solicitud.serial || 'N/A' }}
                    </p>
                    <p class="text-black">
                        <span class="font-extrabold">IMEI:</span> {{ solicitud.imei || 'N/A' }}
                    </p>
                    <p class="text-black">
                        <span class="font-extrabold">Fallo:</span> {{ solicitud.falla || 'Sin descripción' }}
                    </p>
                    <p class="text-black">
                        <span class="font-extrabold">Fecha compra:</span> {{ solicitud.fecha_compra || 'N/A' }}
                    </p>
                    <p class="text-black">
                        <span class="font-extrabold">Fecha fin garantía:</span> {{ solicitud.fecha_fin_garantia || 'N/A' }}
                    </p>
                </div>

                <!-- Botón Descargar Evidencias -->
                <div class="flex justify-center mb-10">
                    <button 
                        @click="descargarEvidencias"
                        type="button"
                        :disabled="!solicitud?.evidencias_url"
                        class="flex items-center gap-3 bg-[#f3f4f6] border border-gray-300 rounded-lg px-6 py-2.5 hover:bg-gray-200 transition shadow-sm cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <div class="bg-[#e11d48] text-white text-[10px] font-black px-1.5 py-0.5 rounded">
                            PDF
                        </div>
                        <span class="text-sm font-extrabold text-gray-800">Descargar Evidencias</span>
                        <svg class="w-4 h-4 text-gray-600 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </button>
                </div>

                <!-- Acciones (Rechazar / Aceptar) -->
                <div class="flex items-center justify-center gap-6">
                    <button 
                        @click="abrirModal(4, 'rechazar')"
                        type="button"
                        class="w-36 py-3 bg-[#ff9ea0] hover:bg-[#ff8587] text-[#991b1b] font-black text-sm rounded-2xl transition shadow-sm cursor-pointer"
                    >
                        Rechazar
                    </button>
                    <button 
                        @click="abrirModal(3, 'aprobar')"
                        type="button"
                        class="w-36 py-3 bg-[#7ee7cb] hover:bg-[#62d3b5] text-[#065f46] font-black text-sm rounded-2xl transition shadow-sm cursor-pointer"
                    >
                        Aceptar
                    </button>
                </div>

            </div> 
        </div>

        <!-- MODAL: ASIGNAR OBSERVACIÓN / RECHAZAR SOLICITUD -->
        <div 
            v-if="mostrarModal" 
            class="fixed inset-0 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4 z-50 transition-opacity"
            @click.self="cerrarModal"
        >
            <div class="bg-white rounded-[24px] p-8 max-w-md w-full shadow-2xl relative font-['Poppins',sans-serif]">
                
                <!-- Título Dinámico -->
                <h2 class="text-2xl font-extrabold text-center text-black mb-8 tracking-tight">
                    {{ tipoAccion === 'rechazar' ? 'Rechazar Solicitud' : 'Asignar Observación' }}
                </h2>

                <form @submit.prevent="guardarObservacion" class="space-y-6">
                    <!-- Input Observaciones -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-2">
                            {{ tipoAccion === 'rechazar' ? 'Motivo del rechazo' : 'Observaciones' }}
                        </label>
                        <textarea 
                            v-model="form.observacion"
                            rows="4"
                            :placeholder="tipoAccion === 'rechazar' ? 'Indique la razón por la cual se rechaza la garantía...' : 'Escribe la observación aquí...'"
                            required
                            class="w-full bg-[#f3f4f6] border border-gray-200 rounded-2xl p-4 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 resize-none placeholder-gray-400"
                        ></textarea>
                    </div>

                    <!-- Botón Enviar Dinámico -->
                    <div class="flex justify-center pt-2">
                        <button 
                            type="submit"
                            :disabled="form.processing"
                            :class="[
                                'font-bold text-sm px-8 py-3 rounded-2xl transition shadow-md cursor-pointer disabled:opacity-50 text-white',
                                tipoAccion === 'rechazar' ? 'bg-[#991b1b] hover:bg-[#7f1d1d]' : 'bg-[#21397b] hover:bg-[#1a2e63]'
                            ]"
                        >
                            {{ tipoAccion === 'rechazar' ? 'Rechazar Solicitud' : 'Asignar Observacion' }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </AdminLayout>
</template>