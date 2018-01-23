import axios from 'axios';

export const loginPost = (user: any) =>
    axios.post('/login', user);


export const logoutPost = () =>
    axios.post('/logout');

export const apiUser = () =>
    axios.get('/api/user');

/**
 * 权限操作区域
 * @param permission
 * @returns {Promise<any>}
 */
export const permission_save = (permission: any): Promise<any> =>
    axios.post('/api/permission_save', permission);

export const permission_list = (): Promise<any> =>
    axios.get('/api/permission_list');

export const permission_remove = (id: number): Promise<any> =>
    axios.post('/api/permission_remove/' + id.toLocaleString())

/**
 * 权限操作区域
 * @param permission
 * @returns {Promise<any>}
 */
export const user_save = (permission: any): Promise<any> =>
    axios.post('/api/user_save', permission);

export const user_list = (): Promise<any> =>
    axios.get('/api/user_list');

export const user_remove = (id: number): Promise<any> =>
    axios.post('/api/user_remove/' + id.toLocaleString())

export const role_save = (permission: any): Promise<any> =>
    axios.post('/api/role_save', permission);

export const role_list = (): Promise<any> =>
    axios.get('/api/role_list');

export const role_remove = (id: number): Promise<any> =>
    axios.post('/api/role_remove/' + id.toLocaleString())

export const category_save = (permission: any): Promise<any> =>
    axios.post('/api/category_save', permission);

export const category_list = (): Promise<any> =>
    axios.get('/api/category_list');

export const category_remove = (id: number): Promise<any> =>
    axios.post('/api/category_remove/' + id.toLocaleString())

export const pattern_save = (permission: any): Promise<any> =>
    axios.post('/api/pattern_save', permission);

export const pattern_list = (): Promise<any> =>
    axios.get('/api/pattern_list');

export const pattern_remove = (id: number): Promise<any> =>
    axios.post('/api/pattern_remove/' + id.toLocaleString())

export const pattern_all = (): Promise<any> =>
    axios.get('/api/pattern_all');

