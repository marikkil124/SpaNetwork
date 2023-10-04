<script setup>
import {onMounted, ref, watch} from "vue";
import router from "@/router/index.js";
import {useRoute, useRouter} from "vue-router";
import Post from "@/Components/post.vue";
import Stat from "@/Components/stat.vue";
let data = ref({
    title: '',
    content: '',

})
const stat=ref([''])

const route = useRoute()
const posts = ref([])

function getStat()
{
    axios.post('/api/user/stats',{user_id:route.params.id}).then(res=>{
        stat.value=res.data
        console.log(res.data)
    })

}

function getPosts() {
    axios.get(`/api/users/${route.params.id}/posts`).then(res => {

         posts.value=res.data.data
        getStat()
    })
}

getPosts()


</script>

<template>
    <stat :stat="stat"></stat>
    <div v-if="posts" class="box-content h-32 w-96 p-4  mx-auto">

        <div v-for="post in posts" class=" border-b-2 border-t-gray-300 mb-2 pb-1 ">
            <post :post="post"></post>
        </div>
    </div>
</template>

<style scoped>

</style>
