<script setup>
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import { useToast } from 'vue-toastification';
import router from '@/router';
import axios from 'axios';

const toast = useToast()
const route = useRoute();

const name = ref('');
const email = ref('');
const images= ref([]);
const imageFile = ref();
const errors = ref([]);
const token = route.params.token;
const created_at = ref('');

onMounted(async () => {
    await getUserData();
    await getUserImages();
})

const getUserData = async () => {
    const response = await axios.post(`http://127.0.0.1:8080/api/auth/user/data`, { token });
    if (response.data.data) {
        name.value = response.data.data.name;
        email.value = response.data.data.email;
        created_at.value = response.data.data.created_at;
    }
    else {
        router.push('/login');
    }
}

const getUserImages = async () => {
    const response = await axios.get(`http://127.0.0.1:8000/api/user/images`,  { params: { token } });
    if (response.data.data) {
        images.value = response.data.data;
    }
    else {
        router.push('/login');
    }
}
const logout = async () => {
    try {
        const response = await axios.post('http://127.0.0.1:8000/api/user/images', token);
        console.log(response);
        if (response.data.data.code == 200) {
            router.push('/login');
        }
    } catch (error) {
        router.push('/login');
    }
}

const uploadImage = async () => {
    try {
        const fd = new FormData();
        fd.append('token', token);
        fd.append('image', imageFile.value);
        const response = await axios.post('http://127.0.0.1:8000/api/upload', fd);
        console.log(response.data);
        if (response.data.code == 200) {
            images.value.push(response.data.data);
            toast.success('Image uploaded successfully');
        }
        else if(response.data.code == 403){ 
            
            toast.error(response.data.message);
        }
        else{
            errors.value = response.data.errors;
            toast.error('Image upload failed');
            
        }
       
    } catch (error) {
        errors.value = error.response.data.errors;
    }
    
}
</script>
<template>
    <div class="flex justify-between align-center p-3 bg-gray-100">
        <div class="flex justify-items-start align-center">
            <h1 class=" text-2xl ">Profile</h1>
            <h3 class="m-2">{{ name }}</h3>
            <h3 class="m-2">{{ email }}</h3>
        </div>
        <a v-on:click="logout" class="text-indigo-600 hover:text-indigo-500 cursor-pointer">Logout</a>
    </div>

    <div>
        <form action="" @submit.prevent="uploadImage" class="space-y-6">
            <div class="mt-2">
                <label for="image" class="block text-sm/6 font-medium text-gray-900">Profile Picture</label>
                <div class="mt-2">
                    <input @change="imageFile = $event.target.files[0]"
                        className="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-foreground file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50"
                        id="picture" name="picture" type="file">
                </div>
                <span v-if="errors.image" class="text-red-500 text-xs mt-1">
                    {{ errors.image[0] }}
                </span>
            </div>
            <button type="submit"
                        class="justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600  mt-2">Upload
                        </button>
        </form>
    </div>
    <div v-if="name" class="grid grid-cols-3 gap-4">
        <div v-for="(image , index) in images" :key="index" class="max-w-sm m-5 rounded overflow-hidden shadow-lg bg-white">
        <!-- Image -->
        <img class="w-full h-48 object-cover" :src="image" alt="Card Image">
    </div>
    </div>

</template>