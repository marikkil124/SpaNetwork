<script setup>
import {onMounted, ref, watch} from "vue";
import router from "@/router/index.js";
import {useRoute, useRouter} from "vue-router";
import Post from "@/Components/post.vue";

let data = ref({
    title: '',
    content: '',

})


const route = useRoute()
const posts = ref([])



function getPosts() {
    axios.get(`/api/users/following_posts`).then(res => {
        console.log(res);
        posts.value=res.data.data
    })
}




getPosts()

</script>

<template>

    <div v-if="posts" class="box-content h-32 w-96 p-4  mx-auto">
        <div v-for="post in posts" class=" border-b-2 border-t-gray-300 mb-2 pb-1 ">
            <post :post="post"></post>
        </div>
    </div>
</template>

<style scoped>

</style>
