<script setup>
import router from "@/router/index.js";
import {ref} from "vue";

const data = {
    email: '',
    password: '',

}

function login() {
    axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post('/login', data).then(
            res => {

                localStorage.setItem('x_xsrf_token', res.config.headers['X-XSRF-TOKEN'])
                router.push('/user/personal');
            }).catch(error => {
        });
    });

}
</script>

<template>
    <div class="flex  justify-center">
        <form @submit.prevent="login">
            <div>
                <input placeholder="email" id="email" type="text" v-model="data.email"
                       class="form-input px-4 py-2 rounded-full">
            </div>
            <div class="mt-3 mb-3">
                <input placeholder="password" id="password" type="password" v-model="data.password"
                       class="form-input px-4 py-2 rounded-full ">
            </div>

            <button class="bg-blue-500  text-white  border-1 rounded-lg  px-2 py-0.5   hover:bg-white hover:text-black"
                    type="submit">
                Войти
            </button>

        </form>


    </div>

</template>

<style scoped>

</style>
