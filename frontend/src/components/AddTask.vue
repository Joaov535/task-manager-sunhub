<template>
  <button
    class="btn btn-success floating-button fw-bold"
    data-bs-toggle="modal"
    data-bs-target="#addTaskModal"
    @click="handleClick"
  >
    <IconPlus />
  </button>
</template>

<script>
import IconPlus from './icons/IconPlus.vue';

export default {
  components: {
    IconPlus
  },
}
</script>

<style scoped>
.floating-button {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 1000;
  border-radius: 50px;
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
}

.floating-button i {
  font-size: 24px;
}
</style>
