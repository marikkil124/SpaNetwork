<script setup>
import router from "@/router/index.js";
import {onMounted, onUpdated, ref, watch} from "vue";
import axios from "axios";


const users = ref([])
const data = ref({
    is_followed: false,

})


function getUsers() {
    axios.get(`/api/users`).then(res => {
            console.log(res)

             users.value = res.data.data;
        }
    )
}





function toggleFollow(user) {
    axios.post(`/api/users/${user.id}/toggle_follow`).then(res => {
        data.value.is_followed = res.data.is_followed
        getUsers()
        console.log(res)
    })
}

getUsers()
</script>

<template>
    <h1 class="text-center"> Пользователи</h1>


    <div class=" flex justify-between  box-content mx-auto w-72 mt-4 p-4 ">
        <div v-if="users" class="  border-b-2 border-t-gray-300 mb-2 pb-1 items-center">
            <div v-for="user in users">
                <router-link :to="{path:`/user/${user.id}`}">
                    <p> Имя пользователя: {{ user.name }}</p>
                    <p> email пользователя: {{ user.email }}</p>
                </router-link>
                <a :class="['  text-center border-1 rounded-3xl px-2 py-0.5 hover:bg-white hover:text-black border border-gray-300 ml-72' ,user.is_followed ? 'text-black bg-white-500  ' : 'bg-blue-500 text-white']"
                   href="#"    type="submit" @click.prevent="toggleFollow(user)">
                    {{ user.is_followed ?'Отписаться' :'Подписаться'}}
                </a>
            </div>

        </div>


    </div>
    <router-view></router-view>
</template>

<style scoped>

</style>
