<template>
  <form @submit.prevent="login">
    <div class="w-1/2 mx-auto">
      <div class="mt-4">
        <label for="email" class="label">Email (username)</label>
        <input v-model="form.email" id="email" type="text" class="input"/>
        <div v-if="form.errors.email" class="input-error">
          {{ form.errors.email }}
        </div>
      </div>
      <div class="mt-4">
        <label for="password" class="label">Password</label>
        <input v-model="form.password" id="password" type="password" class="input"/>
        <div v-if="form.errors.password" class="input-error">
          {{ form.errors.password }}
        </div>
      </div>
      <div class="mt-4">
        <button type="submit" class="btn-primary w-full">Login</button>
        <div class="mt-2 text-center w-full">
          <Link :href="route('user.create')" class="text-gray-500 w-full">Need an account? Click here</Link>
        </div>
      </div>
    </div>
  </form>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/vue3'

const form = useForm({
  email: null,
  password: null,
})

const login = () => {
  form.post(route('login.store'))
}

</script>