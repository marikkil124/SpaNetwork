<script setup>
import axios from "axios";

import {ref} from "vue";
import {useRoute} from "vue-router";
const props = defineProps(['RepostVisible','data','post']);
const errors=ref()
const data=ref(props.data)

const emit = defineEmits(['repost'])


function repost(post) {

    axios.post(`/api/posts/${post.id}/repost`, {
        title: data.value.title,
        content: data.value.content,
        reposted_id: props.post.id
    }).then(res => {
        data.value.title = ''
        data.value.content = ''
        emit('repost')
    }) .catch(e=>{

        errors.value=e.response.data.errors
    })
}

</script>

<template>
    <div class="mt-4" v-if="props.RepostVisible">
        <div class="mb-3">
            <input placeholder="title" type="text" v-model="props.data.title"
                   class="form-input px-4 py-2 rounded-full border-2 border-gray-300 w-96">
            <div v-if="errors" >
                <p v-for="error in errors.title" class="text-sm text-red-600">{{error}}</p>
            </div>
        </div>

        <div class="mb-3 ">
                <textarea placeholder="content" v-model="props.data.content"
                          class="form-input px-4 py-2 rounded-full border-2 border-gray-300 w-96"></textarea>
            <div v-if="errors" >
                <p v-for="error in errors.content" class="text-sm text-red-600">{{error}}</p>
            </div>
        </div>

        <a class=" w-32  bg-blue-500  text-white  text-center border-1 rounded-3xl px-2 py-0.5
        hover:bg-white hover:text-black border border-gray-300 ml-72"
           type="submit" @click="repost(props.post)">
            Поделиться
        </a>
    </div>
</template>

<style scoped>

</style>
