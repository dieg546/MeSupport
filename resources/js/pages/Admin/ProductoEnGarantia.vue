<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ModalEstadoEquipo from '@/Components/ModalEstadoEquipo.vue';

const props = defineProps({
    solicitudes: Array,
    estados: Array,
    filters: Object
});

const buscar = ref(props.filters?.buscar || '');
// Inicializar en cadena vacía si no hay estado o es 'todos'
const estadoFiltro = ref(
    props.filters?.estado && props.filters.estado !== 'todos' ? props.filters.estado : ''
);

// Control del Modal
const mostrarModal = ref(false);
const solicitudSeleccionada = ref(null);

const abrirModalEstado = (item) => {
    solicitudSeleccionada.value = item;
    mostrarModal.value = true;
};

// Función unificada para consultar con Inertia
const aplicarFiltros = () => {
    router.get(
        route('admin.garantias.en-revision'),
        { 
            buscar: buscar.value || undefined, 
            estado: estadoFiltro.value || undefined 
        },
        { 
            preserveState: true, 
            replace: true 
        }
    );
};

// Escuchar cambios en los inputs
watch(buscar, () => aplicarFiltros());
watch(estadoFiltro, () => aplicarFiltros());

const getBadgeClass = (estado) => {
    switch (estado) {
        case 'Abierta': return 'bg-[#dbeafe] text-[#2563eb]';
        case 'En Revision':
        case 'En Revisión': return 'bg-[#ffedd5] text-[#c2410c]';
        case 'Finalizada': return 'bg-[#d1fae5] text-[#065f46]';
        case 'Rechazada': return 'bg-[#fee2e2] text-[#991b1b]';
        case 'En Taller': return 'bg-[#f3e8ff] text-[#6b21a8]';
        case 'Esperando Repuesto': return 'bg-[#fef9c3] text-[#854d0e]';
        case 'Reemplazo Autorizado': return 'bg-[#e0e7ff] text-[#3730a3]';
        case 'Listo para Entrega': return 'bg-[#ccfbf1] text-[#0f766e]';
        default: return 'bg-gray-100 text-gray-700';
    }
};

const getDotClass = (estado) => {
    switch (estado) {
        case 'Abierta': return 'bg-[#2563eb]';
        case 'En Revision':
        case 'En Revisión': return 'bg-[#ea580c]';
        case 'Finalizada': return 'bg-[#059669]';
        case 'Rechazada': return 'bg-[#dc2626]';
        case 'En Taller': return 'bg-[#9333ea]';
        case 'Esperando Repuesto': return 'bg-[#ca8a04]';
        case 'Reemplazo Autorizado': return 'bg-[#4f46e5]';
        case 'Listo para Entrega': return 'bg-[#0d9488]';
        default: return 'bg-gray-500';
    }
};
</script>

<template>
    <AdminLayout title="Productos en garantía">
        <div class="max-w-4xl mx-auto py-8 px-4 font-['Poppins',sans-serif]">
            
            <div class="mb-8">
                <h1 class="text-3xl font-black text-black flex items-center gap-2 mb-1">
                    Productos en garantía 📦
                </h1>
                <p class="text-gray-500 text-sm font-medium">
                    Visualización de garantías de los clientes.
                </p>
            </div>

            <!-- Input de Búsqueda -->
            <div class="relative max-w-md mb-10">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    v-model="buscar"
                    type="text" 
                    placeholder="Buscar cliente o ID de solicitud" 
                    class="w-full pl-11 pr-4 py-3 bg-white border border-gray-300 rounded-full text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 shadow-xs"
                />
            </div>

            <!-- Subtítulo y Filtro desplegable -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-black text-black flex items-center gap-2">
                    Productos 📦
                </h2>

                <div class="relative">
                    <select 
                        v-model="estadoFiltro"
                        class="appearance-none bg-white border border-gray-300 rounded-full px-5 py-2 pr-10 text-sm font-bold text-gray-700 focus:outline-none cursor-pointer shadow-xs"
                    >
                        <!-- Usar value="" para resetear el filtro -->
                        <option value="">Por Estado (Todos)</option>
                        <option 
                            v-for="est in estados" 
                            :key="est.id_estado || est.id" 
                            :value="est.id_estado || est.id"
                        >
                            {{ est.nombre_estado || est.nombre }}
                        </option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Lista de Solicitudes -->
            <div class="space-y-4">
                <div 
                    v-for="item in solicitudes" 
                    :key="item.id"
                    class="bg-white rounded-3xl p-5 border border-gray-200/80 shadow-xs flex items-center justify-between hover:shadow-md transition-shadow"
                >
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-600 inline-block"></span>
                            <span class="text-xs font-black text-black tracking-tight">
                                {{ item.ticket }}
                            </span>
                            <span class="text-xs font-bold text-gray-700">
                                • {{ item.cliente }}
                            </span>
                            <span v-if="item.fecha" class="text-xs font-medium text-gray-400">
                                ({{ item.fecha }})
                            </span>
                        </div>

                        <p class="text-sm font-bold text-black pl-4">
                            {{ item.falla }}
                        </p>

                        <p class="text-xs font-semibold text-gray-400 pl-4">
                            {{ item.dispositivo }}
                        </p>
                    </div>

                    <div class="flex items-center gap-8">
                        <div :class="getBadgeClass(item.estado)" class="flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold">
                            <span :class="getDotClass(item.estado)" class="w-2 h-2 rounded-full"></span>
                            <span>{{ item.estado }}</span>
                        </div>

                        <button 
                            @click="item.estado !== 'Finalizada' && abrirModalEstado(item)"
                            :disabled="item.estado === 'Finalizada'"
                            type="button"
                            :class="[
                                'text-sm font-extrabold flex items-center gap-1 transition',
                                item.estado === 'Finalizada' 
                                    ? 'text-gray-300 cursor-not-allowed opacity-60' 
                                    : 'text-black hover:text-gray-600 cursor-pointer'
                            ]"
                        >
                            <span>{{ item.estado === 'Finalizada' ? 'Finalizada' : 'Actualizar' }}</span>
                            <span v-if="item.estado !== 'Finalizada'">&gt;</span>
                        </button>
                    </div>
                </div>

                <div v-if="solicitudes.length === 0" class="text-center py-12 text-gray-400 text-sm font-medium">
                    No se encontraron solicitudes asociadas a los criterios de búsqueda.
                </div>
            </div>

        </div>

        <ModalEstadoEquipo 
            v-if="solicitudSeleccionada"
            :show="mostrarModal"
            :solicitud="solicitudSeleccionada"
            :estados="estados"
            @close="mostrarModal = false"
        />
    </AdminLayout>
</template>