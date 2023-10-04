<script setup>
import axios from "axios";
import {ref, resolveDirective} from "vue";
import {useRoute} from "vue-router";
import Repost from "@/Components/repost.vue";
import Comment from "@/Components/comment.vue";

const route = useRoute()

let data = ref({
    title: '',
    content: '',

})
const props = defineProps(['post']);
const is_liked = ref(props.post.is_liked);
const likes_count = ref(props.post.likes_count);
const RepostVisible = ref(false)
const RepostedPost = ref(props.post.reposted_id)

const Comments = ref()
let RepostCount = ref(0)
let CommentCount = ref(0)
const CommentVisible = ref(false)

function repostVisible() {
    if (route.path === '/user/personal')
        return
    else
        RepostVisible.value = !RepostVisible.value
}

function likedPosts(post) {
    axios.post(`/api/posts/${post.id}/liked_posts`).then(res => {
        is_liked.value = res.data.is_liked
        likes_count.value = res.data.likes_count

    })
}

function getComments(post) {
    CommentVisible.value = !CommentVisible.value
    if (CommentVisible.value) {
        axios.get(`/api/posts/${post.id}/comment`).then(res => {
            Comments.value = res.data.data
            console.log(res)
        })
    }

}


</script>

<template>
    <div class="mb-3">


        <h1 class="text-xl text-center  "> {{ props.post.title }}</h1>
        <router-link :to="`/user/${props.post.user.id}`" class="text-lg text-sky-500 text-sm">{{
                props.post.user.name
            }}
        </router-link>
        <img v-if="props.post.image_url" :src="props.post.image_url" :alt="props.post.title" width="400" height="400">
        <p class="break-words font-serif">{{ props.post.content }}</p>

        <div v-if="RepostedPost">

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181"/>
            </svg>
            <router-link :to="`/user/${RepostedPost.user.id}`" class="text-lg text-sky-500 text-sm">
                {{ RepostedPost.user.name }}
            </router-link>

        </div>

        <div v-if="RepostedPost" class="bg-gray-100 box-content  w-72 border-l-4 border-l-sky-300 ml-10">
            <h1 class="text-lm">{{ RepostedPost.title }}</h1>
            <img :src="RepostedPost.image_url" :alt="RepostedPost.title" width="300" height="300">
            <p class="break-words">{{ RepostedPost.content }}</p>

        </div>


        <div class="flex justify-between items-center mt-3">
            <div class="flex">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                         :class="['w-5 h-5 stroke-sky-500  hover:fill-sky-700', is_liked ? 'fill-sky-700' : 'fill-white']"
                         @click.prevent="likedPosts(props.post)"
                    >
                        <path
                            d="M9.653 16.915l-.005-.003-.019-.01a20.759 20.759 0 01-1.162-.682 22.045 22.045 0 01-2.582-1.9C4.045 12.733 2 10.352 2 7.5a4.5 4.5 0 018-2.828A4.5 4.5 0 0118 7.5c0 2.852-2.044 5.233-3.885 6.82a22.049 22.049 0 01-3.744 2.582l-.019.01-.005.003h-.002a.739.739 0 01-.69.001l-.002-.001z"/>
                    </svg>
                    <p class="text-sm">
                        {{ likes_count }}
                    </p>

                </div>
                <div class="flex ml-2 items-center bg-gray-300 rounded-full w-10">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                         @click.prevent=" repostVisible"
                         :class="['w-5 h-5 stroke-sky-500  hover:fill-sky-700 fill-white']">
                        <path
                            d="M13 4.5a2.5 2.5 0 11.702 1.737L6.97 9.604a2.518 2.518 0 010 .792l6.733 3.367a2.5 2.5 0 11-.671 1.341l-6.733-3.367a2.5 2.5 0 110-3.475l6.733-3.366A2.52 2.52 0 0113 4.5z"/>
                    </svg>
                    <p class="text-sm text-gray-500">{{ props.post.repost_counts + RepostCount }}</p>


                </div>
                <div class="flex ml-2 items-center bg-gray-300 rounded-full w-10">
                    <svg @click.prevent="getComments(props.post)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                         fill="currentColor" class="w-5 h-5 fill-white stroke-sky-500  fill-[21] ">
                        <path fill-rule="evenodd"
                              d="M3.43 2.524A41.29 41.29 0 0110 2c2.236 0 4.43.18 6.57.524 1.437.231 2.43 1.49 2.43 2.902v5.148c0 1.413-.993 2.67-2.43 2.902a41.102 41.102 0 01-3.55.414c-.28.02-.521.18-.643.413l-1.712 3.293a.75.75 0 01-1.33 0l-1.713-3.293a.783.783 0 00-.642-.413 41.108 41.108 0 01-3.55-.414C1.993 13.245 1 11.986 1 10.574V5.426c0-1.413.993-2.67 2.43-2.902z"
                              clip-rule="evenodd"/>

                    </svg>
                    <p class="text-sm text-gray-500">{{ props.post.comments_count + CommentCount }}</p>
                </div>
            </div>

            <p class="text-sm text-right 2 mt-2">{{ props.post.data }}</p>

        </div>
        <repost :post="props.post" :data="data" :RepostVisible="RepostVisible" @repost="()=>RepostCount++"></repost>

        <comment :post="props.post" :Comments="Comments" :CommentVisible="CommentVisible"
                 @CommentCount="()=>{getComments(props.post) ,CommentCount++}"></comment>

        <router-view></router-view>

    </div>
</template>

<style scoped>

</style>
