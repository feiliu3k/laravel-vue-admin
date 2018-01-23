

import systemModules  from './modules/sys'

export default (Vuex:any) => {
    return new Vuex.Store({
        modules:{
            system:systemModules
        }
    });
};