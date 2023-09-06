import VueRouter from 'vue-router'
import {createRouter,createWebHashHistory} from "vue-router";

const router = VueRouter.createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: VueRouter.createWebHashHistory(import.meta.env.BASE_URL),
   routes:[
       {
           path:'/index',
           component:()=>import('../views/index.vue')
       }
   ]
})
export default router
