<script setup>
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    devices: {
        type: Array,
        default: () => []
    }
});

// Normalización para soportar tanto arreglos planos como Resource Collections de Laravel
const rawDevices = computed(() => {
    return Array.isArray(props.devices?.data) ? props.devices.data : (Array.isArray(props.devices) ? props.devices : []);
});

// Filtra únicamente los equipos que aplican para reclamar garantía
const eligibleDevices = computed(() => {
    return rawDevices.value.filter(device => 
        device.status === 'Activa' || device.status === 'Por Vencer'
    );
});

// Manejo de la acción de solicitar garantía
const handleSolicitarGarantia = (device) => {
    router.get(route('garantias.create', device.id));   
};
</script>

<template>
    <AuthenticatedLayout title="Garantías">
        <!-- Título y Subtítulo -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 flex items-center gap-2">
                Solicitud Garantías 📲
            </h1>
            <p class="text-sm text-gray-500 mt-2 font-medium">
                Visualización de equipos y solicitudes de garantías
            </p>
        </div>

        <!-- Lista de Tarjetas Filtradas -->
        <div class="space-y-5 max-w-4xl">
            <div 
                v-for="device in eligibleDevices" 
                :key="device.id" 
                class="bg-white rounded-2xl p-6 border border-gray-100 shadow-md flex items-center justify-between transition hover:shadow-lg"
            >
                <!-- Información del Dispositivo -->
                <div class="space-y-1 text-sm text-gray-900">
                    <p>
                        <span class="font-bold">Dispositivo:</span> {{ device.name }}
                    </p>
                    <p>
                        <span class="font-bold">Capacidad:</span> 
                        <template v-if="typeof device.capacity === 'object'">
                            {{ device.capacity?.ram || 'N/A' }}/{{ device.capacity?.memoria || 'N/A' }}
                        </template>
                        <template v-else>
                            {{ device.capacity || 'N/A' }}
                        </template>
                    </p>
                    <p>
                        <span class="font-bold">Fecha fin garantía:</span> {{ device.endDate }}
                    </p>
                </div>

                <!-- Badges y Botón de Acción -->
                <div class="flex items-center gap-6">
                    <span 
                        v-if="device.status === 'Activa'" 
                        class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-semibold bg-[#d1fae5] text-[#065f46]"
                    >
                        <span class="bg-[#10b981] text-white p-0.5 rounded flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        Garantía Activa
                    </span>

                    <span 
                        v-else-if="device.status === 'Por Vencer'" 
                        class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-xs font-semibold bg-[#fef3c7] text-[#92400e]"
                    >
                        ⚠️ Por Vencer
                    </span>

                    <button 
                        @click="handleSolicitarGarantia(device)"
                        class="bg-[#243c7a] hover:bg-[#1a2d5d] text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition duration-150 shadow-sm"
                    >
                        Solicitar Garantía
                    </button>
                </div>
            </div>

            <!-- Mensaje si no hay equipos aptos -->
            <div 
                v-if="eligibleDevices.length === 0" 
                class="bg-white rounded-2xl p-8 border border-gray-100 shadow-md text-center text-gray-500"
            >
                <p class="text-base font-medium">No posees dispositivos con garantía vigente o por vencer.</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>