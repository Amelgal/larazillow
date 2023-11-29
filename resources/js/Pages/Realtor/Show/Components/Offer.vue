<template>
  <Box class="mb-4">
    <template #header>
      Offer #{{ offer.id }}
      <span v-if="isAccepted" class="dark:bg-green-900 dark:text-green-200 bg-green-200 text-green-900 p-1 rounded-md uppercase ml-1">
        Accepted
      </span>
      <span v-if="isRejected" class="dark:bg-red-700 dark:text-green-200 bg-green-200 text-green-900 p-1 rounded-md uppercase ml-1">
        Rejected
      </span>
    </template>

    <section class="flex items-center justify-between">
      <div>
        <Price :price="offer.amount" class="text-xl" />

        <div class="text-gray-500">
          Difference <Price :price="difference" />
        </div>

        <div class="text-gray-500 text-sm">
          Made by {{ offer.bidder.name }}
        </div>

        <div class="text-gray-500 text-sm">
          Made on {{ offerMadeOn }}
        </div>
      </div>
      <div v-if="!(isAccepted || isRejected)">
        <Link :href="route( 'realtor.offer.accept', { offer: offer.id })" class="btn-outline text-xs font-medium" as="button" method="PUT">
          Accept
        </Link>
      </div>
    </section>
  </Box>
</template>

<script setup>
import Box from '@/Components/UI/Box.vue'
import Price from '@/Components/Price.vue'
import {Link} from '@inertiajs/vue3'
import {computed, ref} from 'vue'

const props = defineProps({
  offer: Object,
  listingPrice: Number,
})
const offerMadeOn = computed(
  () => new Date(props.offer.created_at).toDateString(),
)

const difference = computed(
  () =>  props.offer.amount - props.listingPrice,
)

const isAccepted = ref(props.offer.accepted_at)
const isRejected = ref(props.offer.rejected_at)
</script>

<style scoped>

</style>