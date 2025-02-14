<template>
  <div class="d-flex flex-column justify-content-center align-items-center min-vh-100 w-100 bg-gradient">
    <div class="container text-center">
      <img src="@/assets/logo.svg" alt="Logo" class="mb-4" style="max-width: 200px; height: auto;" />
      <h1 class="mb-3">Bem-vindo!</h1>
      <p class="lead">Gerencie suas tarefas de forma simples e eficiente.</p>
      <div class="mt-4 d-inline-flex gap-2">
        <router-link to="/register" class="btn btn-primary btn-lg">Cadastro <i class="bi bi-person-plus"></i></router-link>
        <router-link to="/login" class="btn btn-outline-primary btn-lg">Login <i class="bi bi-door-open"></i></router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>

</style>
