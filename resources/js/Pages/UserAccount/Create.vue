<template>
  <form @submit.prevent="create">
    <div class="w-1/2 mx-auto">
      <div class="mt-4">
        <label for="name" class="label">Username</label>
        <input id="name" v-model="form.name" type="text" class="input"/>
        <div v-if="form.errors.name" class="input-error">
          {{ form.errors.name }}
        </div>
      </div>
      <div class="mt-4">
        <label for="email" class="label">Email</label>
        <input id="email" v-model="form.email" type="text" class="input"/>
        <div v-if="form.errors.email" class="input-error">
          {{ form.errors.email }}
        </div>
      </div>
      <div class="mt-4">
        <label for="password" class="label">Password</label>
        <input id="password" v-model="form.password" type="password" class="input"/>
        <div v-if="form.errors.password" class="input-error">
          {{ form.errors.password }}
        </div>
      </div>
      <div class="mt-4">
        <label for="password" class="label">Password Confirmation</label>
        <input id="password_confirmation" v-model="form.password_confirmation" type="password" class="input"/>
      </div>
      <div class="mt-4">
        <button type="submit" class="btn-primary w-full">Registration</button>
        <div class="mt-2 text-center w-full">
          <Link :href="route('login')" class="text-gray-500 w-full">Already have an account? Click here</Link>
        </div>
      </div>
    </div>
  </form>
</template>

<script setup>
import {Link, useForm} from '@inertiajs/vue3'

const form = useForm({
  name: null,
  email: null,
  password: null,
  password_confirmation: null,
})

const create = () => {
  form.post(route('user.store'))
}

defineProps({})
</script>
