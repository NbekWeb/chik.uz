import { createRouter, createWebHistory } from "vue-router";

import About from '../pages/About.vue'
import Home from "../pages/Home.vue";
import Blog from "../pages/Blog.vue";
import Contact from "../pages/Contact.vue";
import SingleBlog from "../pages/SingleBlog.vue";
import Orders from "../pages/Orders.vue";
import Inquiries from "../pages/Inquiries.vue";
import Inquiry from "../pages/Inquiry.vue";
import SingleOrder from "../pages/SingleOrder.vue";
import Login from "../pages/Login.vue";
import Unauthorized from "../pages/Unauthorized.vue";
import Register from "../pages/Register.vue";
import Dashboard from "../pages/Dashboard.vue";
import Sigtn from "../pages/Sigtn.vue";
import Design from "../pages/Design.vue";
import Seo from "../pages/Seo.vue";
import Social from "../pages/Social.vue";
import Texts from "../pages/Texts.vue";
import Printing from "../pages/Printing.vue";
import Websitepromotion from "../pages/Website promotion.vue";
import Usability from "../pages/Usability.vue";
import Translates from "../pages/Translates.vue";
import Trafics from "../pages/Trafics.vue";
import Study from "../pages/Study.vue";
import Statics from "../pages/Statics.vue";
import Smm from "../pages/Smm.vue";
import Sitesetup from "../pages/Site setup.vue";
import Siteselling from "../pages/Site selling.vue";
import Sitemaking from "../pages/Site making.vue";
import Sitecontent from "../pages/Site content.vue";
import Server from "../pages/Server.vue";
import Scripts from "../pages/Scripts.vue";
import Reklame from "../pages/Reklame.vue";
import Presentations from "../pages/Presentations.vue";
import Pr from "../pages/Pr.vue";
import Mobiledesign from "../pages/Mobile design.vue";
import Marketplace from "../pages/Marketplace.vue";
import Makingtexts from "../pages/Making texts.vue";
import Logo from "../pages/Logo.vue";
import Layout from "../pages/Layout.vue";
import Intejerextejer from "../pages/Intejer Extejer.vue";
import Informatics from "../pages/Informatics.vue";
import Industrialdesign from "../pages/Industrial Design.vue";
import Games from "../pages/Games.vue";
import Emailinks from "../pages/Emailinks.vue";
import Editing from "../pages/Editing.vue";
import Desktop from "../pages/Desktop.vue";
import Databasez from "../pages/Databasez.vue";
import Cv from "../pages/Cv.vue";
import Outdooradvertising from "../pages/Outdoor advertising.vue";
import Businesstexts from "../pages/Business texts.vue";
import Art from "../pages/Art.vue";
import Application from "../pages/Application.vue";
import Development from "../pages/Development.vue";
import CreateCategories from "../pages/categories/CreateCategories.vue";
import CategoriesList from "../pages/categories/CategoriesList.vue";
import EditCategories from "../pages/categories/EditCategories.vue";
import CreatePosts from "../pages/posts/CreatePosts.vue";
import DashboardPostsList from "../pages/posts/DashboardPostsList.vue";
import EditPosts from "../pages/posts/EditPosts.vue";
import Header from "../components/Header.vue";

import Footer from "../components/Footer.vue";
import ForgotPassword from "../pages/Forgot Password.vue";

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
        path: "/orders/",
        name: "Orders",
        component: Orders,
        props: true,
        // make middleware for owner of order
    },
    {
        path: "/order/:id",
        name: "SingleOrder",
        component: SingleOrder,
        props: true,
        meta: { requiresAuth: true },
        // make middleware for owner of order
    },
    {
        path: "/inquiries",
        name: "Inquiries",
        component: Inquiries,
        props: true,
        meta: { requiresAuth: true }
    },
    {
        path: "/inquiry/:id",
        name: "Inquiry",
        component: Inquiry,
        props: true,
        meta: { requiresAuth: true }
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
        meta: { requiresGuest: true }
    },
    {
        path: "/forgot-password",
        name: "Forgot Password",
        component: ForgotPassword,
        meta: { requiresGuest: true }
    },
    {
        path: "/Unauthorized",
        name: "Unauthorized",
        component: Unauthorized,
    },
    {
        path: "/register",
        name: "Register",
        component: Register,
        meta: { requiresGuest: true }
    },
    {
        path: "/dashboard",
        name: "Dashboard",
        component: Dashboard,
        meta: { requiresAuth: true, requiresVerify: true }
    },
    {
        path: "/categories/create",
        name: "CreateCategories",
        component: CreateCategories,
        meta: { requiresAuth: true, requiresSuperUser: true },
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
        props: true
    },

    {
        path: "/posts/create",
        name: "CreatePosts",
        component: CreatePosts,
        meta: { requiresAuth: true },
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
        props: true
    },
    {
        path: "/footer",
        name: "Footer",
        component: Footer,
    },
    {
        path: "/design",
        name: "Design",
        component: Design,
    },
    {
        path: "/seo",
        name: "Seo",
        component: Seo,
    },
    {
        path: "/development",
        name: "Development",
        component: Development,
    },
    {
        path: "/texts",
        name: "Texts",
        component: Texts,
    },
    {
        path: "/social",
        name: "Social",
        component: Social,
    },
    {
        path: "/printing",
        name: "Printing",
        component: Printing,
    },
    {
        path: "/websitepromotion",
        name: "Websitepromotion",
        component: Websitepromotion,
    },
    {
        path: "/usability",
        name: "Usability",
        component: Usability,
    },
    {
        path: "/translates",
        name: "Translates",
        component: Translates,
    },
    {
        path: "/trafics",
        name: "Trafics",
        component: Trafics,
    },
    {
        path: "/study",
        name: "Study",
        component: Study,
    },
    {
        path: "/statics",
        name: "Statics",
        component: Statics,
    },
    {
        path: "/smm",
        name: "Smm",
        component: Smm,
    },
    {
        path: "/sitesetup",
        name: "Sitesetup",
        component: Sitesetup,
    },
    {
        path: "/siteselling",
        name: "Siteselling",
        component: Siteselling,
    },
    {
        path: "/sitemaking",
        name: "Sitemaking",
        component: Sitemaking,
    },
    {
        path: "/sitecontent",
        name: "Sitecontent",
        component: Sitecontent,
    },
    {
        path: "/server",
        name: "Server",
        component: Server,
    },
    {
        path: "/scripts",
        name: "Scripts",
        component: Scripts,
    },
    {
        path: "/reklame",
        name: "Reklame",
        component: Reklame,
    },
    {
        path: "/presentations",
        name: "Presentations",
        component: Presentations,
    },
    {
        path: "/pr",
        name: "Pr",
        component: Pr,
    },
    {
        path: "/mobiledesign",
        name: "Mobiledesign",
        component: Mobiledesign,
    },
    {
        path: "/marketplace",
        name: "Marketplace",
        component: Marketplace,
    },
    {
        path: "/makingtexts",
        name: "Makingtexts",
        component: Makingtexts,
    },
    {
        path: "/logo",
        name: "Logo",
        component: Logo,
    },
    {
        path: "/layout",
        name: "Layout",
        component: Layout,
    },
    {
        path: "/intejerextejer",
        name: "Intejerextejer",
        component: Intejerextejer,
    },
    {
        path: "/informatics",
        name: "Informatics",
        component: Informatics,
    },
    {
        path: "/industrialdesign",
        name: "Industrialdesign",
        component: Industrialdesign,
    },
    {
        path: "/games",
        name: "Games",
        component: Games,
    },
    {
        path: "/emaillinks",
        name: "Emailinks",
        component: Emailinks,
    },
    {
        path: "/editing",
        name: "Editing",
        component: Editing,
    },
    {
        path: "/desktop",
        name: "Desktop",
        component: Desktop,
    },
    {
        path: "/databasez",
        name: "Databasez",
        component: Databasez,
    },
    {
        path: "/cv",
        name: "Cv",
        component: Cv,
    },
    {
        path: "/outdooradvertising",
        name: "Outdooradvertising",
        component: Outdooradvertising,
    },
    {
        path: "/businesstexts",
        name: "Businesstexts",
        component: Businesstexts,
    },
    {
        path: "/art",
        name: "Art",
        component: Art,
    },
    {
        path: "/application",
        name: "Application",
        component: Application,
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});


axios
    .get("/api/user")
    .then((response) => {
        const role_id = response.data.role_id;
        localStorage.setItem("userRole", role_id);
    })



router.beforeEach((to, from, next) => {
    const authenticated = localStorage.getItem("authenticated");
    const userRole = localStorage.getItem("userRole");
    const baseUrl = window.location.origin
    if (to.meta.requiresGuest && authenticated) {
        window.location.href = `${baseUrl}/admin/dashboard`;
    } else if (to.meta.requiresAuth && !authenticated) {
        next({ name: "Login" });
    } else if (to.meta.requiresSuperUser && userRole !== '1') {
        next({ name: "Unauthorized" });
    } else if (to.meta.requiresFreelancer && userRole !== '2') {
        next({ name: "Unauthorized" });
    } else if (to.meta.requiresClient && userRole !== '3') {
        next({ name: "Unauthorized" });
    } else {
        next();
    }
});
export default router;
