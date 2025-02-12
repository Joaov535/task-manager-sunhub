<template>
  <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 w-100">
    <div class="container text-center">
      <h1 class="mb-3">Bem-vindo ao Meu App</h1>
      <p class="lead">Gerencie seu sistema de forma simples e eficiente.</p>
      <div class="mt-4 d-inline-flex gap-2">
        <router-link to="/register" class="btn btn-primary">Cadastro</router-link>
        <router-link to="/login" class="btn btn-outline-primary">Login</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>

</style>
