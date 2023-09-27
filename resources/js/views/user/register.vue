<script setup>
import router from "@/router/index.js";
import {ref} from "vue";

const data = {
    name: '',
    email: '',
    password: '',
    password_confirmation: '',

}

let error_log =  ref('')
function register() {
    axios.get('/sanctum/csrf-cookie').
    then(response => {
    axios.post('/register', data).
    then(
        res =>
        {
            localStorage.setItem('x_xsrf_token',res.config.headers['X-XSRF-TOKEN'])
            router.push('/user/personal');

        }).catch(error=>{

    });
    });
}

</script>

<template>
    <div class="flex justify-center">
        <form @submit.prevent="register" >
            <div class="mb-3 ">
                <input placeholder="name" id="name" type="text" v-model="data.name"
                       class="form-input  px-4 py-2 rounded-full border-2 border-gray-300">
            </div>

            <div class="mb-3">
                <input placeholder="email" id="email" type="text" v-model="data.email"
                       class="form-input px-4 py-2 rounded-full border-2 border-gray-300">
            </div>
            <div class="mb-3">
                <input placeholder="password" id="password" type="password" v-model="data.password"
                       class="form-input px-4 py-2 rounded-full border-2 border-gray-300">
            </div>

            <div class="mb-3 ">
                <input placeholder="confirm password" id="password-confirm" type="password" v-model="data.password_confirmation"
                       class="form-input px-4 py-2 rounded-full border-2 border-gray-300">
            </div>

               <button  class="bg-blue-500  text-white  border-1 rounded-lg  px-2 py-0.5   hover:bg-white hover:text-black" type="submit" >
                             Регистрация
               </button>






        </form>




    </div>
</template>

<style scoped>

</style>
