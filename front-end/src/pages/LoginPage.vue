<template>
  <LoaderComponent :is-loading="isLoading"></LoaderComponent>
  <div class="full-height row justify-center items-center">
    <div class="form-container">
      <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
        <q-input
          filled
          autocomplete="off"
          v-model="form.email"
          label="Seu email *"
          lazy-rules
          :rules="[
            (val) => (val && val.length > 0) || 'Esse campo é obrigatório',
          ]"
        />

        <q-input
          filled
          type="password"
          autocomplete="off"
          v-model="form.password"
          label="Senha *"
          lazy-rules
          :rules="[
            (val) => (val && val.length > 0) || 'Esse campo é obrigatório',
          ]"
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

      <router-link to="/register">Registrar</router-link>
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

<script>
import UserService from 'src/services/user/user';
import { useAuth } from 'src/stores/auth';
const { login } = useAuth();
import LoaderComponent from 'src/components/Loader/LoaderComponent.vue';
import { Notify } from 'quasar';

export default {
  data() {
    return {
      isLoading: false,
      form: {
        email: '',
        password: '',
      },
    };
  },
  methods: {
    async onSubmit() {
      this.isLoading = true;

      try {
        const response = await UserService.login(this.form);

        if (response) {
          localStorage.setItem('accessToken', response);

          await login();
          this.$router.push('/');
        }
      } catch (e) {
        Notify.create({
          message: 'Usuário ou senha incorretos!',
          color: 'red',
          position: 'top-right',
        });
      }

      this.isLoading = false;
    },
    onReset() {
      this.form.email = '';
      this.form.password = '';
    },
  },
  components: {
    LoaderComponent: LoaderComponent,
  },
};
</script>
