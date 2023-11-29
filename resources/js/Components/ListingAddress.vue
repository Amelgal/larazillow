<template>
  <div>
    {{ listing.street }}, {{ listing.city }}
  </div>
</template>

<script setup>
defineProps({
  listing: Object,
})
</script>
