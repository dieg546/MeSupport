<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    cliente: String,
    solicitudes: Array,
    estados: Array,
    filtro: String,
});

const estadoSeleccionado = ref(props.filtro || '');

const aplicarFiltro = () => {
    router.get(
        route('estado-garantias.index'),
        { estado: estadoSeleccionado.value },
        { preserveState: true, replace: true }
    );
};

// Normalizar el estado recibido para mapear clases dinámicamente
const getBadgeClasses = (estado) => {
    const nombre = (estado || '').toString().toLowerCase();
    
    if (nombre.includes('revision') || nombre.includes('revisión')) {
        return 'bg-[#ffedd5] text-[#c2410c]';
    } else if (nombre.includes('rechazad')) {
        return 'bg-[#ffe4e6] text-[#e11d48]';
    } else if (nombre.includes('finalizad')) {
        return 'bg-[#d1fae5] text-[#047857]';
    } else {
        return 'bg-[#dbeafe] text-[#1d4ed8]';
    }
};

const getDotClasses = (estado) => {
    const nombre = (estado || '').toString().toLowerCase();

    if (nombre.includes('revision') || nombre.includes('revisión')) {
        return 'bg-[#ea580c]';
    } else if (nombre.includes('rechazad')) {
        return 'bg-[#e11d48]';
    } else if (nombre.includes('finalizad')) {
        return 'bg-[#10b981]';
    } else {
        return 'bg-[#2563eb]';
    }
};
</script>

<template>
    <AuthenticatedLayout title="Estado Garantías">
        <div class="max-w-4xl">
            <!-- Título y Subtítulo -->
            <div class="mb-6">
                <h1 class="text-3xl font-black text-black mb-1 flex items-center gap-2">
                    Estado Garantía 📬
                </h1>
                <p class="text-sm font-bold text-gray-400">
                    Visualización de garantías del cliente {{ cliente }}
                </p>
            </div>

            <!-- Dropdown Filtro -->
            <div class="flex justify-end mb-8">
                <div class="relative">
                    <div class="relative inline-block">
                        <select 
                            v-model="estadoSeleccionado"
                            @change="aplicarFiltro"
                            class="bg-white border border-gray-300 text-gray-900 text-sm font-bold rounded-full pl-6 pr-10 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer"
                        >
                            <option value="">Por Estado</option>
                            <option v-for="est in estados" :key="est.id_estado || est.id" :value="est.id_estado || est.id">
                                {{ est.nombre_estado || est.nombre }}
                            </option>
                        </select>

                    </div>
                </div>
            </div>

            <!-- Lista de Tarjetas de Garantía -->
            <div class="space-y-6">
                <div 
                    v-for="item in solicitudes" 
                    :key="item.id || item.id_solicitud"
                    class="bg-white border border-gray-200 rounded-2xl p-6 shadow-[0_4px_20px_rgba(0,0,0,0.05)] flex items-center justify-between"
                >
                    <!-- Info Ticket / Dispositivo -->
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#2563eb] inline-block"></span>
                            <span class="text-xs font-black text-black">
                                {{ item.ticket || item.codigo_ticket || ('Ticket-2024-' + (item.id || item.id_solicitud)) }}
                            </span>
                        </div>
                        <h3 class="text-sm font-black text-black">
                            {{ item.falla || item.descripcion_falla || 'Fallo reportado' }}
                        </h3>
                        <p class="text-xs font-bold text-gray-400">
                            {{ item.equipo || item.nombre_equipo || 'Samsung Galaxy' }} {{ item.capacidad || '' }}
                        </p>
                    </div>

                    <!-- Badge / Cápsula de Estado -->
                    <div class="flex justify-center min-w-[140px]">
                        <span 
                            :class="getBadgeClasses(item.estado_nombre || item.estado)"
                            class="px-6 py-1.5 rounded-full text-xs font-black flex items-center gap-2 w-full justify-center"
                        >
                            <span :class="getDotClasses(item.estado_nombre || item.estado)" class="w-2 h-2 rounded-full"></span>
                            {{ item.estado_nombre || item.estado || 'Abierta' }}
                        </span>
                    </div>

                    <!-- Botón Ver Detalle -->
                    <div>
                        <Link 
                            :href="route('estado-garantias.show', item.id_solicitud || item.id)" 
                            class="text-xs font-black text-black hover:text-blue-600 flex items-center gap-1 transition"
                        >
                            Ver Detalle &rsaquo;
                        </Link>
                    </div>
                </div>

                <!-- Estado Vacío -->
                <div 
                    v-if="!solicitudes || solicitudes.length === 0" 
                    class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-300"
                >
                    <p class="text-gray-500 text-sm font-bold">No hay registros de garantías registrados.</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>