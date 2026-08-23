<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    solicitud: {
        type: Object,
        default: () => ({
            id_solicitud: 5062,
            ticket: 'Ticket-2024-75',
            equipo: 'Samsung A17 8/256',
            falla: 'Fallo en pin de carga',
            fecha_revision: '13/12/2026',
            observacion: 'El dispositivo si presenta la falla, viene generada a un defecto de fabrica, dicho defecto es la falta de soldadura en un componente clave del pin de carga.',
            estado: 'En Revision'
        })
    }
});

// Estilos dinámicos para la cápsula de estado
const badgeClasses = computed(() => {
    const estado = (props.solicitud?.estado || '').toLowerCase();

    if (estado.includes('revision') || estado.includes('revisión')) {
        return 'bg-[#ffedd5] text-[#c2410c]';
    } else if (estado.includes('rechazad')) {
        return 'bg-[#ffe4e6] text-[#e11d48]';
    } else if (estado.includes('finalizad') || estado.includes('aprobad')) {
        return 'bg-[#d1fae5] text-[#047857]';
    } else {
        return 'bg-[#dbeafe] text-[#1d4ed8]';
    }
});

const dotClasses = computed(() => {
    const estado = (props.solicitud?.estado || '').toLowerCase();

    if (estado.includes('revision') || estado.includes('revisión')) {
        return 'bg-[#ea580c]';
    } else if (estado.includes('rechazad')) {
        return 'bg-[#e11d48]';
    } else if (estado.includes('finalizad') || estado.includes('aprobad')) {
        return 'bg-[#10b981]';
    } else {
        return 'bg-[#2563eb]';
    }
});
</script>

<template>
    <AuthenticatedLayout title="Estado del Dispositivo">
        <div class="max-w-2xl mx-auto pt-6 pb-12">
            <!-- Título Principal -->
            <h1 class="text-3xl font-black text-black text-center mb-10">
                Estado del Dispositivo
            </h1>

            <!-- Tarjeta de Contenido / Detalle -->
            <div class="space-y-6 px-4 sm:px-8">
                <!-- Fila Header: Punto azul + Ticket y Badge Estado -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-3.5 h-3.5 rounded-full bg-[#2563eb] inline-block"></span>
                        <span class="text-lg font-black text-black">
                            {{ solicitud.ticket || solicitud.codigo_ticket || ('Ticket-2024-' + solicitud.id_solicitud) }}
                        </span>
                    </div>

                    <span 
                        :class="badgeClasses"
                        class="px-6 py-1.5 rounded-full text-sm font-bold flex items-center gap-2.5 min-w-[140px] justify-center"
                    >
                        <span :class="dotClasses" class="w-2.5 h-2.5 rounded-full"></span>
                        {{ solicitud.estado || 'En Revision' }}
                    </span>
                </div>

                <!-- Lista de Detalles de la Solicitud -->
                <div class="space-y-4 pt-2 text-base text-gray-800">
                    <p class="leading-relaxed">
                        <span class="font-black text-black">ID Solicitud:</span> 
                        <span class="font-bold text-gray-600 ml-1">{{ solicitud.id_solicitud || solicitud.id }}</span>
                    </p>

                    <p class="leading-relaxed">
                        <span class="font-black text-black">Equipo:</span> 
                        <span class="font-bold text-gray-600 ml-1">{{ solicitud.equipo || solicitud.nombre_equipo }}</span>
                    </p>

                    <p class="leading-relaxed">
                        <span class="font-black text-black">Falla presentada:</span> 
                        <span class="font-bold text-gray-600 ml-1">{{ solicitud.falla || solicitud.descripcion_falla }}</span>
                    </p>

                    <p class="leading-relaxed">
                        <span class="font-black text-black">Fecha de revisión:</span> 
                        <span class="font-bold text-gray-600 ml-1">{{ solicitud.fecha_revision || 'Pendiente' }}</span>
                    </p>

                    <p class="leading-relaxed">
                        <span class="font-black text-black">Observacion:</span> 
                        <span class="font-bold text-gray-600 ml-1">
                            {{ solicitud.observacion || solicitud.observaciones || 'Sin observaciones registradas.' }}
                        </span>
                    </p>
                </div>

                <!-- Botón Aceptar / Volver -->
                <div class="pt-10 flex justify-center">
                    <Link
                        :href="route('estado-garantias.index')"
                        class="bg-[#243c7a] hover:bg-[#1a2d5d] text-white font-bold text-base px-12 py-3 rounded-2xl transition shadow-md inline-block text-center min-w-[180px]"
                    >
                        Aceptar
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>