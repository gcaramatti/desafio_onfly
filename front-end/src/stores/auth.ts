import { defineStore } from 'pinia';
import UserService from 'src/services/user/user';

export const useAuth = defineStore('useAuth', {
  state: () => ({
    userData: {
      id: 0,
      name: '',
      email: '',
      is_admin: false,
    },
    isLoggedIn: false,
  }),
  actions: {
    async login() {
      const user = await UserService.oauthUser();
      this.userData = user;
      this.isLoggedIn = true;
    },
    async logout() {
      await UserService.logout();
      localStorage.removeItem('accessToken');
      this.isLoggedIn = false;
    },
  },
});
