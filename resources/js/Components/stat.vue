<script setup>
import {ref} from "vue";

const props=defineProps(['stat'])


</script>

<template>
    <div class="flex  justify-center mb-3">
        <div>
            <p>Подписчики: {{props.stat.subscribes}}</p>
            <p>Подписки: {{props.stat.followers}}</p>
            <p>Лайки: {{props.stat.likes}}</p>
            <p>Постов: {{props.stat.posts}}</p>
        </div>
    </div>
</template>

<style scoped>

</style>
