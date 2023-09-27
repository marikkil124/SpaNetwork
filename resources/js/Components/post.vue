<script setup>
import axios from "axios";
import { ref} from "vue";

const props = defineProps(['post']);
const is_liked = ref(props.post.is_liked);
const likes_count = ref(props.post.likes_count);


console.log(likes_count.value)

function likedPosts(post) {

    axios.get(`/api/posts/${post.id}/liked_posts`).then(res => {
        console.log(likes_count.value)
        is_liked.value = res.data.is_liked

        likes_count.value = res.data.likes_count

    })
}

</script>

<template>

    <h1 class="text-lg">{{ props.post.title }}</h1>
    <img :src="props.post.image_url" :alt="props.post.title" width="400" height="400">
    <p class="break-words">{{ props.post.content }}</p>

    <div class="flex justify-between items-center mt-3">
        <div class="flex">

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                 :class="['w-5 h-5 stroke-sky-500  hover:fill-sky-700', is_liked ? 'fill-sky-700' : 'fill-white']"
                 @click.prevent="likedPosts(props.post)"
            >
                <path
                    d="M9.653 16.915l-.005-.003-.019-.01a20.759 20.759 0 01-1.162-.682 22.045 22.045 0 01-2.582-1.9C4.045 12.733 2 10.352 2 7.5a4.5 4.5 0 018-2.828A4.5 4.5 0 0118 7.5c0 2.852-2.044 5.233-3.885 6.82a22.049 22.049 0 01-3.744 2.582l-.019.01-.005.003h-.002a.739.739 0 01-.69.001l-.002-.001z"/>
            </svg>
            <p class="text-sm">
                            {{likes_count}}
            </p>
        </div>


        <p class="text-sm text-right 2 mt-2">{{ props.post.data }}</p>

    </div>


</template>

<style scoped>

</style>
