<template>
  <div>
    <Navbar />
    <div class="d-flex justify-content-center align-items-center vh-100">
      <div v-if="!tasks.length" class="text-center">
        <p class="text-muted">Nenhuma tarefa encontrada.</p>
        <br />
        <p class="text-muted">Clique no icone verde para adicionar tarefas.</p>
      </div>

      <div
        v-else
        class="card p-4 shadow-lg"
        style="max-width: 900px; margin-top: -10%; width: 90%; max-height: 70vh;"
      >
        <div class="container mt-4 overflow-y-auto">
          <h2 class="mb-3">Lista de Tarefas</h2>

          <div class="table-responsive">
            <table class="table">
              <thead class="text-center">
                <tr>
                  <th hidden>ID</th>
                  <th>Título</th>
                  <th>Descrição</th>
                  <th>Status</th>
                  <th>Data</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody class="text-center">
                <tr v-for="task in tasks" :key="task.id">
                  <td hidden>{{ task.id }}</td>
                  <td>{{ task.title }}</td>
                  <td>{{ task.description }}</td>
                  <td :class="getStatusClass(task.status)">
                    <span>{{ formatStatus(task.status) }}</span>
                  </td>
                  <td>{{ formatDate(task.created_at) }}</td>
                  <td>
                    <button
                      class="btn btn-warning btn-sm me-2"
                      data-bs-toggle="modal"
                      data-bs-target="#taskModal"
                      @click="openEditModal(task)"
                    >
                      <i class="bi bi-pencil-square"></i>
                    </button>

                    <button
                      class="btn btn-danger btn-sm"
                      @click="deleteTask(task.id)"
                    >
                      <i class="bi bi-x-circle"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Components -->
    <AddTask />
    <ModalTask
      ref="taskModal"
      @taskUpdated="getTasks()"
      @taskAdded="getTasks"
    />
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
    ModalTask,
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

        if (response.status === 200) {
          this.tasks = response.data;
        }
      } catch (error) {
        const message =
          error.response?.data?.message || "Erro ao carregar tarefas.";
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: message,
        });

        if (error.response?.status === 401) {
          localStorage.removeItem('token');
          this.$router.push("/");
        }
      }
    },

    async deleteTask(id) {
      const confirm = await Swal.fire({
        title: "Tem certeza?",
        text: "Esta ação não pode ser desfeita!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar",
      });

      if (confirm.isConfirmed) {
        try {
          const response = await this.$axios.delete(`/tasks/${id}`, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          });

          if (response.status === 200) {
            Swal.fire({
              position: "top-end",
              icon: "success",
              title: "Tarefa deletada",
              showConfirmButton: false,
              timer: 800,
            });

            this.getTasks();
          }
        } catch (error) {
          Swal.fire("Erro!", "Não foi possível excluir a tarefa.", "error");
        }
      }
    },

    openEditModal(task) {
      if (this.$refs.taskModal) {
        this.$refs.taskModal.editTask(task);
      }
    },

    formatDate(dateString) {
      if (!dateString) return "Data inválida";
      const date = new Date(dateString);
      return date.toLocaleDateString("pt-BR");
    },

    formatStatus(status) {
      const statusMap = {
        pending: "Pendente",
        underway: "Em Progresso",
        finish: "Concluída",
      };

      return statusMap[status];
    },

    getStatusClass(status) {
      return {
        "bg-success bg-gradient bg-opacity-75": status === "finish", // Verde para finalizado
        "bg-warning bg-gradient bg-opacity-75": status === "pending", // Amarelo para pendente
        "bg-primary bg-gradient bg-opacity-75": status === "underway", // Azul para em progresso
      };
    },
  },
  mounted() {
    this.getTasks();
  },
};
</script>

<style>
</style>
