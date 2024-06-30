<script setup>
import axios from "axios";
import { ref, onMounted, watch, onUnmounted } from "vue";
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

    searchingMenu.timeoutId = setTimeout(async () => {
        const fetchResults = async (searchingValue) => {
            try {
                const response = await axios.get(`/api/posts`, {
                    params: { search: searchingValue },
                });
                return response.data;
            } catch (error) {
                console.error("Error fetching search results:", error);
                return [];
            }
        };

        const apiResults = await fetchResults(searchVal.value);
       
        searchRes.value = apiResults.data.map((item) => ({
            key: item.slug,
            label: item.title,
        }));
        searchingStart.value = false;
    }, 500);
};
const pushToSearch = (v, k) => {
    router.push({
        name: "SingleBlog",
        params: { slug: k},
    });
    searchVal.value = "";
    currentRoute.value = [k];
};

const pushToMenu = (val) => {
    router.push({
        path: `/post-all`,
        query: {
            category: val.toLowerCase(),
        },
    });
};

const handleClickOutside = (event) => {
    const searchContainer = document.querySelector(".search-container");
    if (searchContainer && !searchContainer.contains(event.target)) {
        searchShow.value = false;
    } else {
        searchShow.value = true;
    }
};

const pushToOrder = () => {
    if (!localStorage.getItem("authenticated")) {
        router.push({ name: "Login" });
    } else {
        if (localStorage.getItem("roleId") == 3) {
            const postAll = document.getElementById("postAll");
            postAll.scrollIntoView({ behavior: "smooth", block: "start" });
        } else {
            router.push({ name: "CreatePosts" });
        }
    }
};

onMounted(() => {
    document.addEventListener("click", handleClickOutside);
    axios
        .get("/api/menu_list")
        .then((res) => {
            const menuItems = [];
            for (let i = 0; i < res.data.data.length; i++) {
                const item = {
                    label: res.data.data[i].name,
                    img: res.data.data[i].photo,
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
    document.removeEventListener("click", handleClickOutside);
});
</script>

<template>
    <div>
        <div
            class="w-full home__bg xl:h-[400px] md:h-[300px] max-md:h-auto lg:pt-20 pb-10 max-lg:pt-16"
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
        </div>

        <div class="container">
            <a-row
                :gutter="[16, 24]"
                justify="center"
                id="postAll"
                class="pt-10 pb-5"
            >
                <a-col
                    v-for="(item, i) of items"
                    :key="i"
                    class="relative"
                    :lg="6"
                    :md="8"
                    :sm="12"
                    :xs="12"
                    @click="pushToMenu(item.label)"
                >
                    <span
                        class="absolute left-0 w-full px-3 text-base font-bold text-white bottom-3"
                    >
                        {{ item.label }}
                    </span>
                    <img
                        :src="item.img"
                        alt="item.label"
                        class="object-cover w-full xl:h-[300px] max-xl:h-[160px] max-lg:h-[150px] max-md:h-[110px]"
                    />
                </a-col>
            </a-row>
        </div>

        <div
            class="w-full create_order h-[412px] flex text-center justify-center items-center"
        >
            <div class="text-white">
                <h2
                    class="font-bold max-xl:text-3xl xl:text-3xl max-lg:text-2xl"
                >
                    Закажите услуги фрилансеров прямо сейчас
                </h2>
                <p
                    class="font-semibold max-xl:text-lg xl:text-lg max-lg:text-base"
                >
                    Быстро, просто и безопасно!
                </p>
                <a-button
                    type="primary"
                    class="px-16 lg:mt-10 max-lg:mt-6"
                    @click="pushToOrder"
                    >Начать</a-button
                >
            </div>
        </div>
        <div class="pb-4 bg-white border-b">
            <div class="container">
                <h2
                    class="mb-0 text-3xl font-semibold lg:pt-4 max-lg:pt-2 max-md:text-xl"
                >
                    Chik — это потрясающе удобная фриланс платформа, которая
                    включает:
                </h2>
                <div
                    class="flex gap-3 md:mt-4 md:flex-row max-md:flex-col max-md:mt-2"
                >
                    <div>
                        <h3 class="font-bold md:text-xl max-md:text-lg">
                            Магазин фриланс услуг
                        </h3>

                        <div class="flex flex-col md:gap-y-4 max-md:gap-y-2">
                            <p class="mb-0 md:text-base max-md:text-xs">
                                Желаете сэкономить финансы, время и избежать
                                лишних стрессов? Эта экономия возможна лишь
                                тогда, когда фриланс ориентирован на конечный
                                результат. В этом аспекте Chik, как площадка,
                                обладает значительным преимуществом перед
                                другими ресурсами для поиска исполнителей.
                            </p>
                            <p class="mb-0 md:text-base max-md:text-xs">
                                Специалисты фиксируют свои услуги в виде
                                "чиков", которые доступны к приобретению всего в
                                один клик... Таким образом, работа исполнителей
                                представлена как товар, что сокращает затраты
                                времени, финансов и энергии. Это идеальное
                                решение для стандартных задач: создание сайтов,
                                различные IT услуги, Трафик, реклама, SEO и
                                других.
                            </p>
                            <p class="mb-0 md:text-base max-md:text-xs">
                                Важно отметить, что каталог и поиск услуг
                                настроены таким образом, что вы видите наилучшие
                                предложения на основе отзывов, качества работы и
                                ответственности фрилансера. Если специалист
                                предоставляет некачественные услуги, его Чики
                                падают вниз по списку, и мы не отображаем их
                                перед заказчиками. Таким образом, на Chik вы
                                взаимодействуете с высококвалифицированными
                                профессионалами, стремящимися выполнить задачи
                                на высшем уровне.
                            </p>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold md:text-xl max-md:text-lg">
                            Биржа фриланса
                        </h3>
                        <div class="flex flex-col md:gap-y-4 max-md:gap-y-2">
                            <p class="mb-0 md:text-base max-md:text-xs">
                                "Создаёте задачу, и она становится доступной для
                                тысяч фрилансеров, готовых отправить вам свои
                                предложения. Вам лишь остаётся выбрать наилучшее
                                из них и начать сотрудничество. Такой подход к
                                удалённой работе является идеальным вариантом
                                для решения крупных и уникальных заданий.
                            </p>
                            <p class="mb-0 md:text-base max-md:text-xs">
                                Одной из характерных особенностей биржи Chik
                                является качество предложений от фрилансеров.
                                Если вы когда-либо работали на других площадках
                                фриланса, то знаете, как неудобно получать
                                множество несвязанных с вашим заданием
                                предложений от исполнителей, которые даже не
                                удосужились прочитать его текст. На Chik же всё
                                иначе – благодаря особому функционалу каждый
                                фрилансер ценит каждое своё предложение. Поэтому
                                подавляющее большинство полученных предложений
                                приходит от тех, кто внимательно изучил суть
                                задачи и предлагает соответствующие решения.
                            </p>
                            <p class="mb-0 md:text-base max-md:text-xs">
                                Ещё одним важным моментом на бирже фриланса и в
                                магазине Kwork является безопасная оплата
                                заказов, проходящая через специальную систему:
                                исполнитель получает деньги только после вашего
                                одобрения результатов. В случае задержки вы
                                всегда можете вернуть денежные средства на свой
                                счёт всего в один клик."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
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

.create_order {
    background-image: url(../images/faq4.jpg);
}

@media (max-width: 767px) {
    .home__bg {
        background-image: none;
    }
}
</style>
