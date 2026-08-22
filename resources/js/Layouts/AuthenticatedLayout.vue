<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
        default: 'MeSupport'
    }
});

const navLinkClasses = (routeName) => {
    return route().current(routeName)
        ? 'flex items-center gap-2 text-blue-600 font-bold text-sm transition'
        : 'flex items-center gap-2 text-gray-700 font-medium text-sm hover:text-blue-600 transition';
};

</script>

<template>
    <Head :title="title" />

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
                        :class="navLinkClasses('dashboard')"
                    >
                        <span>Menú Principal</span> 🏫
                    </Link>

                    <Link 
                        :href="route('garantias.index')" 
                        :class="navLinkClasses('garantias.index')"
                    >
                        <span>Solicitudes</span> 📲
                    </Link>

                    <Link 
                        :href="route('estado-garantias.index')" 
                        :class="navLinkClasses('estado-garantias.index')"
                    >
                        <span>Estado Garantías</span> 📱
                    </Link>
                </nav>
            </aside>

            <!-- Contenido Dinámico inyectado desde la Vista -->
            <main class="flex-1 p-10 relative">
                <slot />
            </main>
        </div>
    </div>
</template>