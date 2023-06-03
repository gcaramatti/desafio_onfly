<template>
  <LoaderComponent :is-loading="isLoading"></LoaderComponent>

  <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
    <q-input
      filled
      v-model="form.name"
      label="Seu nome *"
      lazy-rules
      :rules="[(val) => (val && val.length > 0) || 'Esse campo é obrigatório']"
    />
    <q-input
      filled
      v-model="form.email"
      label="Seu e-mail *"
      lazy-rules
      :rules="[(val) => (val && val.length > 0) || 'Esse campo é obrigatório']"
    />

    <q-input
      filled
      type="password"
      aria-autocomplete="none"
      v-model="form.password"
      label="Senha *"
      lazy-rules
      :rules="[(val) => (val && val.length > 0) || 'Esse campo é obrigatório']"
    />

    <q-toggle v-model="form.is_admin" label="Usuário administador?" />

    <div>
      <q-btn label="Submit" type="submit" color="primary" />
      <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
    </div>
  </q-form>
</template>

<script>
import UserService from 'src/services/user/user';
import LoaderComponent from './Loader/LoaderComponent.vue';
import { Notify } from 'quasar';

export default {
  data() {
    return {
      isLoading: false,
      form: {
        name: '',
        email: '',
        password: '',
        is_admin: false,
      },
    };
  },
  methods: {
    async onSubmit() {
      this.isLoading = true;
      try {
        await UserService.createUser(this.form);
        this.onReset();

        Notify.create({
          message: 'Usuário criado com sucesso!',
          color: 'green',
          position: 'top-right',
        });
      } catch (e) {
        Notify.create({
          message: 'Erro ao criar usuário',
          color: 'red',
          position: 'top-right',
        });
      }

      this.isLoading = false;
    },
    onReset() {
      this.form.name = '';
      this.form.email = '';
      this.form.password = '';
      this.form.is_admin = false;
    },
  },
  components: {
    LoaderComponent: LoaderComponent,
  },
};
</script>
