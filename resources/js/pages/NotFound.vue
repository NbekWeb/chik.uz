<template>
    <a-result
        status="404"
        title="404"
        sub-title="Извините, страница, которую вы посетили, не существует."
    >
        <template #extra>
            <a-button type="primary" @click="goHome">Вернуться на главную</a-button>
        </template>
    </a-result>
</template>

<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

const goHome = () => {
    router.push({ name: "Home" }); 
};
</script>
