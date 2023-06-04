<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title> Desafio front-end Onfly </q-toolbar-title>

        <div>Quasar v{{ $q.version }}</div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      background-color="red"
    >
      <q-list>
        <q-item-label header> Essential Links </q-item-label>

        <EssentialLink
          v-for="link in essentialLinks"
          :key="link.title"
          v-bind="link"
        />
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useAuth } from 'src/stores/auth';
import EssentialLink, {
  EssentialLinkProps,
} from 'components/EssentialLink.vue';
import { useRouter } from 'vue-router';

const { logout } = useAuth();
const router = useRouter();

const essentialLinks: EssentialLinkProps[] = [
  {
    title: 'Home',
    caption: 'Ir para home',
    icon: 'home',
    link: '/',
  },
  {
    title: 'Usuário',
    caption: 'Cadastrar novo usuário',
    icon: 'people',
    link: '/new-user',
  },
  {
    title: 'Logout',
    caption: 'Desconectar',
    icon: 'login',
    onclick: () => logoutButton(),
  },
];

const leftDrawerOpen = ref(false);

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}

function logoutButton() {
  logout();
  router.push('/login');
}
</script>
