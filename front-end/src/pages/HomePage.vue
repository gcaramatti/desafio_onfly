<template>
  <q-page>
    <div class="q-pl-md">
      <h1>{{ userData.name }}</h1>
    </div>
    <HomeTable></HomeTable
  ></q-page>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import UserService from 'src/services/user/user';
import HomeTable from 'src/components/Home/HomeTable.vue';
import { useAuth } from 'src/stores/auth';

const isLoading = ref(true);
const allUsersData = ref(undefined);
const { userData } = useAuth();

onMounted(async () => {
  const response = await UserService.getAllUsers();
  allUsersData.value = response;
  isLoading.value = false;
});
</script>
