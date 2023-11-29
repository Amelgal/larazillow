<template>
  <Box>
    <div class="listing">
      <div class="flex items-center gap-1">
        <Price :price="listing.price" class="text-2xl font-bold"/>
        <div class="text-xs text-gray-400">
          <Price :price="monthlyPayment" class=""/>
          mp
        </div>
      </div>
      <ListingAddress :listing="listing" class="text-gray-400 dark:text-gray-300"/>
      <ListingParameters :listing="listing" class="text-lg"/>
    </div>
    <div class="pb-1 pt-1 mt-2">
      <span class="btn-outline m-1">
        <Link :href="route('listing.show', {listing: listing.id})">Show</Link>
      </span>
    </div>
  </Box>
</template>

<script setup>
import {Link} from '@inertiajs/vue3'
import ListingAddress from '@/Components/ListingAddress.vue'
import Box from '@/Components/UI/Box.vue'
import ListingParameters from '@/Components/ListingParameters.vue'
import Price from '@/Components/Price.vue'

import { useMonthlyPayment } from '@/Composables/useMonthlyPayment'

const props = defineProps({
  listing: Object,
})

const { monthlyPayment } = useMonthlyPayment( props.listing.price, 2.5, 25 )
</script>

