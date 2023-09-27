import {createRouter, createWebHistory} from "vue-router";
import config from "tailwindcss/defaultConfig.js";

const router = createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [

        {
            path: '/user/login',
            component: () => import('../views/user/login.vue')
        },
        {
            path: '/user/index',
            component: () => import('../views/user/index.vue')
        },
        {
            path: '/user/following_posts',
            component: () => import('../views/user/followingPosts.vue'),
        },
        {
            path: '/user/:id',
            component: () => import('../views/user/show.vue')
        },
        {
            path: '/user/register',
            component: () => import('../views/user/register.vue')
        }, {
            path: '/user/personal',
            component: () => import('../views/user/personal.vue')
        },


    ]
})
router.beforeEach((to, from, next) => {
    let token = localStorage.getItem('x_xsrf_token')

    // axios.get('api/').catch(err=>
    // {
    //     if (err.response.status === 401)
    //         localStorage.key('x_xsrf_token')?localStorage.removeItem('x_xsrf_token'):''
    // })

    if (!token) {
        if (to.path === '/user/login' || to.path === '/user/register')
            return next()
        else
            return next({path: '/user/login'})

    }
    if ((to.path === '/user/login' || to.path === '/user/register') && token)
        return next({path: '/user/personal'})

    return next()
})
export default router
