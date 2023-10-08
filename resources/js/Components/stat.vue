<script setup>
import {ref} from "vue";

const props = defineProps(['stat'])


</script>

<template>
    <div class="flex  justify-center mb-3">
        <div class="grid grid-cols-4 gap-4 ">

            <div class="  ">Подписчики: {{ props.stat.subscribes }}</div>
            <div class="">Подписки: {{ props.stat.followers}}</div>
            <div class="">Лайки: {{ props.stat.likes}}</div>
            <div>Постов: {{ props.stat.posts }}</div>

        </div>
    </div>
</template>

<style scoped>

</style>
