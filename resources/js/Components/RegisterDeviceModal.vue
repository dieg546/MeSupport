<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    marcas: {
        type: Array,
        default: () => [],
    },
    modelos: {
        type: Array,
        default: () => [],
    },
    tiendas: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(['close', 'add-device']);

const isSuccess = ref(false);

// Instancia de useForm alineada con las columnas/inputs
const form = useForm({
    brand: '',
    id_modelo: '',
    id_tienda: '',
    serial_equipo: '',
    imei_equipo: '',
    fecha_compra: '',
});

// Computed para filtrar modelos según la marca seleccionada
const modelosFiltrados = computed(() => {
    if (!form.brand) return [];

    return props.modelos.filter((m) => {
        const marcaIdEnModelo = m.id_marca ?? m.marca_id;
        return String(marcaIdEnModelo) === String(form.brand);
    });
});

// Resetea el modelo al cambiar de marca
const handleBrandChange = () => {
    form.id_modelo = '';
};

// Envío a Laravel
const submitDevice = () => {
    form.post(route('equipos.store'), {
        preserveScroll: true,
        onSuccess: () => {
            isSuccess.value = true;
            emit('add-device');
            form.reset();
        },
    });
};

const handleClose = () => {
    isSuccess.value = false;
    form.clearErrors();
    emit('close');
};
</script>

<template>
    <div 
        v-if="show" 
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm p-4"
        @click.self="handleClose"
    >
        <!-- FORMULARIO -->
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
                <!-- SELECT MARCA -->
                <div>
                    <div class="relative">
                        <select 
                            v-model="form.brand"
                            @change="handleBrandChange"
                            class="w-full px-5 py-3 bg-[#f5f5f5] border border-gray-200 rounded-full text-gray-700 text-sm font-bold appearance-none focus:outline-none focus:bg-white focus:border-blue-500 transition"
                            required
                        >
                            <option value="" disabled>Marca</option>
                            <option 
                                v-for="marca in marcas" 
                                :key="marca.id_marca" 
                                :value="marca.id_marca"
                            >
                                {{ marca.nombre_marca }}
                            </option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-600">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.293 12.95l0.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- SELECT MODELO -->
                <div>
                    <div class="relative">
                        <select 
                            v-model="form.id_modelo"
                            :disabled="!form.brand"
                            class="w-full px-5 py-3 bg-[#f5f5f5] border border-gray-200 rounded-full text-gray-700 text-sm font-bold appearance-none focus:outline-none focus:bg-white focus:border-blue-500 transition disabled:opacity-50"
                            required
                        >
                            <option value="" disabled>
                                {{ form.brand ? 'Modelo' : 'Seleccione una Marca primero' }}
                            </option>
                            <option 
                                v-for="modelo in modelosFiltrados" 
                                :key="modelo.id_modelo" 
                                :value="modelo.id_modelo"
                            >
                                {{ modelo.nombre_modelo }}
                            </option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-600">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.293 12.95l0.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                    <span v-if="form.errors.id_modelo" class="text-xs text-red-500 ml-3 mt-1 block">{{ form.errors.id_modelo }}</span>
                </div>

                <!-- SELECT TIENDA -->
                <div>
                    <div class="relative">
                        <select 
                            v-model="form.id_tienda"
                            class="w-full px-5 py-3 bg-[#f5f5f5] border border-gray-200 rounded-full text-gray-700 text-sm font-bold appearance-none focus:outline-none focus:bg-white focus:border-blue-500 transition"
                            required
                        >
                            <option value="" disabled>Tienda</option>
                            <option 
                                v-for="tienda in tiendas" 
                                :key="tienda.id_tienda" 
                                :value="tienda.id_tienda"
                            >
                                {{ tienda.nombre_tienda }}
                            </option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-600">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.293 12.95l0.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                    <span v-if="form.errors.id_tienda" class="text-xs text-red-500 ml-3 mt-1 block">{{ form.errors.id_tienda }}</span>
                </div>

                <!-- SERIAL -->
                <!-- <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1 ml-2">Serial Dispositivo</label>
                    <input 
                        v-model="form.serial_equipo"
                        type="text" 
                        placeholder="Ingresa el serial del dispositivo."
                        class="w-full px-5 py-2.5 bg-[#f5f5f5] border border-gray-200 rounded-full text-xs placeholder-gray-400 focus:outline-none focus:bg-white focus:border-blue-500 transition"
                        required
                    />
                    <span v-if="form.errors.serial_equipo" class="text-xs text-red-500 ml-3 mt-1 block">{{ form.errors.serial_equipo }}</span>
                </div> -->

                <!-- IMEI -->
                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1 ml-2">IMEI</label>
                    <input 
                        v-model="form.imei_equipo"
                        type="text" 
                        placeholder="Ingresa el IMEI del dispositivo."
                        class="w-full px-5 py-2.5 bg-[#f5f5f5] border border-gray-200 rounded-full text-xs placeholder-gray-400 focus:outline-none focus:bg-white focus:border-blue-500 transition"
                        required
                    />
                    <span v-if="form.errors.imei_equipo" class="text-xs text-red-500 ml-3 mt-1 block">{{ form.errors.imei_equipo }}</span>
                </div>

                <!-- FECHA DE COMPRA -->
                <div>
                    <label class="block text-xs font-bold text-gray-800 mb-1 ml-2">Fecha de la compra</label>
                    <input 
                        v-model="form.fecha_compra"
                        type="date" 
                        class="w-full px-5 py-2.5 bg-[#f5f5f5] border border-gray-200 rounded-full text-xs text-gray-600 focus:outline-none focus:bg-white focus:border-blue-500 transition"
                        required
                    />
                    <span v-if="form.errors.fecha_compra" class="text-xs text-red-500 ml-3 mt-1 block">{{ form.errors.fecha_compra }}</span>
                </div>

                <div class="pt-4 flex justify-center">
                    <button 
                        type="submit"
                        :disabled="form.processing"
                        class="w-full max-w-xs py-3 bg-[#243c7a] hover:bg-[#1a2d5d] text-white font-semibold text-sm rounded-2xl shadow-md transition duration-200 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Guardando...' : 'Agregar Dispositivo' }}
                    </button>
                </div>
            </form>
        </div>

        <!-- PANTALLA ÉXITO -->
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