<template>
  <div v-for="post in posts" :key="post.id">
    <Link :href="`/post/${post.id}`">
      <PostComponent :post="post" />
    </Link>
  </div>
</template>

<script setup>
import {Link} from '@inertiajs/inertia-vue3'
import PostComponent from '@/Components/PostComponent.vue'

defineProps({
  posts: Array,
})
</script>
