import { api } from 'src/boot/axios';
import {
  ICreateNewUserParams,
  ILoginForm,
  IUpdateNewUserParams,
  IUser,
} from './user.types';

class UserService {
  async login(payload: ILoginForm) {
    const { data } = await api.post('/login', payload);

    return data.token;
  }

  async logout() {
    const { data } = await api.get('/logout', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
      },
    });

    return data;
  }

  async oauthUser(): Promise<IUser> {
    const { data } = await api.get('/oauth', {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
      },
    });

    data.data.is_admin === 1
      ? (data.data.is_admin = true)
      : (data.data.is_admin = false);

    return data.data;
  }

  async getUserById(id: number): Promise<IUser> {
    const { data } = await api.get(`/users/${id}`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
      },
    });

    return data.data[0];
  }

  async getAllUsers() {
    const response = await api.get('/users');

    return response.data.data;
  }

  async createUser(payload: ICreateNewUserParams) {
    const { data } = await api.post('/users', payload);

    return data;
  }

  async updateUser(payload: IUpdateNewUserParams) {
    const { data } = await api.put(`/users/${payload.id}`, payload);

    return data;
  }

  async deleteUser(id: number) {
    const { data } = await api.delete(`/users/${id}`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('accessToken')}`,
      },
    });

    return data;
  }
}

export default new UserService();
