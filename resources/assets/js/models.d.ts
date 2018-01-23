export interface TokenInfo {
    token?: string;
    remember?: boolean;
}

export interface User {
    email?: string;
    password?: string;
    remember?: boolean
    name?: string;
}


export interface SysState {
    token?: TokenInfo;
    user?: User;
    sidebarOpened?: boolean;
    permission_routers?: any
}