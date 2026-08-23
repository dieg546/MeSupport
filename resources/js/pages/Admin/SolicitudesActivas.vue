<script setup>
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    solicitudes: Array,
    estados: Array,
    filters: Object
});

// Reactivo para el filtro por estado
const estadoFiltro = ref(props.filters?.estado || 'todos');

// Enviar la petición a Inertia cada vez que el usuario cambie el estado seleccionado
watch(estadoFiltro, (nuevoEstado) => {
    router.get(
        route('admin.solicitudes.index'),
        { estado: nuevoEstado },
        { preserveState: true, replace: true }
    );
});

// Lógica de colores según el nombre exacto de la base de datos
const getBadgeClass = (estado) => {
    switch (estado) {
        case 'Abierta':
            return 'bg-[#dbeafe] text-[#2563eb]';
        case 'En Revision':
        case 'En Revisión':
            return 'bg-[#ffedd5] text-[#c2410c]';
        case 'Finalizada':
            return 'bg-[#d1fae5] text-[#065f46]';
        case 'Rechazada':
            return 'bg-[#fee2e2] text-[#991b1b]';
        case 'En Taller':
            return 'bg-[#f3e8ff] text-[#6b21a8]';
        case 'Esperando Repuesto':
            return 'bg-[#fef9c3] text-[#854d0e]';
        case 'Reemplazo Autorizado':
            return 'bg-[#e0e7ff] text-[#3730a3]';
        case 'Listo para Entrega':
            return 'bg-[#ccfbf1] text-[#0f766e]';
        default:
            return 'bg-gray-100 text-gray-700';
    }
};

const getDotClass = (estado) => {
    switch (estado) {
        case 'Abierta':
            return 'bg-[#2563eb]';
        case 'En Revision':
        case 'En Revisión':
            return 'bg-[#ea580c]';
        case 'Finalizada':
            return 'bg-[#059669]';
        case 'Rechazada':
            return 'bg-[#dc2626]';
        case 'En Taller':
            return 'bg-[#9333ea]';
        case 'Esperando Repuesto':
            return 'bg-[#ca8a04]';
        case 'Reemplazo Autorizado':
            return 'bg-[#4f46e5]';
        case 'Listo para Entrega':
            return 'bg-[#0d9488]';
        default:
            return 'bg-gray-500';
    }
};
</script>

<template>
    <AdminLayout title="Solicitudes Activas">
        <div class="max-w-4xl mx-auto py-8 px-4 font-['Poppins',sans-serif]">
            
            <!-- Encabezado y Desplegable de Filtro -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    Solicitudes activas 📲
                </h2>
                
                <div class="relative">
                    <select 
                        v-model="estadoFiltro" 
                        class="appearance-none bg-gray-100 border border-gray-300 text-gray-700 font-medium py-2 px-6 pr-10 rounded-full leading-tight focus:outline-none focus:bg-white focus:border-gray-500 text-sm cursor-pointer"
                    >
                        <option value="todos">Por Estado (Todos)</option>
                        <option 
                            v-for="est in estados" 
                            :key="est.id_estado" 
                            :value="est.id_estado"
                        >
                            {{ est.nombre_estado }}
                        </option>
                    </select>
                    
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l0.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Lista de Solicitudes -->
            <div class="space-y-4">
                <div 
                    v-for="item in solicitudes" 
                    :key="item.id"
                    class="bg-white rounded-2xl p-6 border border-gray-200/80 shadow-xs flex items-center justify-between hover:shadow-md transition-shadow"
                >
                    <!-- Detalle del Dispositivo -->
                    <div class="space-y-1 text-sm text-gray-800">
                        <p class="font-semibold">
                            <span class="font-extrabold text-black">Dispositivo:</span> {{ item.dispositivo }}
                        </p>
                        <p class="font-semibold">
                            <span class="font-extrabold text-black">Capacidad:</span> {{ item.capacidad }}
                        </p>
                        <p class="font-semibold">
                            <span class="font-extrabold text-black">Fecha de solicitud:</span> {{ item.fecha }}
                        </p>
                    </div>

                    <!-- Badge de Estado y Enlace Ver Detalle -->
                    <div class="flex items-center gap-6">
                        <!-- Badge Dinámico de Estado -->
                        <div :class="getBadgeClass(item.estado)" class="flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold">
                            <span :class="getDotClass(item.estado)" class="w-2 h-2 rounded-full"></span>
                            <span>{{ item.estado }}</span>
                        </div>

                        <!-- Enlace Ver Detalle -->
                        <Link 
                            v-if="item?.id"
                            :href="route('admin.solicitudes.show', item.id)"
                            class="text-xs font-extrabold text-black hover:text-blue-600 transition flex items-center gap-1"
                        >
                            Ver Detalle <span class="text-sm">&rsaquo;</span>
                        </Link>
                    </div>
                </div>

                <!-- Mensaje cuando no hay registros -->
                <div v-if="solicitudes.length === 0" class="text-center py-12 text-gray-400 text-sm font-medium bg-white rounded-2xl border border-gray-100">
                    No se encontraron solicitudes asociadas a este filtro.
                </div>
            </div>

        </div>
    </AdminLayout>
</template>