<template>
  <div>
    <Navbar />
    <div class="d-flex justify-content-center align-items-center vh-100">
      <div
        class="card p-4 shadow-lg"
        style="max-width: 900px; margin-top: -10%; width: 90%"
      >

        <div class="container mt-4">
          <h2 class="mb-3">Lista de Tarefas</h2>

          <div class="table-responsive">
            <table class="table">
              <thead class="">
                <tr>
                  <th hidden>ID</th>
                  <th>Título</th>
                  <th>Descrição</th>
                  <th>Status</th>
                  <th>Data</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="task in tasks" :key="task.id">
                  <td hidden>{{ task.id }}</td>
                  <td>{{ task.title }}</td>
                  <td>{{ task.description }}</td>
                  <td>
                    <span>{{ task.status }}</span>
                  </td>
                  <td>{{ formatDate(task.created_at) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Components -->
    <AddTask />
    <ModalTask  @taskAdded="getTasks"/>
  </div>
</template>

<script>

import Swal from "sweetalert2";
import Navbar from "@/components/Navbar.vue";
import AddTask from "@/components/AddTask.vue";
import ModalTask from "@/components/ModalTask.vue";

export default {
  components: {
    Navbar,
    AddTask,
    ModalTask
  },
  data() {
    return {
      tasks: [],
    };
  },
  methods: {
    async getTasks() {
      try {
        const response = await this.$axios.get("/tasks", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        });

        if (response.status == 200) {
          this.tasks = response.data;
        }
      } catch (error) {
        if (error.response && error.response.status === 401) {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Sessão expirada. Faça login novamente.",
          });

          this.$router.push("/");
        }

        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: error,
        });
      }
    },

    formatDate(dateString) {
      if (!dateString) return "Data inválida";
      const date = new Date(dateString);
      return date.toLocaleDateString("pt-BR");
    },
  },
  mounted() {
    this.getTasks();
  },
};
</script>

<style>
</style>
