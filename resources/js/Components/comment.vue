<script setup>
import axios from "axios";
import {ref} from "vue";

const props = defineProps(['post', 'CommentVisible', 'Comments']);
const comment_body = ref()
const emit = defineEmits(['CommentCount','CommentDelete'])
const refToCommentBody = ref(null)
const parentComment=ref(null)
function addComment(post) {
   let parent_id = parentComment.value!=null ? parentComment.value.id : null;
    axios.post(`/api/posts/${post.id}/comment`, {body: comment_body.value, post_id: post.id,parent_id:parent_id}).then(res => {
        comment_body.value = ''
        emit('CommentCount')
    })
}

function addAnswer(comment) {
    refToCommentBody.value.scrollIntoView({ behavior: "smooth" })
    parentComment.value=comment
    console.log(props.Comments)
}
function deleteComment(comment)
{
    console.log(comment.id)
    axios.delete(`/api/posts/${comment.id}`).then(res=>{
        emit('CommentDelete')

    })

}

</script>

<template>

    <div class="mt-4 " v-if="props.CommentVisible">
        <div class="mb-3">
            <input placeholder="comment" type="text" v-model="comment_body" ref="refToCommentBody"
                   class="form-input px-4 py-2 rounded-full border-2 border-gray-300 w-96">

            <div v-if="parentComment">
                <p class="text-sm" >Ответ {{parentComment.user.name}}</p>
                <p class="text-sm text-sky-500 cursor-pointer" @click="parentComment=null">Отменить</p>
            </div>

        </div>
        <a class=" w-32  bg-blue-500  text-white  text-center border-1 rounded-3xl px-2 py-0.5
        hover:bg-white hover:text-black border border-gray-300 ml-72"
           type="submit" @click="addComment(props.post)">
            Добавить
        </a>

        <div v-for="comment in props.Comments" class="items-center ml-auto justify-between">
            <div class="items-center   w-96" >

                <p class="">Пользователь:<span class="text-sky-500"> {{ comment.user.name }}</span></p>
                <p class=""> {{ comment.comment }}</p>
                <div class="items-center   w-96 bg-gray-100 box-content   border-l-4 border-l-sky-300 ml-10" v-if="comment.parent_id">
                    <div v-for="comment_pId in props.Comments">
                        <div v-if="comment_pId.id==comment.parent_id">
                            <p class="">Пользователь:<span class="text-sky-500"> {{ comment_pId.user.name }}</span></p>
                            <p class=""> {{ comment_pId.comment }}</p>
                        </div>
                    </div>
                </div>

                <p class="cursor-pointer text-sm text-right text-sky-500" @click=addAnswer(comment) > ответить</p>
                <p class="cursor-pointer text-sm text-right text-red-500" v-if="comment.user.id===comment.auth_user_id" @click=deleteComment(comment) > удалить</p>
                <p class=" text-sm text-right"> {{ comment.date }}</p>

            </div>

        </div>
    </div>

</template>

<style scoped>

</style>
