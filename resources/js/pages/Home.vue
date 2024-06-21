<script setup>
import axios from "axios";
import { ref, onMounted, watch ,onUnmounted} from "vue";
import { useRouter, useRoute } from "vue-router";

const searchVal = ref("");
const searchingStart = ref(false);
const searchShow = ref(true);
const items = ref([]);
const searchRes = ref([]);
const current = ref([]);
const router = useRouter();
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

const handleClickOutside = (event) => {
    const searchContainer = document.querySelector('.search-container');
    if (searchContainer && !searchContainer.contains(event.target)) {
        searchShow.value = false;
    }
    else{
        searchShow.value = true;
    }
};


onMounted(() => {
    document.addEventListener('click', handleClickOutside);
    axios
        .get("/api/menu_list")
        .then((res) => {
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
        });
});


onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});


</script>

<template>
    <div>
        
        <div
            class="w-full home__bg xl:h-[400px] md:h-[300px] max-md:h-auto   lg:pt-20 pb-10 max-lg:pt-16"
        >
            <div class="container px-5">
                <h1
                    class="md:text-3xl font-semibold w-[600px] max-md:w-full max-md:text-xl"
                >
                    Фриланс-услуги в один клик: просто,быстро,эффективно
                </h1>
                <div class="relative w-[600px] max-md:w-full search-container">
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
                                        'rounded-b-lg': i === searchRes.length - 1,
                                    },
                                ]"
                            >
                                {{ search.label }}
                            </div>
                        </template>
                    </a-card>
                </div>
            </div>
        </div>
        
        <div>
             <a-row>
                <a-col v-for="(item,i) of items" :key="i">
                    {{ item }}
                </a-col>
             </a-row>   
        </div>
    </div>
</template>
<style lang="scss">
.home__bg {
    background-image: url("../images/larg.jpg");
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
}

@media (max-width: 767px) {
    .home__bg {
        background-image: none;
    }
}
</style>
