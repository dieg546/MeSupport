<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ModalRegistroProducto from '@/Components/ModalRegistroProducto.vue';




const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            totalProductos: 20,
            crecimiento: '20%',
            garantiasActivas: 15,
            garantiasEnRevision: 5
        })
    },
    ultimasSolicitudes: {
        type: Array,
        default: () => [
            { id: 1, ticket: 'Ticket-2024-75', falla: 'Fallo en pin de carga', modelo: 'Samsung A17 8/256', estado: 'Abierta' },
            { id: 2, ticket: 'Ticket-2024-75', falla: 'Falla Conexión Wifi', modelo: 'POCO X8 PRO 8/256', estado: 'Abierta' },
            { id: 3, ticket: 'Ticket-2024-75', falla: 'Falla Conexión Wifi', modelo: 'POCO X8 PRO 8/256', estado: 'Abierta' },
        ]
    }
});

const getBadgeClass = (estado) => {
    switch (estado?.toLowerCase()) {
        case 'abierta':
            return 'bg-[#dbeafe] text-[#2563eb]';
        case 'en revision':
        case 'en revisión':
            return 'bg-[#ffedd5] text-[#c2410c]';
        default:
            return 'bg-gray-100 text-gray-700';
    }
};

const getDotClass = (estado) => {
    switch (estado?.toLowerCase()) {
        case 'abierta':
            return 'bg-[#2563eb]';
        case 'en revision':
        case 'en revisión':
            return 'bg-[#ea580c]';
        default:
            return 'bg-gray-500';
    }
};

const showModal = ref(false);
</script>

<template>
    <AdminLayout title="Panel Garantías">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <!-- Encabezado y Botón -->
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-extrabold text-black tracking-tight">
                    Panel Garantías📲
                </h1>

                <button
                    @click="showModal = true"
                    class="bg-[#1b2a4a] hover:bg-[#121c33] text-white font-bold text-sm px-6 py-2.5 rounded-full transition shadow-sm flex items-center gap-2"
                >
                    <span class="text-base leading-none">+</span> Registrar producto
                </button> 
            </div>

            <!-- Tarjetas de Estadísticas (Organizadas horizontalmente) -->
            <div class="flex flex-row gap-6 mb-10 w-full">
                <!-- Total Productos -->
                <div class="flex-1 bg-white rounded-[24px] p-6 border border-gray-300 shadow-sm flex flex-col justify-between h-44">
                    <h3 class="text-lg font-extrabold text-black">Total Productos</h3>
                    <div class="flex flex-col justify-end">
                        <span class="text-4xl font-extrabold text-emerald-600 block leading-none mb-2">
                            {{ stats.totalProductos }}
                        </span>
                        <p class="text-xs font-bold text-gray-400 h-8 flex items-start">
                            Un crecimiento del {{ stats.crecimiento }} desde la última semana
                        </p>
                    </div>
                </div>

                <!-- Garantías activas -->
                <div class="flex-1 bg-white rounded-[24px] p-6 border border-gray-300 shadow-sm flex flex-col justify-between h-44">
                    <h3 class="text-lg font-extrabold text-black">Garantías activas</h3>
                    <div class="flex flex-col justify-end">
                        <span class="text-4xl font-extrabold text-[#1e3a8a] block leading-none mb-2">
                            {{ stats.garantiasActivas }}
                        </span>
                        <p class="text-xs font-bold text-gray-400 h-8 flex items-start">
                            Requieren aprobarse
                        </p>
                    </div>
                </div>

                <!-- Garantías en revisión -->
                <div class="flex-1 bg-white rounded-[24px] p-6 border border-gray-300 shadow-sm flex flex-col justify-between h-44">
                    <h3 class="text-lg font-extrabold text-black">Garantías en revisión</h3>
                    <div class="flex flex-col justify-end">
                        <span class="text-4xl font-extrabold text-[#c2410c] block leading-none mb-2">
                            {{ stats.garantiasEnRevision }}
                        </span>
                        <p class="text-xs font-bold text-gray-400 h-8 flex items-start">
                            Actualmente bajo revisión técnica
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sección Últimas Solicitudes -->
            <div class="mb-6">
                <h2 class="text-2xl font-extrabold text-black tracking-tight mb-6">
                    Últimas solicitudes📲
                </h2>

                <div class="space-y-4">
                    <div 
                        v-for="item in ultimasSolicitudes" 
                        :key="item.id"
                        class="bg-white rounded-[20px] px-8 py-4 border border-gray-200 shadow-[0_4px_20px_rgba(0,0,0,0.05)] flex items-center justify-between"
                    >
                        <!-- Info Solicitud -->
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-1.5 rounded-full bg-[#2563eb]"></span>
                                <span class="text-xs font-bold text-black">
                                    {{ item.ticket }}
                                </span>
                            </div>
                            <p class="text-sm font-extrabold text-black leading-tight">
                                {{ item.falla }}
                            </p>
                            <p class="text-xs font-bold text-gray-400">
                                {{ item.modelo }}
                            </p>

                            <p class="text-xs font-bold text-gray-400">
                                {{ item.capacidad}}
                            </p>
                        </div>

                        <!-- Estado y Detalle -->
                        <div class="flex items-center gap-12">
                            <span 
                                :class="getBadgeClass(item.estado)"
                                class="px-6 py-1.5 rounded-full text-xs font-bold flex items-center gap-2"
                            >
                                <span :class="getDotClass(item.estado)" class="w-2 h-2 rounded-full"></span>
                                {{ item.estado }}
                            </span>

                            <Link 
                                v-if="item?.id"
                                :href="route('admin.solicitudes.show', item.id)"
                                class="text-xs font-extrabold text-black hover:text-blue-600 transition flex items-center gap-1"
                            >
                                Ver Detalle <span class="text-sm">&rsaquo;</span>
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Enlace Ver Más -->
                <div class="text-right mt-6 pr-2">
                    <Link 
                        :href="route('admin.dashboard')" 
                        class="text-xs font-extrabold text-black hover:text-blue-600 transition inline-flex items-center gap-1"
                    >
                        Ver Mas <span class="text-sm">&rsaquo;</span>
                    </Link>
                </div>
            </div>
        </div>

        <ModalRegistroProducto 
            :show="showModal" 
            @close="showModal = false" 
        />

    </AdminLayout>
</template>