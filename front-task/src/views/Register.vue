<script setup>
import { RouterLink, useRouter } from 'vue-router'
import router from '@/router';
import axios from 'axios';
import { ref } from 'vue';
const name = ref('');
const email = ref('');
const password = ref('');
const image = ref();

const errors = ref([]);
const register = async () => {
    try {
        const fd = new FormData();
        fd.append('name', name.value);
        fd.append('email', email.value);
        fd.append('password', password.value);
        const response = await axios.post('http://127.0.0.1:8080/api/auth/register', fd);

        if (response.data.code == 200) {
            router.push(`/profile/${response.data.data.token}`);
        }
    }
    catch (error) {
        errors.value = error.response.data.errors
    }

}

</script>
<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
                alt="Your Company">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" @submit.prevent="register">
                <div>
                    <label for="name" class="block text-sm/6 font-medium text-gray-900">Name </label>
                    <div class="mt-2">
                        <input v-model="name" type="name" name="name" id="name" autocomplete="name" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                    <span v-if="errors.name" class="text-red-500 text-xs mt-1">
                        {{ errors.name[0] }}
                    </span>
                </div>
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input v-model="email" type="email" name="email" id="email" autocomplete="email" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                    <span v-if="errors.email" class="text-red-500 text-xs mt-1">
                        {{ errors.email[0] }}
                    </span>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                        <div class="text-sm">
                            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input v-model="password" type="password" name="password" id="password"
                            autocomplete="current-password" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                    <span v-if="errors.password" class="text-red-500 text-xs mt-1">
                        {{ errors.password[0] }}
                    </span>

                    
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign
                        in</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                <RouterLink to="/login" class="font-semibold text-indigo-600 hover:text-indigo-500">Login</RouterLink>

            </p>
        </div>
    </div>
</template>