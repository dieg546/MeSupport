<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    device: {
        type: Object,
        required: true
    }
});

const fileInput = ref(null);

const form = useForm({
    equipo_id: props.device.id,
    descripcion_falla: '',
    archivos: null,
});

const handleFileSelect = (event) => {
    form.archivos = event.target.files[0];
};

const submit = () => {
    form.post(route('garantias.store'), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Solicitud Garantía" />

    <div class="min-h-screen bg-[#f8f9fa] flex flex-col font-['Poppins',sans-serif]">
        <!-- Navbar Superior -->
        <header class="bg-[#f2f2f2] border-b border-gray-300 px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img 
                    src="/images/Logo MeSupport.png" 
                    alt="MeSupport Logo" 
                    class="h-[80px] w-auto object-cover scale-125 origin-left"
                />
            </div>
            <Link 
                :href="route('logout')" 
                method="post" 
                as="button" 
                type="button"
                class="flex items-center gap-2 text-gray-800 font-medium hover:text-red-600 transition"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Cerrar Sesión</span>
            </Link>
        </header>

        <div class="flex flex-1">
            <!-- Sidebar Izquierda -->
            <aside class="w-64 bg-[#f2f2f2] border-r border-gray-300 p-6 flex flex-col space-y-6">
                <nav class="space-y-4">
                    <Link 
                        :href="route('dashboard')" 
                        class="flex items-center gap-2 text-gray-700 font-medium text-sm hover:text-blue-600 transition"
                    >
                        <span>Menú Principal</span> 🏫
                    </Link>
                    <Link 
                        :href="route('garantias.index')" 
                        class="flex items-center gap-2 text-gray-900 font-bold text-sm hover:text-blue-600 transition"
                    >
                        <span>Solicitudes</span> 📬
                    </Link>
                    <Link 
                        :href="route('garantias.index')" 
                        class="flex items-center gap-2 text-gray-700 font-medium text-sm hover:text-blue-600 transition"
                    >
                        <span>Estado Garantías</span> 📲
                    </Link>
                </nav>
            </aside>

            <!-- Contenido Principal -->
            <main class="flex-1 p-10 relative">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-6 flex items-center gap-2">
                    Solicitud Garantía 📬
                </h1>

                <form @submit.prevent="submit" class="max-w-2xl space-y-8">
                    <!-- Datos del Equipo -->
                    <div>
                        <h2 class="text-2xl font-semibold text-[#2563eb] mb-4">Datos del Equipo</h2>
                        <div class="bg-[#f8f9fa] border border-gray-200 rounded-2xl p-6 space-y-2 text-sm text-gray-900 shadow-sm">
                            <p><span class="font-bold">Dispositivo:</span> {{ device.name }}</p>
                            <p><span class="font-bold">Capacidad:</span> {{ device.capacity }}</p>
                            <p><span class="font-bold">Serial:</span> {{ device.serial }}</p>
                            <p><span class="font-bold">Imei:</span> {{ device.imei }}</p>
                            <p><span class="font-bold">Fecha Compra:</span> {{ device.fechaCompra }}</p>
                        </div>
                    </div>

                    <!-- Descripción Falla -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-800">Descripción Falla</label>
                        <textarea 
                            v-model="form.descripcion_falla"
                            rows="3"
                            placeholder="Describa la falla presentada por el equipo..."
                            class="w-full bg-[#f2f2f2] border border-gray-300 rounded-2xl p-4 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                            required
                        ></textarea>
                        <div v-if="form.errors.descripcion_falla" class="text-red-500 text-xs">
                            {{ form.errors.descripcion_falla }}
                        </div>
                    </div>

                    <!-- Adjuntar Pruebas -->
                    <div>
                        <h2 class="text-2xl font-semibold text-[#2563eb] mb-4">Adjuntar pruebas</h2>
                        <input 
                            type="file" 
                            ref="fileInput" 
                            @change="handleFileSelect" 
                            class="hidden" 
                            accept=".pdf,image/*" 
                        />
                        <div 
                            @click="fileInput?.click()"
                            class="border-2 border-dashed border-gray-400 rounded-2xl p-6 flex items-center justify-center gap-4 cursor-pointer hover:border-blue-500 transition bg-white"
                        >
                            <!-- Icono PDF -->
                            <div class="bg-red-500 text-white p-2 rounded-lg font-bold text-xs">
                                PDF
                            </div>
                            <span class="font-bold text-gray-800 text-base">
                                {{ form.archivos ? form.archivos.name : 'Factura y imágenes del equipo' }}
                            </span>
                        </div>
                        <div v-if="form.errors.archivos" class="text-red-500 text-xs mt-1">
                            {{ form.errors.archivos }}
                        </div>
                    </div>

                    <!-- Botón Enviar -->
                    <div class="flex justify-center pt-2">
                        <button 
                            type="submit" 
                            :disabled="form.processing"
                            class="bg-[#243c7a] hover:bg-[#1a2d5d] text-white text-base font-semibold px-10 py-3 rounded-2xl transition duration-150 shadow-md disabled:opacity-50"
                        >
                            Solicitar Garantía
                        </button>
                    </div>
                </form>
            </main>
        </div>
    </div>
</template>