<script setup>

import router from "@/router/index.js";
import {onUpdated, ref, watch, watchEffect} from "vue";
import {useRoute, useRouter} from "vue-router";

const route = useRoute()
const token = ref(localStorage.getItem('x_xsrf_token'));

function Logout() {
    axios.post('/logout').then(res => {
        localStorage.removeItem('x_xsrf_token')
        router.push('/user/login');
    })

    watch(route, () => {
            token.value = localStorage.getItem('x_xsrf_token');
            console.log(token.value)
        }
    )


}
</script>


<template>

    <div class="flex justify-between p-8 w-96 mx-auto">

        <router-link v-if="!token" to="/user/login" class="text-sky-500">Login</router-link>
        <router-link v-if="!token" to="/user/register" class="text-sky-500">Register</router-link>
        <router-link v-if="token" to="/user/personal" class="text-sky-500">Personal</router-link>
        <router-link v-if="token" to="/user/index" class="text-sky-500">Users</router-link>
        <router-link v-if="token" to="/user/following_posts" class="text-sky-500">Follows</router-link>
        <a @click.prevent="Logout()" class="text-sky-500 ">Logout</a>


    </div>


    <router-view></router-view>
</template>

<style scoped>

</style>
