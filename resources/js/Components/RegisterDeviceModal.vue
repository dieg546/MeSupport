<script setup>
import { ref, reactive } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
});

// Eventos que emite el modal
const emit = defineEmits(['close', 'add-device']);

// Estado para alternar entre el formulario y el mensaje de éxito
const isSuccess = ref(false);

// Objeto reactivo local para los campos del formulario
const form = reactive({
    brand: '',
    model: '',
    store: '',
    serial: '',
    imei: '',
    purchase_date: '',
});

const submitDevice = () => {
    // 1. Emitir los datos formateados al componente padre (Dashboard)
    emit('add-device', {
        id: Date.now(),
        name: `${form.brand} ${form.model}`,
        capacity: '8/256',
        endDate: '12/12/2027',
        status: 'Activa',
    });

    // 2. Limpiar el formulario
    Object.assign(form, {
        brand: '',
        model: '',
        store: '',
        serial: '',
        imei: '',
        purchase_date: '',
    });

    // 3. Mostrar la vista de éxito
    isSuccess.value = true;
};

const handleClose = () => {
    isSuccess.value = false; // Resetear la vista para la próxima apertura
    emit('close');
};
</script>

<template>
    <div 
        v-if="show" 
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
        @click.self="handleClose"
    >
        <!-- PANTALLA 1: FORMULARIO -->
        <div 
            v-if="!isSuccess" 
            class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl relative font-['Poppins',sans-serif]"
        >
            <button 
                @click="handleClose" 
                type="button"
                class="absolute top-5 right-5 text-gray-400 hover:text-gray-600 transition"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <h2 class="text-2xl font-black text-center text-gray-900 mb-6">Registro Dispositivo</h2>

            <form @submit.prevent="submitDevice" class="space-y-4">
                <div class="relative">
                    <select 
                        v-model="form.brand"
                        class="w-full px-5 py-3 bg-[#f5f5f5] border border-gray-200 rounded-full text-gray-700 text-sm font-bold appearance-none focus:outline-none focus:bg-white focus:border-blue-500 transition"
                        required
                    >
                        <option value="" disabled selected>Marca</option>
                        <option value="Samsung">Samsung</option>
                        <option value="Xiaomi">Xiaomi</option>
                        <option value="Apple">Apple</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-600">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.293 12.95l0.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

                <div class="relative">
                    <select 
                        v-model="form.model"
                        class="w-full px-5 py-3 bg-[#f5f5f5] border border-gray-200 rounded-full text-gray-700 text-sm font-bold appearance-none focus:outline-none focus:bg-white focus:border-blue-500 transition"
                        required
                    >
                        <option value="" disabled selected>Modelo</option>
                        <option value="S26">S26</option>
                        <option value="POCO X8 PRO">POCO X8 PRO</option>
                        <option value="NOTE 15">NOTE 15</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-600">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.293 12.95l0.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

                <div class="relative">
                    <select 
                        v-model="form.store"
                        class="w-full px-5 py-3 bg-[#f5f5f5] border border-gray-200 rounded-full text-gray-700 text-sm font-bold appearance-none focus:outline-none focus:bg-white focus:border-blue-500 transition"
                        required
                    >
                        <option value="" disabled selected>Tienda</option>
                        <option value="Tienda Oficial">Tienda Oficial</option>
                        <option value="Distribuidor Autorizado">Distribuidor Autorizado</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-600">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.293 12.95l0.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1 ml-2">Serial Dispositivo</label>
                    <input 
                        v-model="form.serial"
                        type="text" 
                        placeholder="Ingresa el serial del dispositivo."
                        class="w-full px-5 py-2.5 bg-[#f5f5f5] border border-gray-200 rounded-full text-xs placeholder-gray-400 focus:outline-none focus:bg-white focus:border-blue-500 transition"
                        required
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1 ml-2">IMEI</label>
                    <input 
                        v-model="form.imei"
                        type="text" 
                        placeholder="Ingresa el serial del dispositivo."
                        class="w-full px-5 py-2.5 bg-[#f5f5f5] border border-gray-200 rounded-full text-xs placeholder-gray-400 focus:outline-none focus:bg-white focus:border-blue-500 transition"
                        required
                    />
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1 ml-2">Fecha de la compra</label>
                    <input 
                        v-model="form.purchase_date"
                        type="date" 
                        class="w-full px-5 py-2.5 bg-[#f5f5f5] border border-gray-200 rounded-full text-xs text-gray-600 focus:outline-none focus:bg-white focus:border-blue-500 transition"
                        required
                    />
                </div>

                <div class="pt-4 flex justify-center">
                    <button 
                        type="submit"
                        class="w-full max-w-xs py-3 bg-[#243c7a] hover:bg-[#1a2d5d] text-white font-semibold text-sm rounded-2xl shadow-md transition duration-200"
                    >
                        Agregar Dispositivo
                    </button>
                </div>
            </form>
        </div>

        <!-- PANTALLA 2: ÉXITO -->
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