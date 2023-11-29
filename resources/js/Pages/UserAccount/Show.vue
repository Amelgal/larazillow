<template>
  <div class="flex flex-col-reverse md:grid grid-cols-12 gap-4">
    <Box class="md:col-span-7 flex items-center w-full ">
      <div class="w-full text-center font-medium text-gray-400">
        No Images
      </div>
    </Box>
    <div class="md:col-span-5 flex flex-col gap-4">
      <Box>
        <template #header>Basic Info</template>
        <Price :price="listing.price" class="text-2xl font-bold"/>
        <ListingAddress :listing="listing" class="text-gray-400 dark:text-gray-300"/>
        <ListingParameters :listing="listing" class="text-lg"/>
      </Box>
      <Box>
        <template #header>Monthly Payment</template>
        <div>
          <label class="label" for="">
            Interest rate ({{ interestRate }}%)
          </label>
          <input
            v-model.number="interestRate"
            type="range" min="0.1" max="30" step="0.1"
            class="w-full h4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-900"
          />

          <label class="label" for="">
            Duration ({{ duration }} years)
          </label>
          <input
            v-model.number="duration"
            type="range" min="1" max="35" step="1"
            class="w-full h4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-900"
          />

          <div class="text-gray-600 dark:text-gray-300 mt-2">
            <div class="text-gray-400">
              Your monthly payment
            </div>
            <Price :price="monthlyPayment" class="text-3xl" />
          </div>

          <div class="text-gray-500 dark:text-gray-300 mt-2">
            <div class="flex justify-between">
              <div>
                Total paid
              </div>
              <div>
                <Price :price="totalPaid" class="font-medium" />
              </div>
            </div>
            <div class="flex justify-between">
              <div>
                Principle paid
              </div>
              <div>
                <Price :price="listing.price" class="font-medium" />
              </div>
            </div>
            <div class="flex justify-between">
              <div>
                Total interest
              </div>
              <div>
                <Price :price="totalInterest" class="font-medium" />
              </div>
            </div>
          </div>
        </div>
      </Box>
    </div>
  </div>
</template>

<script setup>
import ListingAddress from '@/Components/ListingAddress.vue'
import Price from '@/Components/Price.vue'
import ListingParameters from '@/Components/ListingParameters.vue'
import Box from '@/Components/UI/Box.vue'

import {ref} from 'vue'

import {useMonthlyPayment} from '@/Composables/useMonthlyPayment'

const interestRate = ref(2.5)
const duration = ref(25)

const props = defineProps({
  listing: Object,
})

const { monthlyPayment, totalPaid, totalInterest } = useMonthlyPayment( props.listing.price, interestRate, duration )

</script>
