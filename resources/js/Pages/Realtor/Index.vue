<template>
  <h1 class="text-3xl mb-4">Your Listings</h1>
  <section class="mb-8">
    <Filters :filters="filters"/>
  </section>
  <section v-if="listings.data.length" class="grid grid-cols-1 lg:grid-cols-2 gap-2">
    <Box v-for="listing in listings.data" :key="listing.id" :class="{'border-dashed': listing.deleted_at}">
      <div class="flex flex-col md:flex-row gap-2 md:items-center justify-between" :class="{'opacity-60': listing.deleted_at}">

        <div>
          <div v-if="listing.sold_at !== null" class="text-xs font-bold uppercase border border-dashed p-1 border-green-400 text-green-500 inline-block rounded-md mb-2"> sold </div>
          <div class="xl:flex items-center gap-2">
            <Price :price="listing.price" class="text-2xl font-medium" />
            <ListingParameters :listing="listing" />
          </div>

          <ListingAddress :listing="listing" />
        </div>
        <section>
          <div class="flex items-center gap-1 text-gray-600 dark:text-gray-300">
            <a class="btn-outline text-xs font-medium" :href="route('listing.show', {listing: listing.id})" target="_blank">Preview</a>
            <Link class="btn-outline text-xs font-medium" :href="route('realtor.listing.edit', {listing: listing.id})">Edit</Link>
            <Link v-if="!listing.deleted_at" class="btn-outline text-xs font-medium" :href="route('realtor.listing.destroy', {listing: listing.id})" method="DELETE" as="button">Trash</Link>
            <Link v-if="listing.deleted_at" class="btn-outline text-xs font-medium" :href="route('realtor.listing.restore', {listing: listing.id})" method="PUT" as="button">Restore</Link>
            <Link v-if="listing.deleted_at" class="btn-outline text-xs font-medium text-red-500 border-red-500" :href="route('realtor.listing.force-delete', {listing: listing.id})" method="DELETE" as="button">Delete</Link>
          </div>

          <div class="mt-2">
            <Link class="btn-outline block text-xs text-center font-medium" :href="route('realtor.listing.image.create', {listing: listing.id})">Add Images ({{ listing.images_count }})</Link>
          </div>

          <div class="mt-2">
            <Link class="btn-outline block text-xs text-center font-medium" :href="route('realtor.listing.show', {listing: listing.id})">Offers ({{ listing.offers_count }})</Link>
          </div>
        </section>
      </div>
    </Box>
  </section>

  <EmptyState v-else>
    No Listings
  </EmptyState>

  <section v-if="listings.data.length" class="w-full flex justify-center mt-8 mb-8">
    <Pagination :links="listings.links" />
  </section>

</template>

<script setup>
import Box from '@/Components/UI/Box.vue'
import Price from '@/Components/Price.vue'
import ListingAddress from '@/Components/ListingAddress.vue'
import ListingParameters from '@/Components/ListingParameters.vue'
import Filters from '@/Pages/Realtor/Index/Components/Filters.vue'
import {Link} from '@inertiajs/vue3'
import Pagination from '@/Components/UI/Pagination.vue'
import EmptyState from '@/Components/UI/EmptyState.vue'

defineProps({
  listings: Object,
  filters: Object,
})
</script>

