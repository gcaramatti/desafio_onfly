<template>
  <div class="full-height row justify-center items-center">
    <div class="form-container">
      <RegisterForm></RegisterForm>

      <router-link to="/login">Login</router-link>
    </div>
  </div>

  <router-view />
</template>

<style scoped>
.form-container {
  min-width: 600px;
  padding: 40px;
  background-color: var(--secondary);
  border-radius: 10px;
  box-shadow: 0px 2px 7px 0px var(--secondary);
}

@media screen and (max-width: 600px) {
  .form-container {
    min-width: 80%;
  }
}
</style>

<script setup>
import RegisterForm from 'src/components/RegisterForm.vue';
</script>
