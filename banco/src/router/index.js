// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
const routes = [

    {
        path: "/",
        name: "root",
        component: () => import('../components/Main.vue')
    },

    {
        path: "/register",
        name: "register",
        component: () => import('../components/RegisterPage.vue')
    },

    {
        path: "/admin/:phone",
        name: "admin",
        component: () => import('../components/Admin.vue'),
        beforeEnter: (to, from, next) => {
            const isAuthenticated = localStorage.getItem('authToken');
    
            if (isAuthenticated == 'false') {
              // Redirect to the login page if not authenticated
              next('/');
            } else {
              // Continue with the navigation
              next();
            }
          },
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router