<template>
  <LoaderComponent :is-loading="isLoading"></LoaderComponent>

  <q-page>
    <div class="user-details-wrapper">
      <div class="user-details-container">
        <h2>Editar usuário: {{ userDetailsData.name }}</h2>

        <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
          <q-input
            filled
            v-model="form.name"
            label="Seu nome *"
            hint="Nome completo"
            lazy-rules
            :rules="[
              (val) => (val && val.length > 0) || 'Please type something',
            ]"
          />

          <q-input
            filled
            type="E-mail"
            aria-autocomplete="none"
            v-model="form.email"
            label="E-mail *"
            lazy-rules
            :rules="[
              (val) => (val && val.length > 0) || 'Esse campo é obrigatório',
            ]"
          />

          <q-input
            filled
            type="password"
            aria-autocomplete="none"
            v-model="form.password"
            label="Senha *"
            lazy-rules
            :rules="[
              (val) =>
                (val && val.length > 0) ||
                'Preencha com a senha atual ou uma nova',
            ]"
          />

          <q-toggle
            v-model="form.is_admin"
            :aria-checked="form.is_admin"
            label="Usuário administador?"
          />

          <div>
            <q-btn label="Submit" type="submit" color="primary" />
            <q-btn
              label="Reset"
              type="reset"
              color="primary"
              flat
              class="q-ml-sm"
            />
          </div>
        </q-form>
      </div>
    </div>
  </q-page>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import LoaderComponent from 'src/components/Loader/LoaderComponent.vue';
import UserService from 'src/services/user/user';
import { useAuth } from 'src/stores/auth';
import { Notify } from 'quasar';
import { useRouter } from 'vue-router';

const router = useRouter();
const { userData, logout } = useAuth();
const route = useRoute();

const isLoading = ref(false);
const userDetailsData = ref({
  id: 0,
  name: '',
  email: '',
  is_admin: false,
});

const form = ref({
  id: 0,
  name: '',
  email: '',
  is_admin: true,
});

onMounted(async () => {
  isLoading.value = true;

  const response = await UserService.getUserById(route.params.id);
  userDetailsData.value = response;

  form.value.id = userDetailsData.value.id;
  form.value.name = userDetailsData.value.name;
  form.value.email = userDetailsData.value.email;
  form.value.is_admin = userDetailsData.value.is_admin === 0 ? false : true;

  isLoading.value = false;
});

async function onSubmit() {
  isLoading.value = true;

  try {
    await UserService.updateUser(form.value);
    if (form.value.id === userData.id) {
      await logout();
      router.push('/login');
    }

    Notify.create({
      message: 'Usuário atualizado com sucesso!',
      color: 'green',
      position: 'top-right',
    });
  } catch (e) {
    Notify.create({
      message: 'Erro ao atualizar usuário',
      color: 'red',
      position: 'top-right',
    });
  }

  isLoading.value = false;
}
</script>

<style scoped>
.user-details-container {
  background-color: var(--secondary);
  padding: 40px;
  border-radius: 10px;
}

.user-details-wrapper {
  padding: 80px;
}
</style>
