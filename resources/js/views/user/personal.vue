<script setup>
import {onMounted, ref, watch} from "vue";
import Post from "@/Components/post.vue";
import Stat from "@/Components/stat.vue";

let data = ref({
    title: '',
    content: '',

})

const posts = ref([])
let Image_id = null;
let image = ref(null)
const fileInput = ref(null)
const errors = ref()
const stat=ref('')
function selectFile() {
    fileInput.value.click();
}

function getPosts() {
    axios.get('/api/posts').then(res => {
        posts.value = res.data.data
    })
}

function store() {

    axios.post('/api/posts', {
        'title': data.value.title,
        'content': data.value.content,
        'image_id': Image_id
    }).then(res => {

        data.value.title = null
        data.value.content = null
        image.value = null
        getPosts()

    })
        .catch(e => {
            console.log(e.response.data.errors)
            errors.value = e.response.data.errors
        })
}

function storeImage(e) {
    let file = e.target.files[0];
    let formData = new FormData()
    formData.append('image', file);
    axios.post('/api/post_images', formData).then(res => {
        image.value = res.data.data
        Image_id = image.value.id ? image.value.id : null;

    })
}

function getStat()
{
    axios.post('/api/user/stats',{id:null}).then(res=>{
        stat.value=res.data
        console.log(res.data)
    })

}
getPosts()
getStat()
</script>

<template>
    <div >
        <stat :stat="stat"></stat>
        <div class="flex justify-center">

            <form>
                <div class="mb-3">
                    <input placeholder="title" type="text" v-model="data.title"
                           class="form-input px-4 py-2 rounded-full border-2 border-gray-300 w-96">
                    <div v-if="errors">
                        <p v-for="error in errors.title" class="text-sm text-red-600">{{ error }}</p>
                    </div>

                </div>


                <div class="mb-3 ">
                <textarea placeholder="content" v-model="data.content"
                          class="form-input px-4 py-2 rounded-full border-2 border-gray-300 w-96"></textarea>
                    <div v-if="errors">
                        <p v-for="error in errors.content" class="text-sm text-red-600">{{ error }}</p>
                    </div>
                </div>


                <div class=" flex mb-3  items-center">
                    <div>
                        <input ref="fileInput" type="file" @change.prevent="storeImage" id="image_id"
                               class="form-input px-4 py-2 rounded-full border-2 border-gray-300 w-96 hidden ">
                        <a class=" w-24 text-sm text-center bg-green-500  text-white  border-1 rounded-3xl px-2 py-0.5
                        hover:bg-white hover:text-black border border-gray-300 "

                           type="submit" @click.prevent="selectFile">
                            Image
                        </a>
                        <div v-if="image" class="ml-80">
                            <a href="#" @click.prevent="image=null"> Cancel</a>
                        </div>

                        <div v-if="image" class="">
                            <img v-bind:src="image.url" alt="preview" width="400" height="400">
                        </div>
                    </div>
                </div>

                <a class=" w-24  bg-blue-500  text-white  text-center border-1 rounded-3xl px-2 py-0.5
        hover:bg-white hover:text-black border border-gray-300 ml-72"
                   type="submit" @click.prevent="store()">
                    Добавить
                </a>

            </form>
        </div>


        <div v-if="posts" class="box-content h-32 w-96 p-4  mx-auto">
            <div v-for="post in posts" class=" border-b-2 border-t-gray-300 mb-2 pb-1 ">
                <div class="flex">
                    <post :post="post"></post>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
