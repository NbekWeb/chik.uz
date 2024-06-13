<template>
    <div>
        <div class="pt-3 bg-white">
            <div class="container flex items-center justify-between pb-3">
                <span class="max-md:flex md:hidden">
                    <MenuOutlined @click="() => (openMenu = true)" />
                </span>
                <router-link :to="{ name: 'Home' }">
                    <img class="w-auto h-10 max-md:h-8" src="./images/logo.svg" />
                </router-link>
                <a-input-search placeholder="Что ищем, напишите" enter-button="Найти" size="large"
                    class="w-[360px] max-md:hidden" />
                <div class="flex gap-2">
                    <router-link :to="{ name: 'Login' }" class="md:flex max-md:hidden">
                        <a-button> Вход </a-button>
                    </router-link>
                    <router-link :to="{ name: 'Login' }" class="md:hidden max-md:flex">
                        <a-button> Войти</a-button>
                    </router-link>
                    <router-link :to="{ name: 'Register' }" class="md:flex max-md:hidden">
                        <a-button type="primary"> Регистрация </a-button>
                    </router-link>
                </div>
            </div>
            <a-input-search placeholder="Что ищем, напишите" enter-button="Найти" size="large"
                class="container w-full mt-3 border-none md:hidden max-md:flex" />
            <div class="h-[45px] border-t flex items-center justify-center mb-3 max-md:hidden md:flex">
                <a-spin :spinning="loader">
                    <div class="container">
                        <a-menu v-model:selectedKeys="current" mode="horizontal" :items="items" @click="pushToMenu"
                            style="justify-content: space-between !important;" />
                    </div>
                </a-spin>
            </div>

            <div v-if="openMenu" class="menu-backdrop" @click="() => (openMenu = false)"></div>
            <div :class="['menu-container', { open: openMenu }]">
                <div class="p-4">
                    <div class="flex items-center gap-10 mb-4">
                        <CloseOutlined @click="() => (openMenu = false)" />
                        <img class="w-auto h-5" src="./images/logo.svg" />
                    </div>
                    <scrollbar-component height="calc(100vh - 155px)">
                        <template #content>
                            <a-menu id="menu" v-model:selectedKeys="current" mode="inline" :items="items" class="w-full"
                                @click="pushToMenu" />
                        </template>
                    </scrollbar-component>
                </div>
            </div>
        </div>

        <div class="mt-3" style="background-color: #f6f6f6">
            <router-view></router-view>
        </div>

        <div class="footer">
            <div class="heading">
                <h2>Chik<sup>™</sup></h2>
            </div>
            <div class="content">
                <div class="details">
                    <h4 class="mail">Email</h4>
                    <p><a href="#">info@chik.uz</a></p>
                </div>
                <div class="services">
                    <p>
                        <a href=""><router-link :to="{ name: 'Design' }">Дизайн</router-link></a>
                    </p>
                    <p>
                        <a><router-link :to="{ name: 'Development' }">Разработка и IT</router-link></a>
                    </p>
                    <p>
                        <a><router-link :to="{ name: 'Texts' }">Тексты и Переводы</router-link></a>
                    </p>
                    <p>
                        <a><router-link :to="{ name: 'Seo' }">SEO и трафик</router-link></a>
                    </p>
                </div>
                <div class="services">
                    <p>
                        <a><router-link :to="{ name: 'Social' }">Соцсети и реклама</router-link></a>
                    </p>
                    <p>
                        <a><router-link :to="{ name: 'Home' }">Фрилансеру</router-link></a>
                    </p>
                    <p>
                        <a><router-link :to="{ name: 'Home' }">Покупателям</router-link></a>
                    </p>
                    <p>
                        <a><router-link :to="{ name: 'Statics' }">Статистика и аналитика</router-link></a>
                    </p>
                </div>
                <div class="footerlinks">
                    <p>
                        <a><router-link :to="{ name: 'Privacy' }">Политика конфиденциальности PRIVACY</router-link></a>
                    </p>
                    <p>
                        <a href="#"><router-link :to="{ name: 'About' }">About Chik</router-link></a>
                    </p>
                    <p>
                        <a href="#"><router-link :to="{ name: 'Deal' }">Пользовательское соглашение</router-link></a>
                    </p>
                    <p>
                        <a href="#"><router-link :to="{ name: 'Contact' }">Способы оплаты</router-link></a>
                    </p>
                </div>
            </div>
        </div>
        <footer>
            <hr />
            © 2024 Chik Freelance Uzbekistan
        </footer>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { MenuOutlined, CloseOutlined } from "@ant-design/icons-vue";
import ScrollbarComponent from "./components/ScrollbarComponent.vue";
import axios from "axios";

const overlayVisibility = ref(false);
const loggedIn = ref(false);
const editSuccess = ref(false);
const userRole = ref(null);
const router = useRouter();

const logout = () => {
    axios
        .post("/api/logout")
        .then(() => {
            router.push({ name: "Home" });
            localStorage.removeItem("authenticated");
            updateSidebar();
            loggedIn.value = false;
        })
        .catch((error) => console.log(error));
};

const showOverlay = () => {
    overlayVisibility.value = true;
};
const openMenu = ref(false);

const hideOverlay = () => {
    overlayVisibility.value = false;
};

const updateSidebar = () => {
    loggedIn.value = !loggedIn.value;
};

const showEditSuccess = () => {
    editSuccess.value = true;
};

const pushToMenu = (val) => {
    console.log(val.item.originItemValue.label);
    router.push({
        path: `/post`,
        query: {
            category: val.item.originItemValue.label,
        },
    });
    openMenu.value = false;
};

const setUserRole = (role_id) => {
    userRole.value = role_id;
};
const current = ref(["SMM"]);
const items = ref([]);

const loader = ref(true);

onMounted(() => {
    //  axios
    //     .get("https://chik.uz/api/user")
    //     .then((response) => {
    //       setUserRole(response.data.role_id);
    //       router.push('admin/dashboard')
    //       console.log('sa')
    //       // loader.value = true;
    //     })
    //     .catch((error) => {
    //       if (error.response && error.response.status === 401) {
    //         updateSidebar();
    //         localStorage.removeItem("authenticated");
    //         router.push({ name: "Login" });
    //       }
    //     });

    //   if (localStorage.getItem("authenticated")) {
    //     loggedIn.value = true;
    //   } else {
    //     loggedIn.value = false;
    //   }
    axios
        .get("/api/menu_list")
        .then((res) => {
            loader.value = true;
            const menuItems = [];
            for (let i = 0; i < res.data.data.length; i++) {
                const item = {
                    label: res.data.data[i].name,
                    key: res.data.data[i].url_link,
                    children: [],
                };
                if (res.data.data[i].submenu && res.data.data[i].submenu.length > 0) {
                    item.children.push({
                        label: "Общий",
                        key: res.data.data[i].url_link,
                    });
                    for (let j = 0; j < res.data.data[i].submenu.length; j++) {
                        item.children.push({
                            label: res.data.data[i].submenu[j].name,
                            key: res.data.data[i].submenu[j].url_link,
                        });
                    }
                }
                menuItems.unshift(item);
            }
            items.value = menuItems;
            console.log(items);
        })
        .catch((error) => {
            console.error("Error fetching menu list:", error);
        })
        .finally(() => {
            loader.value = false;
        });
});
</script>

<style>
.ant-menu::before,
.ant-menu::after {
    display: none !important;
}

.ant-menu-overflow-item ::after {
    display: none !important;
}

.menu-container {
    position: fixed;
    top: 0;
    left: -100%;
    width: 80%;
    height: 100%;
    background-color: white;
    transition: left 0.5s ease;
    z-index: 10;
}

.menu-container.open {
    left: 0;
}

.menu-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9;
}

.ant-menu-horizontal {
    border: none !important;
}

.ant-spin-nested-loading {
    width: 100% !important;
}
</style>