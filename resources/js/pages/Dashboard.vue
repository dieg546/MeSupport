<script setup>
import { ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import RegisterDeviceModal from '@/Components/RegisterDeviceModal.vue';

defineProps({
    devices: {
        type: Array,
        default: () => [
            { id: 1, name: 'Samsung S26', capacity: '8/256', endDate: '12/12/2026', status: 'Activa' },
            { id: 2, name: 'POCO X8 PRO', capacity: '8/256', endDate: '12/08/2026', status: 'Vencida' },
            { id: 3, name: 'Xiaomi NOTE 15', capacity: '6/128', endDate: '12/12/2026', status: 'Por Vencer' }
        ]
    }
});

const user = usePage().props.auth.user;

// Estado reactivo para controlar el modal
const isModalOpen = ref(false);
</script>

<template>
    <Head title="Dashboard" />

    <div class="min-h-screen bg-[#f8f9fa] flex flex-col font-['Poppins',sans-serif]">
        <!-- Navbar Superior -->
        <header class="bg-[#f2f2f2] border-b border-gray-300 px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="/images/Logo MeSupport.png" 
                    alt="MeSupport Logo" 
                    class="h-[80px] w-auto object-cover scale-125 origin-left"
                />
            </div>
            <Link 
                :href="route('logout')" 
                method="post" 
                as="button" 
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
                    <a href="#" class="flex items-center gap-2 text-gray-900 font-bold text-sm hover:text-blue-600 transition">
                        <span>Menú Principal</span> 🏫
                    </a>
                    <a href="#" class="flex items-center gap-2 text-gray-700 font-medium text-sm hover:text-blue-600 transition">
                        <span>Solicitudes</span> 📱
                    </a>
                    <a href="#" class="flex items-center gap-2 text-gray-700 font-medium text-sm hover:text-blue-600 transition">
                        <span>Estado Garantías</span> 📱
                    </a>
                </nav>
            </aside>

            <!-- Contenido Principal -->
            <main class="flex-1 p-10 relative">
                <!-- Saludo -->
                <h1 class="text-3xl font-extrabold text-gray-900 mb-8">
                    ¡Bienvenido <span class="text-[#2563eb]">{{ user?.name || 'Usuario' }}</span>!
                </h1>

                <!-- Subtítulo y Filtro -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Tus Dispositivos Registrados</h2>
                    <div class="relative">
                        <select class="appearance-none bg-gray-100 border border-gray-300 text-gray-700 font-medium py-2 px-6 pr-10 rounded-full leading-tight focus:outline-none focus:bg-white focus:border-gray-500 text-sm">
                            <option>Filtrar</option>
                            <option>Garantía Activa</option>
                            <option>Vencida</option>
                            <option>Por Vencer</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path d="M9.293 12.95l0.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Lista de Tarjetas -->
                <div class="space-y-4 max-w-4xl">
                    <div 
                        v-for="device in devices" 
                        :key="device.id" 
                        class="bg-white rounded-xl p-5 border border-gray-100 shadow-md flex items-center justify-between"
                    >
                        <div class="space-y-1 text-sm text-gray-800">
                            <p><span class="font-bold">Dispositivo:</span> {{ device.name }}</p>
                            <p><span class="font-bold">Capacidad:</span> {{ device.capacity }}</p>
                            <p><span class="font-bold">Fecha fin garantía:</span> {{ device.endDate }}</p>
                        </div>

                        <div class="flex items-center gap-6">
                            <!-- Badges de Estado -->
                            <span 
                                v-if="device.status === 'Activa'" 
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#d1fae5] text-[#065f46]"
                            >
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                Garantia Activa
                            </span>

                            <span 
                                v-else-if="device.status === 'Vencida'" 
                                class="inline-flex items-center gap-1.5 px-4 py-1 rounded-full text-xs font-semibold bg-[#fecdd3] text-[#9f1239]"
                            >
                                🚫 Vencida
                            </span>

                            <span 
                                v-else-if="device.status === 'Por Vencer'" 
                                class="inline-flex items-center gap-1.5 px-4 py-1 rounded-full text-xs font-semibold bg-[#fef3c7] text-[#92400e]"
                            >
                                ⚠️ Por Vencer
                            </span>

                            <!-- Botón Visualizar -->
                            <button class="bg-[#243c7a] hover:bg-[#1a2d5d] text-white text-sm font-semibold px-8 py-2.5 rounded-xl transition duration-150 shadow-sm">
                                Visualizar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Botón Flotante "+" (Abre el modal) -->
                <button 
                    @click="isModalOpen = true"
                    class="fixed bottom-8 right-8 bg-[#3177bb] hover:bg-[#256098] text-white w-14 h-14 rounded-full shadow-lg flex items-center justify-center text-2xl font-light transition duration-200"
                >
                    +
                </button>
            </main>
        </div>

        <!-- Instancia del Modal Componentizado -->
        <RegisterDeviceModal 
            :show="isModalOpen" 
            @close="isModalOpen = false" 
        />
    </div>
</template>