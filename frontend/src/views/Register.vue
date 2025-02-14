<template>
  <div class="d-flex justify-content-center align-items-center vh-100">
      <div class="card p-4 shadow-lg" style="width: 350px;">
        <h2 class="text-center mb-3">Cadastro</h2>
        <form @submit.prevent="register">
          <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" id="name" class="form-control" v-model="name" required />
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" class="form-control" v-model="email" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" id="password" class="form-control" v-model="password" minlength="8" maxlength="32" title="Digite uma senha entre 8 e 32 caracteres" required />
          </div>
          <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
        </form>
        <div class="text-center mt-3">
          <router-link to="/login" title="Login">Já possui uma conta?</router-link>
        </div>
      </div>
    </div>
    </template>
    
    <script>
    import Swal from 'sweetalert2';

    export default {
      data() {
        return {
          name: '',
          email: '',
          password: '',
          errorMessage: '',
        };
      },
      methods: {
        async register() {
          try {
            const response = await this.$axios.post('/register', {
              name: this.name,
              email: this.email,
              password: this.password,
            });
    
            localStorage.setItem('token', response.data.token);
    
            this.$router.push('/tasks');
          } catch (error) {
            const message =
            error.response?.data?.message || "Erro ao cadastrar usuário.";

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
    