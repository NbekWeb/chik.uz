import { createRouter, createWebHistory } from "vue-router";

import About from "../pages/About.vue";
import Home from "../pages/Home.vue";
import Blog from "../pages/Blog.vue";
import Contact from "../pages/Contact.vue";
import SingleBlog from "../pages/SingleBlog.vue";
import Login from "../pages/Login.vue";
import Register from "../pages/Register.vue";
import Informatics from "../pages/Informatics.vue";
import CreateCategories from "../pages/categories/CreateCategories.vue";
import CategoriesList from "../pages/categories/CategoriesList.vue";
import EditCategories from "../pages/categories/EditCategories.vue";
import Sa1 from "../pages/posts/CreatePost.vue";
import DashboardPostsList from "../pages/posts/DashboardPostsList.vue";
import EditPosts from "../pages/posts/EditPosts.vue";
import Inquiries from "../pages/Inquiries.vue";
import Inquiry from "../pages/Inquiry.vue";
import Orders from "../pages/Orders.vue";
import SingleOrder from "../pages/SingleOrder.vue";
import Privacy from "../pages/Privacy.vue";
import Deal from "../pages/Deal.vue";
import NotFound from "../pages/NotFound.vue";

import Footer from "../components/Footer.vue";
import PostComponent from "../components/PostComponent.vue";
import AllPostsComponent from "../components/AllPostsComponent.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: Home,
    },
    {
        path: "/about",
        name: "About",
        component: About,
    },
    {
        path: "/blog",
        name: "Blog",
        component: Blog,
    },
    {
        path: "/posts/create",
        name: "CreatePosts",
        component: Sa1,
        meta: { requiresAuth: true },
    },
    {
        path: "/post",
        name: "PostComponent",
        component: PostComponent,
    },
    {
        path: "/post-all",
        name: "AllPostsComponent",
        component: AllPostsComponent,
    },
    {
        path: "/contact",
        name: "Contact",
        component: Contact,
    },
    {
        path: "/blog/:slug",
        name: "SingleBlog",
        component: SingleBlog,
        props: true,
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
        meta: { requiresGuest: true },
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
        meta: { requiresGuest: true },
    },
    {
        path: "/categories/create",
        name: "CreateCategories",
        component: CreateCategories,
        meta: { requiresAuth: true },
    },

    {
        path: "/categories",
        name: "CategoriesList",
        component: CategoriesList,
        meta: { requiresAuth: true },
    },

    {
        path: "/categories/:id/edit",
        name: "EditCategories",
        component: EditCategories,
        meta: { requiresAuth: true },
        props: true,
    },

    {
        path: "/dashboard-posts",
        name: "DashboardPostsList",
        component: DashboardPostsList,
        meta: { requiresAuth: true },
    },

    {
        path: "/posts/:slug/edit",
        name: "EditPosts",
        component: EditPosts,
        meta: { requiresAuth: true },
        props: true,
    },
    {
        path: "/footer",
        name: "Footer",
        component: Footer,
    },

    {
        path: "/informatics",
        name: "Informatics",
        component: Informatics,
    },

    {
        path: "/orders/",
        name: "Orders",
        component: Orders,
        props: true,
    },
    {
        path: "/order/:id",
        name: "SingleOrder",
        component: SingleOrder,
        props: true,
        meta: { requiresAuth: true },
    },
    {
        path: "/inquiries",
        name: "Inquiries",
        component: Inquiries,
        props: true,
        meta: { requiresAuth: true },
    },
    {
        path: "/inquiry/:id",
        name: "Inquiry",
        component: Inquiry,
        props: true,
        meta: { requiresAuth: true },
    },
    {
        path: "/privacy",
        name: "Privacy",
        component: Privacy,
    },
    {
        path: "/deal",
        name: "Deal",
        component: Deal,
    },
    {
        path: "/:pathMatch(.*)*",
        name: "NotFound",
        component: NotFound,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from) => {
    window.scrollTo(0, 0);
    const authenticated = localStorage.getItem("authenticated");

    if (to.meta.requiresGuest && authenticated) {
        window.location.href = "/admin/dashboard";
    } else if (to.meta.requiresAuth && !authenticated) {
        return {
            name: "Login",
        };
    }
});

export default router;
