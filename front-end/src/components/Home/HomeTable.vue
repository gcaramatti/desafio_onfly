<template>
  <loader-component :is-loading="isLoading"></loader-component>
  <div class="q-pa-md">
    <q-markup-table>
      <thead>
        <tr>
          <th class="text-left">Número</th>
          <th class="text-right">Nome</th>
          <th class="text-right">Admin</th>
          <th class="text-right">E-mail</th>
          <th class="text-right">Ações</th>
        </tr>
      </thead>
      <tbody v-if="allUsersData">
        <tr v-for="user in allUsersData" :key="user.id">
          <td class="text-left">{{ user.id }}</td>
          <td class="text-right">{{ user.name }}</td>
          <td class="text-right">
            {{ user.is_admin ? 'Administrador' : 'Não adm' }}
          </td>
          <td class="text-right">{{ user.email }}</td>
          <td class="text-right">
            <div class="row justify-end">
              <router-link :to="'/user/' + user.id">
                <q-icon name="edit" size="sm" color="#080e1a" />
              </router-link>
              <button
                class="custom-invisible-button"
                @click="onClick(user.id)"
                v-if="userData.is_admin"
              >
                <q-icon name="delete" color="red" size="sm" />
              </button>
            </div>
          </td>
        </tr>
      </tbody>
      <div v-else>Nenhum usuario encontrado</div>
    </q-markup-table>
  </div>
</template>

<script setup lang="ts">
import { useAuth } from 'src/stores/auth';
import UserService from 'src/services/user/user';
import { useRouter } from 'vue-router';
import { Notify } from 'quasar';
import { ref, onMounted } from 'vue';
import LoaderComponent from '../Loader/LoaderComponent.vue';

const router = useRouter();
const { userData, logout } = useAuth();
const isLoading = ref(true);
const allUsersData = ref([
  {
    id: 0,
    name: '',
    email: '',
    is_admin: false,
  },
]);

async function onClick(id: number) {
  try {
    isLoading.value = true;
    await UserService.deleteUser(id);

    if (id === userData.id) {
      await logout();
      router.push('/login');
    }

    await getUsers();

    isLoading.value = false;

    Notify.create({
      message: 'Usuário apagado com sucesso!',
      color: 'green',
      position: 'top-right',
    });
  } catch (e) {
    Notify.create({
      message: 'Erro ao apagar usuário!',
      color: 'red',
      position: 'top-right',
    });
  }
}

onMounted(async () => {
  await getUsers();
});

async function getUsers() {
  isLoading.value = true;
  const response = await UserService.getAllUsers();
  allUsersData.value = response;
  isLoading.value = false;
}
</script>
