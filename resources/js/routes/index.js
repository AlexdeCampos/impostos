const componentImport = view => () =>
    import (`../views/${view}.vue`)

import Impostos from '../views/Impostos.vue'

export default [{
        path: "/impostos",
        name: "impostos",
        component: Impostos,
    },
    {
        path: '/',
        redirect: '/impostos'
    }
];