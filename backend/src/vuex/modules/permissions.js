import { basicRouterMap, dynamicRouterMap } from "../../routers"

function hasPermission(permissions, router) {
    return permissions.some(permission => {
        return `/${permission.resource}` == router.path;
    });
}

const permissions = {
    state: {
        routers: basicRouterMap,
        addRouters: []
    },
    mutations: {
        SET_ROUTERS: (state, routers) => {
            state.addRouters = routers;
            state.routers = basicRouterMap.concat(routers);
        }
    },
    actions: {
        GenerateRoutes({ commit }, user) {
            return new Promise(resolve => {
                let accessedRouters = '';
                if (user.role === 'superuser') {
                    accessedRouters = dynamicRouterMap;
                } else {
                    accessedRouters = dynamicRouterMap.filter(v => {
                        if (hasPermission(user.permissions, v)) {
                            return v;
                        } else {
                            return false;
                        }
                    })
                }
                commit('SET_ROUTERS', accessedRouters);
                resolve();
            })
        }
    }
}

export default permissions;