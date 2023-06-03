export interface ILoginForm {
  email: string;
  password: string;
}

export interface ICreateNewUserParams {
  name: string;
  email: string;
  password: string;
  is_admin: boolean;
}

export interface IUpdateNewUserParams {
  id: number;
  name: string;
  email: string;
  password: string;
  is_admin: boolean;
}

export interface IUser {
  id: number;
  name: string;
  email: string;
  is_admin: boolean;
}
