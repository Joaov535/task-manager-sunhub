<template>
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 350px">
      <h2 class="text-center mb-3">Login</h2>
      <form @submit.prevent="login">
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input
            type="email"
            id="email"
            class="form-control"
            v-model="email"
            required
          />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Senha</label>
          <input
            type="password"
            id="password"
            class="form-control"
            v-model="password"
            required
          />
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
      </form>
      <div class="text-center mt-3">
        <router-link to="/register">Criar conta</router-link>
      </div>
    </div>
  </div>
</template>
  
  <script>
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      email: "",
      password: "",
      errorMessage: "",
    };
  },
  methods: {
    async login() {
      try {
        const response = await this.$axios.post("/login", {
          email: this.email,
          password: this.password,
        });

        if (response.data.token) {
          localStorage.setItem("token", response.data.token);
        }

        this.$router.push("/tasks");
      } catch (error) {

        const message =
            error.response?.data?.message || "Falha ao realizar login";

        Swal.fire({
          title: "Oops...",
          text: message,
          icon: "warning"
        });
      }
    },
  },
};
</script>
  
  <style>
</style>
  