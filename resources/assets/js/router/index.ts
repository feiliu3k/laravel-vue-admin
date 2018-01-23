import Router, {Route} from 'vue-router';
import authGuardList from './AuthGuard'
import guestGuardList from "./GuestGuard";
import {PositionResult} from "vue-router/types/router";
import {SysMutation} from "../store/modules/sys";


/**
 * @param  {Route} to
 * @param  {Route} from
 * @param  {Object|undefined} savedPosition
 * @return {Object}
 */
function scrollBehavior(to: Route, from: Route, savedPosition: any): PositionResult {
    if (savedPosition) {
        return savedPosition;
    }

    const position: any = {};

    if (to.hash) {
        position.selector = to.hash;
    }

    if (to.matched.some((m: any) => m.meta.scrollToTop)) {
        position.x = 0;
        position.y = 0;
    }

    return position;
};

/**
 * @param  {Array} routes
 * @param  {Function} guard
 * @return {Array}
 */
function guard(routes: any[], guard: any) {
    routes.forEach(route => {
        route.beforeEnter = guard;
    });
    return routes;
}

/**
 * Add the "authenticated" guard.
 *
 * @param  {Array} routes
 * @return {Array}
 */
export function authGuard(routes: any, store: any) {
    return guard(routes, (to: any, from: any, next: any) => {
        if (store.getters.authCheck) {
            next();
        } else {
            next('/Login');
        }
    });
};

function guestGuard(routes: any, store: any) {
    return guard(routes, (to: any, from: any, next: any) => {
        if (store.getters.authCheck) {
            next('/');
        } else {
            next();
        }
    });
};

function makeRouter(routes: any, store: any) {
    const router = new Router({
        routes,
        scrollBehavior
    });

    router.beforeEach((to: Route, from: Route, next: any) => {
        const components = router.getMatchedComponents({...to});
        if (components.length) {
            setTimeout(() => {
                if ((components[0] as any).loading !== false) {
                    router.app.$loadingBar.start();
                }
            }, 0);
        }
        if (!store.getters.authCheck && store.getters.authToken) {
            store.dispatch('FETCH_USER').then(() => {
                next()
            });
        } else {
            next();
        }
    });
    router.afterEach((to, from) => {
        setTimeout(() => router.app.$loadingBar.finish(), 0);
    });

    return router;
};


export default (store: any) => {
    let adminList: any = authGuard(authGuardList, store);
    let permissionList: any = [...adminList[0].children]
    store.commit(SysMutation.SAVE_PERMISSION_ROUTERS, permissionList);
    const routerData = [
        ...adminList,
        ...guestGuard(guestGuardList, store)
    ];
    return makeRouter(routerData, store)
}