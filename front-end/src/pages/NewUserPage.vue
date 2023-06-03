<template>
  <q-page>
    <div class="q-pl-md">
      <h1>{{ userData.name }}</h1>
    </div>
    <div class="new-user-form-container">
      <h2>Registrar novo usuário</h2>

      <RegisterForm></RegisterForm>
    </div>
  </q-page>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import UserService from 'src/services/user/user';
import { useAuth } from 'src/stores/auth';
import RegisterForm from 'src/components/RegisterForm.vue';

const isLoading = ref(true);
const allUsersData = ref(undefined);
const { userData } = useAuth();

onMounted(async () => {
  const response = await UserService.getAllUsers();
  allUsersData.value = response;
  isLoading.value = false;
});
</script>

<style scoped>
.new-user-form-container {
  background-color: var(--secondary);
  padding: 40px 20px;
  margin: 0 20px;
}
</style>
