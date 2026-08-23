<!-- resources/js/Layouts/AdminLayout.vue -->
<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
        default: 'Panel Admin'
    }
}); 

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div class="min-h-screen bg-[#f8f9fa] flex flex-col font-['Poppins',sans-serif] text-gray-900">
        <!-- Header Superior -->
        <header class="w-full bg-white border-b border-gray-200 px-8 py-3 flex items-center justify-between sticky top-0 z-50">
            <!-- Logo MeSupport -->
            <div class="flex items-center gap-2">
                <img 
                    src="/images/Logo MeSupport.png" 
                    alt="MeSupport Logo" 
                    class="h-[80px] w-auto object-cover scale-125 origin-left"
                />
            </div>

            <!-- Botón Cerrar Sesión -->
            <button 
                @click="logout"
                class="flex items-center gap-2 text-sm font-bold text-gray-700 hover:text-red-600 transition"
            >
                <svg class="w-5 h-5 stroke-current fill-none" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Cerrar Sesión</span>
            </button>
        </header>

        <!-- Cuerpo con Aside y Contenido Principal -->
        <div class="flex flex-1">
            <!-- Navigation Sidebar (Aside) -->
            <aside class="w-64 bg-[#f1f3f5] border-r border-gray-200 p-6 flex flex-col gap-6 min-h-[calc(100vh-65px)]">
                <nav class="space-y-4">
                    <Link 
                        :href="route('admin.dashboard')" 
                        class="flex items-center gap-3 text-sm  text-gray-800 hover:text-blue-700 transition"
                    >
                        <span>Menú Principal 🏫</span>
                    </Link>

                    <Link 
                        :href="route('admin.dashboard')" 
                        class="flex items-center gap-3 text-sm text-gray-800 hover:text-blue-700 transition"
                    >
                        <span>Solicitudes 📦</span>
                    </Link>

                    <Link 
                        :href="route('admin.dashboard')" 
                        class="flex items-center gap-3 text-sm text-gray-800 hover:text-blue-700 transition"
                    >
                        <span>Gestionar Garantía 📲</span>
                    </Link>

                    <Link 
                        :href="route('admin.dashboard')" 
                        class="flex items-center gap-3 text-sm text-gray-800 hover:text-blue-700 transition"
                    >
                        <span>Estadísticas 📈</span>
                    </Link>
                </nav>
            </aside>

            <!-- Área de Contenido Principal -->
            <main class="flex-1 p-8">
                <slot />
            </main>
        </div>
    </div>
</template>