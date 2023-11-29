<template>
  <form>
    <div class="mb-8 mt-4 flex flex-wrap gap-4">
      <div class="flex flex-nowrap items-center gap-2">
        <input id="published" v-model="filterForm.published" class="input-checkbox" type="checkbox" />
        <label for="published">Published</label>
        <input id="deleted" v-model="filterForm.deleted" class="input-checkbox" type="checkbox" />
        <label for="deleted">Deleted</label>
      </div>
      <select v-model="filterForm.by" class="input-filter-l w-24">
        <option value="created_at">Added</option>
        <option value="price">Price</option>
        <option value="area">Area</option>
      </select>
      <select v-model="filterForm.order" class="input-filter-r w-32">
        <option v-for="option in sortOptions" :key="option.value" :value="option.value">
          {{ option.label }}
        </option>
      </select>
    </div>
  </form>
</template>

<script setup>
import { reactive, watch, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { debounce} from 'lodash'

const sortLabels = {
  created_at: [
    {
      label: 'Latest',
      value: 'desc',
    },
    {
      label: 'Oldest',
      value: 'asc',
    },
  ],
  area: [
    {
      label: 'Largest',
      value: 'desc',
    },
    {
      label: 'Smallest',
      value: 'asc',
    },
  ],
  price: [
    {
      label: 'Pricey',
      value: 'desc',
    },
    {
      label: 'Cheapest',
      value: 'asc',
    },
  ],
}

const sortOptions = computed(() => sortLabels[filterForm.by])

const props = defineProps({
  filters: Object,
} )

const filterForm = reactive({
  published: props.filters.published ?? true,
  deleted: props.filters.deleted ?? false,
  by: props.filters.by ?? 'created_at',
  order: props.filters.order ?? 'desc',
})

// reactive / ref / computed
watch(filterForm, debounce(() => router.get(
  route('realtor.listing.index'),
  filterForm,
  {
    preserveState: true,
    preserveScroll: true,
  }), 1000)
)

</script>

<style scoped>

</style>