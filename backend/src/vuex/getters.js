const getters = {
    authRandomBg: state => state.authRandomBg.imageList,
    user: state => state.user,
    addRouters: state => state.permissions.addRouters
}

export default getters;