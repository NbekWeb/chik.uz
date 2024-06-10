<script setup>
import { ref, watch } from 'vue'

const model = defineModel('value')

const props = defineProps({
    placeholder: String
})
const modelValue = ref(null)
function formatInput(e) {
    modelValue.value = e.target.value
        ?.toString()
        .replace(/\D/g, '')
        .replace(/(\d)(?=(\d{3})+$)/g, '$1 ')
    model.value = e.target.value.replace(/[^0-9]/g, '')
}
watch(model, () => {
    modelValue.value = model.value
        ?.toString()
        .replace(/\D/g, '')
        .replace(/(\d)(?=(\d{3})+$)/g, '$1 ')
})
</script>

<template>
    <a-input @change="formatInput" :placeholder="placeholder" :min="0" type="text" v-model:value="modelValue" />
</template>

<style scoped lang="scss"></style>
