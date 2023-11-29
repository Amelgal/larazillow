<template>
  <form @submit.prevent="filter">
    <div class="mb-8 mt-4 flex flex-wrap gap-2">
      <div class="flex flex-nowrap items-center">
        <input v-model.number="filterForm.priceMin" class="input-filter-l w-28" placeholder="Price from" type="text" />
        <input v-model.number="filterForm.priceMax" class="input-filter-r w-28" placeholder="Price to" type="text" />
      </div>

      <div class="flex flex-nowrap items-center">
        <select v-model="filterForm.beds" class="input-filter-l w-28">
          <option :value="null">Beds</option>
          <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
          <option>6+</option>
        </select>
        <select v-model="filterForm.baths" class="input-filter-r w-28">
          <option :value="null">Baths</option>
          <option v-for="n in 5" :key="n" :value="n">{{ n }}</option>
          <option>6+</option>
        </select>
      </div>

      <div class="flex flex-nowrap items-center">
        <input v-model.number="filterForm.areaMin" class="input-filter-l w-28" placeholder="Area from" type="text" />
        <input v-model.number="filterForm.areaMax" class="input-filter-r w-28" placeholder="Area to" type="text" />
      </div>

      <button type="submit" class="btn-normal">Filter</button>
      <button type="reset" @click="clear">Clear</button>
    </div>
  </form>
</template>

<script setup>
import {useForm} from '@inertiajs/vue3'

const props = defineProps({
  filters: Object,
} )

const filterForm = useForm({
//const form = reactive({
  beds: props.filters.beds ?? null,
  baths: props.filters.baths ?? null,
  areaMax: props.filters.areaMax ?? null,
  areaMin: props.filters.areaMin ?? null,
  priceMax: props.filters.priceMax ?? null,
  priceMin: props.filters.priceMin ?? null,
})

const filter = () => {
  filterForm.get( route('listing.index'), {
    preserveState: true,
    preserveScroll: true,
  } )
}

const clear = () => {
  filterForm.beds = null
  filterForm.baths = null
  filterForm.areaMax = null
  filterForm.areaMin = null
  filterForm.priceMax = null
  filterForm.priceMin = null
  filter()
}
</script>

<style scoped>

</style>