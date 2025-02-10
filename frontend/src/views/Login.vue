<template>
    <div class="login-container">
      <h2>Login</h2>
      <form @submit.prevent="login">
        <div>
          <label for="email">Email:</label>
          <input type="email" v-model="email" required />
        </div>
        <div>
          <label for="password">Password:</label>
          <input type="password" v-model="password" required />
        </div>
        <button type="submit">Login</button>
      </form>
      <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        email: '',
        password: '',
        errorMessage: '',
      };
    },
    methods: {
      async login() {
        try {
          // Envia a requisição POST para o endpoint de login da API Laravel
          const response = await axios.post(apiUrl, {
            email: this.email,
            password: this.password,
          });
  
          // Armazena o token de autenticação no localStorage
          localStorage.setItem('token', response.data.token);
  
          // Redireciona ou faz qualquer ação após o login bem-sucedido
          this.$router.push('/dashboard'); // Exemplo de redirecionamento para a tela de dashboard
        } catch (error) {
          this.errorMessage = 'Login falhou. Verifique suas credenciais.';
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Estilos para a tela de login */
  .login-container {
    max-width: 400px;
    margin: auto;
    padding: 2rem;
    border: 1px solid #ccc;
    border-radius: 8px;
  }
  
  .error {
    color: red;
    margin-top: 10px;
  }
  </style>
  