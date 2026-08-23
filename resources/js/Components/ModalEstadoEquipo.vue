<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    solicitud: {
        type: Object,
        required: true
    },
    estados: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['close']);

const form = useForm({
    estado_id: props.solicitud?.id_estado_actual || '',
    observacion: ''
});

const cerrarModal = () => {
    form.reset();
    form.clearErrors();
    emit('close');
};

const submit = () => {
    form.patch(route('admin.garantias.actualizar-estado', props.solicitud.id_solicitud), {
        onSuccess: () => {
            cerrarModal();
        }
    });
};
</script>

<template>
    <div 
        v-if="show" 
        class="fixed inset-0 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4 z-50 transition-opacity"
        @click.self="cerrarModal"
    >
        <div class="bg-white rounded-[32px] p-8 max-w-md w-full shadow-2xl relative font-['Poppins',sans-serif]">
            
            <!-- Encabezado -->
            <div class="text-center mb-8">
                <h2 class="text-2xl font-black text-black tracking-tight mb-3">
                    Actualizar Estado Equipo
                </h2>
                <p class="text-xs font-semibold text-gray-400 max-w-xs mx-auto leading-relaxed">
                    Le enviaremos una notificación a 
                    <span class="text-gray-700 font-bold">
                        {{ solicitud.cliente || 'Cliente' }}
                    </span> 
                    sobre el equipo.
                </p>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                
                <!-- Selector Estado -->
                <div class="relative">
                    <select 
                        v-model="form.estado_id"
                        required
                        class="w-full bg-[#f8f9fa] border border-gray-200/80 rounded-2xl py-3.5 px-5 text-sm font-bold text-gray-800 appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500/20 shadow-xs cursor-pointer"
                    >
                        <option value="" disabled>Estado</option>
                        <option 
                            v-for="est in estados" 
                            :key="est.id_estado" 
                            :value="est.id_estado"
                        >
                            {{ est.nombre_estado }}
                        </option>
                    </select>
                    
                    <!-- Icono de flecha desplegable -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Input Observaciones -->
                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-2 pl-1">
                        Observaciones
                    </label>
                    <textarea 
                        v-model="form.observacion"
                        rows="4"
                        placeholder="Escriba aquí los detalles sobre el estado actual del equipo..."
                        required
                        class="w-full bg-[#f8f9fa] border border-gray-200/80 rounded-2xl p-4 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 resize-none placeholder-gray-400 shadow-xs"
                    ></textarea>
                </div>

                <!-- Botón de Acción Principal -->
                <div class="flex justify-center pt-2">
                    <button 
                        type="submit"
                        :disabled="form.processing"
                        class="w-full max-w-[200px] bg-[#21397b] hover:bg-[#1a2e63] text-white font-bold text-sm py-3.5 rounded-2xl transition shadow-md cursor-pointer disabled:opacity-50"
                    >
                        Actualizar
                    </button>
                </div>

            </form>

        </div>
    </div>
</template>