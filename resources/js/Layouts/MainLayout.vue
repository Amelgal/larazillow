<template>
  <header class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 w-full">
    <div class="container mx-auto">
      <nav class="p-4 flex items-center justify-between">
        <div class="text-lg font-medium">
          <Link :href="route('listing.index')">Listings</Link>&nbsp;
        </div>
        <div v-if="$page.props.user" class="flex items-center gap-4">
          <Link :href="route('notification.index')" class="text-gray-500 relative pr-2 py-2 text-lg">
            🔔
            <div v-if="notificationCount" class="absolute right-0 top-0 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center">
              {{ notificationCount }}
            </div>
          </Link>
          <Link class="text-sm text-gray-500" :href="route('realtor.listing.index')">
            {{ $page.props.user.name }}
          </Link>
          <Link :href="route('realtor.listing.create')" class="btn-primary">+ New Listing</Link>
          <Link :href="route('logout')" method="delete" as="button">Logout</Link>
        </div>
        <div v-else class="flex items-center gap-4">
          <Link :href="route('user.create')" class="btn-primary">Register</Link>
          <Link :href="route('login')" class="btn-primary">Sigh-In</Link>
        </div>
      </nav>
    </div>
  </header>

  <main class="container mx-auto p-4 w-full">
    <div v-if="$page.props.flash.success" class="mb-4 border rounded-2xl shadow-sm border-green-500 dark:border-green-900 bg-green-400 dark:bg-green-700 p-2">
      {{ $page.props.flash.success }}
    </div>

    <slot />
    <!--  <div>The page with time {{ timer }}</div>-->
  </main>
</template>

<script setup>
import { computed } from 'vue'
import {Link, usePage} from '@inertiajs/vue3'

//page.props.value.flash.success
const page = usePage()

const notificationCount = computed(() => {
  return Math.min(page.props.user.notificationCount, 9)
})
// import {ref} from 'vue'
// const timer = ref (0)
// setInterval(()=>timer.value++, 1000)
</script>
