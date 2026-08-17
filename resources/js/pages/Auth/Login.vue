
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({ 
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Iniciar Sesión" />

    <div class="min-h-screen flex items-center justify-center bg-white p-6">
        <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            
            <!-- Columna Izquierda: Ilustración de Seguridad -->
            <div class="hidden md:flex flex-col items-center justify-center p-4">
                <div class="w-full max-w-md">
                    <img 
                        src="/images/Login (2).png" 
                        alt="Ilustración Iniciar Sesión" 
                        class="w-full h-auto object-contain" 
                    />
                </div>
            </div>

            <!-- Columna Derecha: Logo y Formulario -->
            <div class="max-w-md w-full mx-auto">
                <!-- Logo MeSupport arriba a la derecha del bloque -->
                <div class="flex justify-end mb-6">
                    <img 
                        src="/images/Logo MeSupport.png" 
                        alt="MeSupport Logo" 
                        class="h-25 object-contain" 
                    />
                </div>

                <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Iniciar Sesion</h1>

                <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Correo -->
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-1">Correo</label>
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="Ingresa tu correo"
                            class="w-full px-4 py-2.5 bg-gray-100 border border-transparent rounded-full focus:bg-white focus:border-blue-500 focus:ring-0 text-sm placeholder-gray-400 transition"
                            required
                            autofocus
                        />
                        <span v-if="form.errors.email" class="text-xs text-red-500 mt-1 block">
                            {{ form.errors.email }}
                        </span>
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-1">Contraseña</label>
                        <input
                            v-model="form.password"
                            type="password"
                            placeholder="Ingresa tu contraseña"
                            class="w-full px-4 py-2.5 bg-gray-100 border border-transparent rounded-full focus:bg-white focus:border-blue-500 focus:ring-0 text-sm placeholder-gray-400 transition"
                            required
                        />
                        <span v-if="form.errors.password" class="text-xs text-red-500 mt-1 block">
                            {{ form.errors.password }}
                        </span>
                    </div>

                    <!-- Botón Enviar -->
                    <div class="pt-4 flex justify-center">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full max-w-xs py-3 bg-[#3177bb] hover:bg-[#256098] text-white font-semibold rounded-2xl shadow-md transition duration-200 disabled:opacity-50"
                        >
                            Inicia Sesión
                        </button>
                    </div>

                    <!-- Link Registro -->
                    <div class="text-center pt-2">
                        <span class="text-sm text-gray-700">¿No tienes cuenta? </span>
                        <Link :href="route('register')" class="text-sm font-semibold text-blue-600 hover:underline">
                            Resgítrate
                        </Link>
                    </div>
                </form>
            </div>

        </div>
    </div>
</template>
