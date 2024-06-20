<template>
    <div>
        <div class="pt-3 bg-white">
            <div class="container flex items-center justify-between pb-3">
                <span class="max-md:flex md:hidden">
                    <MenuOutlined @click="() => (openMenu = true)" />
                </span>
                <router-link :to="{ name: 'Home' }">
                    <img
                        class="w-auto h-10 max-md:h-8"
                        src="./images/logo.svg"
                    />
                </router-link>
                <div class="relative w-[360px] max-md:hidden search-container-app">
                    <a-input-search
                        placeholder="Что ищем, напишите"
                        enter-button="Найти"
                        size="large"
                        class="w-full"
                        v-model:value="searchVal"
                        @keyup="searchingMenu"
                    />
                    <a-card
                        class="absolute z-10 w-full bg-white top-[50px]"
                        v-if="searchVal && searchShow"
                    >
                        <template v-if="searchRes.length == 0">
                            <a-spin size="small" :spinning="searchingStart">
                                <p
                                    class="px-2 py-2 m-0 rounded-lg"
                                    style="background: #f6f6f6"
                                >
                                    Не найдено
                                </p>
                            </a-spin>
                        </template>
                        <template v-else>
                            <div
                                class="flex gap-2 px-2 py-1 m-0 rounded-t-lg"
                                style="background: #f6f6f6"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="20"
                                    height="20"
                                    fill="none"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M12.5 10.625c0 .345.28.625.625.625s.625-.28.625-.625V5a3.75 3.75 0 1 0-7.5 0v1.25H5A1.25 1.25 0 0 0 3.75 7.5v10A1.25 1.25 0 0 0 5 18.75h10a1.25 1.25 0 0 0 1.25-1.25v-10A1.25 1.25 0 0 0 15 6.25h-.375v4.625a1.25 1.25 0 0 1-1.25 1.25H12.5v-1.5zm0-4.375V5a2.5 2.5 0 1 0-5 0v5.625c0 .345-.28.625-.625.625s-.625-.28-.625-.625v1.5h.875a1.25 1.25 0 0 0 1.25-1.25V6.25H12.5z"
                                        fill="#a5a5a5"
                                    ></path>
                                </svg>
                                Услуги
                            </div>
                            <div
                                v-for="(search, i) of searchRes"
                                :key="i"
                                @click="pushToSearch(search.label, search.key)"
                                :class="[
                                    'px-2 py-1 m-0 cursor-pointer hover:text-red-900 hover:bg-red-50',
                                    {
                                        'rounded-b-lg':
                                            i === searchRes.length - 1,
                                    },
                                ]"
                            >
                                {{ search.label }}
                            </div>
                        </template>
                    </a-card>
                </div>
                <div class="flex gap-2">
                    <router-link
                        :to="{ name: 'Login' }"
                        class="md:flex max-md:hidden"
                        v-if="!loggedIn"
                    >
                        <a-button> Вход </a-button>
                    </router-link>
                    <router-link
                        :to="{ name: 'Login' }"
                        class="md:hidden max-md:flex"
                        v-if="!loggedIn"
                    >
                        <a-button> Войти</a-button>
                    </router-link>
                    <router-link
                        :to="{ name: 'Register' }"
                        class="md:flex max-md:hidden"
                        v-if="!loggedIn"
                    >
                        <a-button type="primary"> Регистрация </a-button>
                    </router-link>
                    <a-popover
                        v-model:open="visible"
                        trigger="click"
                        v-if="loggedIn"
                    >
                        <template #content>
                            <div class="flex flex-col gap-y-2">
                                <a href="/admin/dashboard">
                                    <a-button type="link"> Профил </a-button>
                                </a>
                                <a-button danger @click="logout"
                                    >Выйти</a-button
                                >
                            </div>
                        </template>
                        <a-button type="primary">Профил</a-button>
                    </a-popover>
                </div>
            </div>
            <div class="container md:hidden max-md:flex search-container-app" v-if="homePage">
                <div class="relative w-full mt-3">
                    <a-input-search
                        placeholder="Что ищем, напишите"
                        enter-button="Найти"
                        size="large"
                        class="w-full m-0 border-none"
                        v-model:value="searchVal"
                        @keyup="searchingMenu"
                    />

                   
                    <a-card
                        class="absolute z-10 w-full bg-white top-[50px]"
                        v-if="searchVal && searchShow"
                    >
                        <template v-if="searchRes.length == 0">
                            <a-spin size="small" :spinning="searchingStart">
                                <p
                                    class="px-2 py-2 m-0 rounded-lg"
                                    style="background: #f6f6f6"
                                >
                                    Не найдено
                                </p>
                            </a-spin>
                        </template>
                        <template v-else>
                            <div
                                class="flex gap-2 px-2 py-1 m-0 rounded-t-lg"
                                style="background: #f6f6f6"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="20"
                                    height="20"
                                    fill="none"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M12.5 10.625c0 .345.28.625.625.625s.625-.28.625-.625V5a3.75 3.75 0 1 0-7.5 0v1.25H5A1.25 1.25 0 0 0 3.75 7.5v10A1.25 1.25 0 0 0 5 18.75h10a1.25 1.25 0 0 0 1.25-1.25v-10A1.25 1.25 0 0 0 15 6.25h-.375v4.625a1.25 1.25 0 0 1-1.25 1.25H12.5v-1.5zm0-4.375V5a2.5 2.5 0 1 0-5 0v5.625c0 .345-.28.625-.625.625s-.625-.28-.625-.625v1.5h.875a1.25 1.25 0 0 0 1.25-1.25V6.25H12.5z"
                                        fill="#a5a5a5"
                                    ></path>
                                </svg>
                                Услуги
                            </div>
                            <div
                                v-for="(search, i) of searchRes"
                                :key="i"
                                @click="pushToSearch(search.label, search.key)"
                                :class="[
                                    'px-2 py-1 m-0 cursor-pointer hover:text-red-900 hover:bg-red-50',
                                    {
                                        'rounded-b-lg':
                                            i === searchRes.length - 1,
                                    },
                                ]"
                            >
                                {{ search.label }}
                            </div>
                        </template>
                    </a-card>
                </div>
            </div>

            <div
                class="h-[45px] border-t flex items-center justify-center mb-3 max-md:hidden md:flex pt-1"
            >
                <a-spin :spinning="loader">
                    <div class="container">
                        <a-menu
                            v-model:selectedKeys="current"
                            mode="horizontal"
                            :items="items"
                            @click="pushToMenu"
                            style="justify-content: space-between !important"
                        />
                    </div>
                </a-spin>
            </div>

            <div
                v-if="openMenu"
                class="menu-backdrop"
                @click="() => (openMenu = false)"
            ></div>
            <div :class="['menu-container', { open: openMenu }]">
                <div class="p-4">
                    <div class="flex items-center gap-10 mb-4">
                        <CloseOutlined @click="() => (openMenu = false)" />
                        <img class="w-auto h-5" src="./images/logo.svg" />
                    </div>
                    <scrollbar-component height="calc(100vh - 155px)">
                        <template #content>
                            <a-menu
                                id="menu"
                                v-model:selectedKeys="current"
                                mode="inline"
                                :items="items"
                                class="w-full"
                                @click="pushToMenu"
                            />
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
                        <a href=""
                            ><router-link :to="{ name: 'Design' }"
                                >Дизайн</router-link
                            ></a
                        >
                    </p>
                    <p>
                        <a
                            ><router-link :to="{ name: 'Development' }"
                                >Разработка и IT</router-link
                            ></a
                        >
                    </p>
                    <p>
                        <a
                            ><router-link :to="{ name: 'Texts' }"
                                >Тексты и Переводы</router-link
                            ></a
                        >
                    </p>
                    <p>
                        <a
                            ><router-link :to="{ name: 'Seo' }"
                                >SEO и трафик</router-link
                            ></a
                        >
                    </p>
                </div>
                <div class="services">
                    <p>
                        <a
                            ><router-link :to="{ name: 'Social' }"
                                >Соцсети и реклама</router-link
                            ></a
                        >
                    </p>
                    <p>
                        <a
                            ><router-link :to="{ name: 'Home' }"
                                >Фрилансеру</router-link
                            ></a
                        >
                    </p>
                    <p>
                        <a
                            ><router-link :to="{ name: 'Home' }"
                                >Покупателям</router-link
                            ></a
                        >
                    </p>
                    <p>
                        <a
                            ><router-link :to="{ name: 'Statics' }"
                                >Статистика и аналитика</router-link
                            ></a
                        >
                    </p>
                </div>
                <div class="footerlinks">
                    <p>
                        <a
                            ><router-link :to="{ name: 'Privacy' }"
                                >Политика конфиденциальности
                                PRIVACY</router-link
                            ></a
                        >
                    </p>
                    <p>
                        <a href="#"
                            ><router-link :to="{ name: 'About' }"
                                >About Chik</router-link
                            ></a
                        >
                    </p>
                    <p>
                        <a href="#"
                            ><router-link :to="{ name: 'Deal' }"
                                >Пользовательское соглашение</router-link
                            ></a
                        >
                    </p>
                    <p>
                        <a href="#"
                            ><router-link :to="{ name: 'Contact' }"
                                >Способы оплаты</router-link
                            ></a
                        >
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
import { ref, onMounted, watch,onUnmounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import { MenuOutlined, CloseOutlined } from "@ant-design/icons-vue";
import ScrollbarComponent from "./components/ScrollbarComponent.vue";
import axios from "axios";

const overlayVisibility = ref(false);
const loggedIn = ref(false);
const editSuccess = ref(false);
const visible = ref(false);
const userRole = ref(null);
const searchVal = ref("");
const searchingStart = ref(false);
const searchShow = ref(true);
const searchRes = ref([]);
const router = useRouter();
const route = useRoute();

const homePage = ref(false);

const logout = () => {
    axios
        .post("/logout")
        .then(() => {
            router.push({ name: "Home" });
            localStorage.removeItem("authenticated");
            loggedIn.value = false;
            visible.value = false;
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

const pushToSearch = (v, k) => {
    router.push({
        path: `/post`,
        query: {
            category: v.toLowerCase(),
        },
    });
    searchVal.value = "";
    current.value = [k];
};
const showEditSuccess = () => {
    editSuccess.value = true;
};

const pushToMenu = (val) => {
    router.push({
        path: `/post`,
        query: {
            category: val.item.originItemValue.label.toLowerCase(),
        },
    });
    openMenu.value = false;
};
const searchingMenu = () => {
    searchingStart.value = true;

    clearTimeout(searchingMenu.timeoutId);

    searchingMenu.timeoutId = setTimeout(() => {
        const result = [];

        items.value.forEach((item) => {
            if (
                item.label
                    .toLowerCase()
                    .startsWith(searchVal.value.toLowerCase()) &&
                searchVal.value !== ""
            ) {
                result.push({ key: item.key, label: item.label });
            }

            if (item.children) {
                item.children.forEach((child) => {
                    if (
                        child.label
                            .toLowerCase()
                            .startsWith(searchVal.value.toLowerCase()) &&
                        searchVal.value !== ""
                    ) {
                        result.push({ key: child.key, label: child.label });
                    }
                });
            }
        });

        searchRes.value = result;
        searchingStart.value = false;
    }, 500);
};
const setUserRole = (role_id) => {
    userRole.value = role_id;
};
const current = ref(["SMM"]);
const items = ref([]);

const loader = ref(true);
watch(
    () => route.path,
    (newPath) => {
        if (newPath !== "/post") {
            current.value = ["Трафик"];
        }
    }
);
watch(
    () => route.name,
    (newName) => {
        if (newName == "Home") {
            homePage.value = false;
        } else {
            homePage.value = true;
        }
    },
    { immediate: true }
);

const handleClickOutsideApp = (event) => {
    const searchContainers = document.querySelectorAll(".search-container-app");
    let isClickInside = false;
    
    searchContainers.forEach(container => {
        if (container.contains(event.target)) {
            isClickInside = true;
        }
    });

    searchShow.value = isClickInside;
};

onMounted(() => {
    document.addEventListener("click", handleClickOutsideApp);
    axios
        .get("/api/user")
        .then((response) => {
            setUserRole(response.data.role_id);
        })
        .catch((error) => {
            if (error.response && error.response.status === 401) {
                localStorage.removeItem("authenticated");
            }
        });

    if (localStorage.getItem("authenticated")) {
        loggedIn.value = true;
    } else {
        loggedIn.value = false;
    }
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
                if (
                    res.data.data[i].submenu &&
                    res.data.data[i].submenu.length > 0
                ) {
                    item.children.push({
                        label: "Oбщий",
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
        })
        .catch((error) => {
            console.error("Error fetching menu list:", error);
        })
        .finally(() => {
            loader.value = false;
        });
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutsideApp);
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

.ant-card .ant-card-body {
    padding: 5px 10px !important;
}

/* .ant-menu-light .ant-menu-submenu-selected >.ant-menu-submenu-title{
    color:#000e00 !important;
} */
/* .ant-menu-light.ant-menu-horizontal >.ant-menu-submenu-selected::after{
    border-bottom-color:transparent !important;
} */
</style>
