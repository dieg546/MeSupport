
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    lastname: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Registro" />

    <div class="min-h-screen flex items-center justify-center bg-white p-6">
        <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            
            <!-- Columna Izquierda: Formulario -->
            <div class="max-w-md w-full mx-auto">
                <h1 class="text-4xl font-extrabold text-black mb-8">Registro</h1>

                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Nombre -->
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-1">Nombre</label>
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="Ingresa tu Nombre"
                            class="w-full px-4 py-2.5 bg-gray-100 border border-transparent rounded-full focus:bg-white focus:border-blue-500 focus:ring-0 text-sm placeholder-gray-400 transition"
                            required
                        />
                        <span v-if="form.errors.name" class="text-xs text-red-500 mt-1 block">{{ form.errors.name }}</span>
                    </div>

                    <!-- Apellido -->
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-1">Apellido</label>
                        <input
                            
                            type="text"
                            placeholder="Ingresa tu Apellido"
                            class="w-full px-4 py-2.5 bg-gray-100 border border-transparent rounded-full focus:bg-white focus:border-blue-500 focus:ring-0 text-sm placeholder-gray-400 transition"
                            
                        />
                        
                    </div>

                    <!-- Correo -->
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-1">Correo</label>
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="Ingresa tu Correo"
                            class="w-full px-4 py-2.5 bg-gray-100 border border-transparent rounded-full focus:bg-white focus:border-blue-500 focus:ring-0 text-sm placeholder-gray-400 transition"
                            required
                        />
                        <span v-if="form.errors.email" class="text-xs text-red-500 mt-1 block">{{ form.errors.email }}</span>
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
                        <span v-if="form.errors.password" class="text-xs text-red-500 mt-1 block">{{ form.errors.password }}</span>
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-1">Confirmar Contraseña</label>
                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            placeholder="Confirma tu COntraseña"
                            class="w-full px-4 py-2.5 bg-gray-100 border border-transparent rounded-full focus:bg-white focus:border-blue-500 focus:ring-0 text-sm placeholder-gray-400 transition"
                            required
                        />
                    </div>

                    <!-- Link Login -->
                    <div class="text-right pt-2">
                        <span class="text-sm text-gray-700">¿Ya tienes cuenta? </span>
                        <Link :href="route('login')" class="text-sm font-semibold text-blue-600 hover:underline">
                            Inicia Sesión
                        </Link>
                    </div>

                    <!-- Botón Enviar -->
                    <div class="pt-4">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-8 py-3 bg-[#3177bb] hover:bg-[#256098] text-white font-semibold rounded-2xl shadow-md transition duration-200 disabled:opacity-50"
                        >
                            Crear Cuenta
                        </button>
                    </div>
                </form>
            </div>

            <!-- Columna Derecha: Ilustración y Logo -->
            <div class="hidden md:flex flex-col items-center justify-center p-4">
                <!-- Logo -->
                <div class="mb-6">
                    <img src="/images/Logo MeSupport.png" alt="MeSupport Logo" class="h-20 object-contain" />
                </div>

                <!-- Ilustración Vectorial -->
                <div class="w-full max-w-md">
                    <img src="/images/Registro.png" alt="Ilustración Registro" class="w-full h-auto object-contain" />
                </div>
            </div>

        </div>
    </div>
</template>
