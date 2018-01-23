import {SysState, TokenInfo, User} from "../../models";
import {apiUser, logoutPost} from "../../services/index";
import * as Cookies from "js-cookie";


let state: SysState = {
    token: {token: Cookies.get('jm_token'), remember: false},
    user: undefined,
    sidebarOpened: Cookies.get('sidebarOpened') !== 'true',
    permission_routers: undefined
} as SysState;

export enum SysMutation {
    SAVE_TOKEN = 'SAVE_TOKEN',
    SAVE_USER = 'SAVE_USER',
    LOGOUT = 'LOGOUT',
    FETCH_USER_FAILURE = 'FETCH_USER_FAILURE',
    TOGGLE_SIDEBAR_OPENED = 'TOGGLE_SIDEBAR_OPENED',
    SAVE_PERMISSION_ROUTERS = 'SAVE_ROUTERS'
}

export enum SysAction {
    FETCH_USER = 'FETCH_USER',
    LOGOUT = 'LOGOUT'
}


const getters = {
    user: (state: SysState): User | undefined => state.user,
    authToken: (state: SysState): string | undefined => state.token ? state.token.token : undefined,
    authCheck: (state: SysState): boolean => state.user !== undefined,
    sidebarOpened: (state: SysState): boolean | undefined => state.sidebarOpened,
    permission_routers: (state: SysState): any | undefined => state.permission_routers,
};


const mutations = {
    [SysMutation.SAVE_TOKEN as string](state: SysState, token: TokenInfo): void {
        state.token = token;
        Cookies.set('jm_token', (token.token as string), {expires: (token.remember ? 365 : undefined)});
    },
    [SysMutation.SAVE_USER](state: SysState, user: User): void {
        state.user = user;
    },
    [SysMutation.LOGOUT](state: SysState) {
        state.user = undefined;
        state.token = undefined;
        Cookies.remove('jm_token');
        Cookies.remove('sidebarOpened');
    },
    [SysMutation.FETCH_USER_FAILURE](state: SysState) {
        state.token = undefined;
        Cookies.remove('jm_token');
    },
    [SysMutation.TOGGLE_SIDEBAR_OPENED](state: SysState) {
        state.sidebarOpened = !state.sidebarOpened;
        Cookies.set('sidebarOpened', state.sidebarOpened ? 'true' : 'false');
    },
    [SysMutation.SAVE_PERMISSION_ROUTERS](state: SysState,routers:any) {
       state.permission_routers = routers;
    },
};

const actions = {
    async [SysAction.FETCH_USER](store: any): Promise<void> {
        try {
            let userInfo: any = await apiUser()
            store.commit(SysMutation.SAVE_USER, userInfo)
        } catch (e) {
            store.commit(SysMutation.FETCH_USER_FAILURE)
        }
    },
    async [SysAction.LOGOUT](store: any) {
        await logoutPost()
        store.commit(SysMutation.LOGOUT)
    },


};

export default {
    state: state,
    mutations: mutations,
    actions: actions,
    getters: getters
}

