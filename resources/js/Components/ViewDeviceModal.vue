<script setup>
defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    device: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['close']);
</script>

<template>
    <div 
        v-if="show && device" 
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4 font-['Poppins',sans-serif]"
        @click.self="emit('close')"
    >
        <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative flex flex-col items-center text-center space-y-6">
            
            <!-- Botón de Cerrar (X) -->
            <button 
                @click="emit('close')" 
                type="button"
                class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Título -->
            <h2 class="text-2xl font-black text-gray-900">Datos Equipo</h2>

            <!-- Badge de Estado Dinámico -->
            <div>
                <span 
                    v-if="device.status === 'Activa'" 
                    class="inline-flex items-center justify-center gap-2 px-6 py-2 rounded-full text-sm font-semibold bg-[#d1fae5] text-[#065f46]"
                >
                    <span class="bg-[#10b981] text-white p-0.5 rounded flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                    Garantia Activa
                </span>

                <span 
                    v-else-if="device.status === 'Vencida'" 
                    class="inline-flex items-center justify-center gap-2 px-6 py-2 rounded-full text-sm font-semibold bg-[#fecdd3] text-[#9f1239]"
                >
                    🚫 Garantía Vencida
                </span>

                <span 
                    v-else-if="device.status === 'Por Vencer'" 
                    class="inline-flex items-center justify-center gap-2 px-6 py-2 rounded-full text-sm font-semibold bg-[#fef3c7] text-[#92400e]"
                >
                    ⚠️ Por Vencer
                </span>
            </div>

            <!-- Detalles del Dispositivo -->
            <div class="space-y-3 text-left w-full text-sm text-gray-900 pt-2 px-2">
                <p>
                    <span class="font-black">Dispositivo:</span> {{ device.name }}
                </p>
                <p>
                    <span class="font-black">Capacidad:</span> {{ device.capacity.ram || 'N/A' }}/ {{ device.capacity.memoria || 'N/A' }}
                </p>
                <p>
                    <span class="font-black">Serial:</span> {{ device.serial || 'N/A' }}
                </p>
                <p>
                    <span class="font-black">IMEI:</span> {{ device.imei || 'N/A' }}
                </p>
                <p>
                    <span class="font-black">Fecha compra:</span> {{ device.fechaCompra }}
                </p>
                <p>
                    <span class="font-black">Fecha fin garantía:</span> {{ device.endDate }}
                </p>
            </div>

            <!-- Botón Aceptar -->
            <div class="pt-4 w-full flex justify-center">
                <button 
                    @click="emit('close')"
                    class="w-full max-w-xs py-3 bg-[#243c7a] hover:bg-[#1a2d5d] text-white font-semibold text-sm rounded-2xl shadow-md transition duration-200"
                >
                    Aceptar
                </button>
            </div>

        </div>
    </div>
</template>