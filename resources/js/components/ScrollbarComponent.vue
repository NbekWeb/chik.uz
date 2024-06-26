<script setup>
const props = defineProps({
  totalPages: Number,
  page: Number,
  loading: Boolean,
  height: String
})
const emits = defineEmits(['getData'])
const scroll = (e) => {
  const clientH = e.target.clientHeight
  const scrollTop = e.target.scrollTop
  const scrollH = e.target.scrollHeight
  const page = props.page + 1
  if (
    Math.ceil(clientH + scrollTop + 1) >= scrollH &&
    page < props.totalPages &&
    !props.loading
  ) {
    emits('getData', page)
  }
}
</script>

<template>
  <div
    class="p-1 scrollbar-content"
    :style="{ height: height }"
    id="scrollbar-content"
    @scroll="scroll"
  >
    <slot name="content"></slot>
  </div>
</template>

<style scoped lang="scss">

.scrollbar-content {
  height: 100vh;
  overflow-y: auto;
  overflow-x: hidden;
  transition: all 0.5s;
  &::-webkit-scrollbar {
    width: 5px;
  }

  /* Track */
  &::-webkit-scrollbar-track {
    width: 10px;
    background: #fff;
  }

  /* Handle */
  &::-webkit-scrollbar-thumb {
    background: rgb(#8c093d, 1);
    border-radius: 4px;
  }

  /* Handle on hover */
  &::-webkit-scrollbar-thumb:hover {
    background: #8c093d;
  }
}
</style>
