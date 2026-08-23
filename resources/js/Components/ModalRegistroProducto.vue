<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    show: Boolean
});

const emit = defineEmits(['close']);

// Estado para alternar entre el formulario y el mensaje de éxito
const isSuccess = ref(false);

const form = useForm({
    nombre_marca: '',
    nombre_modelo: '',
    almacenamiento: '',
    ram: '',
    serial: ''
});

const submit = () => {
    form.post(route('admin.dashboard.equipos.store'), {
        onSuccess: () => {
            form.reset();
            isSuccess.value = true; // Muestra la tarjeta de éxito
        }
    });
};

const handleClose = () => {
    isSuccess.value = false; // Reinicia el modal al estado inicial
    emit('close');
};
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
        
        <!-- Vista 1: Formulario de Registro -->
        <div 
            v-if="!isSuccess" 
            class="bg-white rounded-[28px] p-8 max-w-md w-full shadow-2xl relative border border-gray-100"
        >
            <button 
                @click="handleClose"
                class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition text-lg font-bold"
            >
                ✕
            </button>

            <h2 class="text-2xl font-black text-center text-black mb-6 tracking-tight">
                Registro Producto Nuevo
            </h2>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block text-xs font-extrabold text-gray-700 mb-1">Nombre Marca</label>
                    <input 
                        v-model="form.nombre_marca"
                        type="text" 
                        placeholder="Ingresa de la marca"
                        class="w-full bg-[#f4f4f5] border-none rounded-full px-5 py-2.5 text-xs text-black placeholder-gray-400 focus:ring-2 focus:ring-blue-600 outline-none transition"
                        required
                    />
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-gray-700 mb-1">Nombre Modelo</label>
                    <input 
                        v-model="form.nombre_modelo"
                        type="text" 
                        placeholder="Ingresa el nombre del modelo."
                        class="w-full bg-[#f4f4f5] border-none rounded-full px-5 py-2.5 text-xs text-black placeholder-gray-400 focus:ring-2 focus:ring-blue-600 outline-none transition"
                        required
                    />
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-gray-700 mb-1">Capacidad (Almacenamiento)</label>
                    <input 
                        v-model="form.almacenamiento"
                        type="text" 
                        placeholder="Ingresa el almacenamiento."
                        class="w-full bg-[#f4f4f5] border-none rounded-full px-5 py-2.5 text-xs text-black placeholder-gray-400 focus:ring-2 focus:ring-blue-600 outline-none transition"
                        required
                    />
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-gray-700 mb-1">Capacidad (Ram)</label>
                    <input 
                        v-model="form.ram"
                        type="text" 
                        placeholder="Ingresa la memoria RAM."
                        class="w-full bg-[#f4f4f5] border-none rounded-full px-5 py-2.5 text-xs text-black placeholder-gray-400 focus:ring-2 focus:ring-blue-600 outline-none transition"
                        required
                    />
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-gray-700 mb-1">Serial del equipo</label>
                    <input 
                        v-model="form.serial"
                        type="text" 
                        placeholder="Ingresa el serial."
                        class="w-full bg-[#f4f4f5] border-none rounded-full px-5 py-2.5 text-xs text-black placeholder-gray-400 focus:ring-2 focus:ring-blue-600 outline-none transition"
                        required
                    />
                </div>

                <div class="pt-4 flex justify-center">
                    <button 
                        type="submit"
                        :disabled="form.processing"
                        class="bg-[#1b2a4a] hover:bg-[#121c33] text-white font-extrabold text-xs px-8 py-3 rounded-full transition shadow-md disabled:opacity-50"
                    >
                        Agregar Dispositivo
                    </button>
                </div>
            </form>
        </div>

        <!-- Vista 2: Mensaje de Éxito -->
        <div 
            v-else 
            class="bg-white rounded-3xl p-8 max-w-lg w-full shadow-2xl flex items-center justify-between gap-6 font-['Poppins',sans-serif]"
        >
            <div class="w-24 h-24 rounded-full bg-[#38a838] flex items-center justify-center flex-shrink-0 shadow-md">
                <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <div class="flex-1 flex flex-col items-start justify-center space-y-4">
                <h3 class="text-xl font-extrabold text-gray-900 leading-snug">
                    ¡Dispositivo agregado correctamente!
                </h3>
                <button 
                    @click="handleClose"
                    class="px-8 py-2.5 bg-[#243c7a] hover:bg-[#1a2d5d] text-white font-medium text-sm rounded-full shadow-md transition duration-200"
                >
                    Volver al Menú
                </button>
            </div>
        </div>

    </div>
</template>