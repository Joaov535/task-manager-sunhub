<template>
  <nav
    class="navbar justify-content-between pe-5 ps-5 mb-5 bg-dark bg-gradient"
    
  >
    <a class="navbar-brand" href="">
      <img src="@/assets/logo.svg" alt="Vue" width="35" />
    </a>

    <form @submit.prevent="logout">
      <button class="btn" title="Sair" type="submit">
        <icon-logout />
      </button>
    </form>
  </nav>
</template>
  
  <script>
import IconLogout from "./icons/IconLogout.vue";

export default {
  components: { IconLogout },
  methods: {
    async logout() {
      try {
        const response = await this.$axios.get("/logout", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        });

        if (response.status == 200) {
          localStorage.removeItem("token");
          this.$router.push("/");
        }

        if (response.status == 401) {
          localStorage.removeItem("token");
          this.$router.push("/");
        }
      } catch (error) {
        console.error("Erro no logout:", error);
        this.errorMessage = error.response?.data?.message || "Logout falhou.";
      }
    },
  },
};
</script>
  
  <style>
</style>