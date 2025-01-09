<script setup>
import { RouterLink } from 'vue-router'
</script>

<template>
  <div class="flex justify-between align-center p-4 bg-gray-300">
    <h3 class="text-2xl text-indigo-600">Task</h3>
    <div>
      <router-link to="/register" class="mr-2 text-indigo-600">Register</router-link>
      <router-link to="/login" class="text-indigo-600">Login</router-link>
    </div>
  </div>
</template>
