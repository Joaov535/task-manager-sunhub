<template>
  <div
    class="modal fade"
    id="addTaskModal"
    tabindex="-1"
    aria-labelledby="addTaskModal"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content p-4">
        <form @submit.prevent="sendTask">
          <div class="mb-3">
            <label for="taskTitle" class="form-label">Tarefa</label>
            <input
              type="text"
              class="form-control"
              id="taskTitle"
              placeholder="Digite o título da tarefa..."
              v-model="title"
              required
            />
          </div>
          <div class="mb-3">
            <label for="taskDescription" class="form-label">Detalhes</label>
            <textarea
              class="form-control"
              id="taskDescription"
              rows="3"
              v-model="description"
              required
            ></textarea>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              name="taskStatus"
              id="pending"
              value="pending"
              v-model="status"
              checked
            />
            <label class="form-check-label" for="pending"> Pendente </label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              name="taskStatus"
              id="underway"
              value="underway"
              v-model="status"
            />
            <label class="form-check-label" for="underway">
              Em progresso
            </label>
          </div>
          <div class="form-check">
            <input
              class="form-check-input"
              type="radio"
              name="taskStatus"
              v-model="status"
              id="finish"
              value="finish"
            />
            <label class="form-check-label" for="finish"> Concluída </label>
          </div>
          <br />
          <button class="btn btn-primary" type="submit" style="width: 100%">
            Criar
          </button>

          <div
            class="d-flex justify-content-center align-items-center mt-3"
            style="width: 100%"
          >
            <a
              class="d-flex justify-content-center align-items-center"
              data-bs-dismiss="modal"
              aria-label="Close"
              style="cursor: pointer"
              >Fechar</a
            >
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from "sweetalert2";

export default {
  data() {
    return {
      title: "",
      description: "",
      status: "pending",
    };
  },
  methods: {
    async sendTask() {

      try {
        const response = await this.$axios.post(
          "/tasks",
          {
            title: this.title,
            status: this.status,
            description: this.description,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        );

        if (response.status == 201) {
          
          this.$emit("taskAdded");

          Swal.fire({
            title: "Sucesso!",
            icon: "success",
            draggable: true,
          });
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

        this.$router.push("/");
      }
    },
  },
};
</script>