<script setup>
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { DownOutlined, UpOutlined } from "@ant-design/icons-vue";

import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination, Autoplay, Thumbs } from "swiper/modules";
import "swiper/swiper-bundle.css";

const thumbsSwiper = ref(null);
const openSwip = ref(false);
const slidesPerView = ref(2);

const breakpoints = ref({
    320: {
        slidesPerView: 3,
        spaceBetween: 5,
    },
    480: {
        slidesPerView: 3,
        spaceBetween: 5,
    },
    768: {
        slidesPerView: 6,
        spaceBetween: 10,
    },
    1024: {
        slidesPerView: 6,
        spaceBetween: 16,
    },
});
// Props
const props = defineProps({
    slug: {
        type: String,
        required: true,
    },
});

const setThumbsSwiper = (swiper) => {
    thumbsSwiper.value = swiper;
};

const formatPrice = (num) => {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
};

// Reactive state
const modul = ref([Navigation, Pagination, Thumbs, Autoplay]);
// Autoplay
const post = ref({});
const desc = ref(false);
const openComment = ref(false);
const relatedPosts = ref([]);
const error = ref(null);
const currentUser = ref(null);
const cash = ref("");
const buying = ref(false);
const loading = ref(true);
const shouldHideAboutText = ref(false);

// Router instance
const router = useRouter();

// Methods
const fetchData = async () => {
    try {
        const [postResponse, relatedPostsResponse, currentUserResponse] =
            await Promise.all([
                axios.get(`/api/posts/${props.slug}`),
                axios.get(`/api/related-posts/${props.slug}`),
            ]);
        post.value = postResponse.data.data;
        relatedPosts.value = relatedPostsResponse.data.data;
        currentUser.value = currentUserResponse.data;
    } catch (err) {
        console.error("Error fetching data:", err);
        error.value = "Error fetching data";
    }
};

const buyPost = async (postId) => {
    if (localStorage.getItem("authenticated")) {
        try {
            buying.value = true;
            const response = await axios.post(`/api/buy-order/${postId}`);
            const orderId = response.data.order_id;
            router.push(`/order/${orderId}`);
            loading.value = true;
        } catch (err) {
            console.error("Purchase failed:", err);
        } finally {
            loading.value = false;
            buying.value = false;
        }
    } else {
        router.push({ name: "Login" });
        console.log(localStorage.getItem("authenticated"));
    }
};
const fetchPostData = async () => {
    try {
        const response = await axios.get(`/api/posts/${props.slug}`);

        post.value = response.data.data;
        // const isCurrentUserPostAuthor = post.value.user.id === Auth.id();
        loading.value = true;
        // shouldHideAboutText.value =
        //     Auth.isLoggedIn() && isCurrentUserPostAuthor;
    } catch (err) {
        if (err.response.status == 404) {
            router.push({ name: "NotFound" });
        }
    } finally {
        loading.value = false;
    }
};

// Lifecycle hook
onMounted(() => {
    // fetchData();
    fetchPostData();
});
</script>

<template>
    <div class="container min-h-screen px-0">
        <div
            class="flex justify-between py-4 lg:flex-row max-lg:flex-col gap-x-2"
        >
            <div class="lg:w-[660px] max-lg:w-full">
                <div class="">
                    <a-spin :spinning="loading" class="flex">
                        <div class="bg-white">
                            <h3 class="p-3 text-2xl font-semibold text-black">
                                {{ post.title }}
                            </h3>
                            <Swiper
                                :slides-per-view="1"
                                spaceBetween="10"
                                :autoplay="{ delay: 2000 }"
                                :pagination="{ clickable: true }"
                                navigation
                                :thumbs="{ swiper: thumbsSwiper }"
                                :modules="modul"
                                class="object-cover w-full sm:h-[440px] max-sm:h-[300px]"
                            >
                                <SwiperSlide
                                    v-for="(image, index) in post.images"
                                    :key="index"
                                    @click="() => (openSwip = true)"
                                >
                                    <img
                                        :src="image.url"
                                        class="object-cover w-full h-full"
                                    />
                                </SwiperSlide>
                            </Swiper>
                            <a-modal
                                v-model:open="openSwip"
                                width="90%"
                                wrapClassName="chats__modal"
                            >
                                <template #closeIcon>
                                    <svg
                                        fill="#333"
                                        height="20px"
                                        width="20px"
                                        version="1.1"
                                        id="Layer_1"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        viewBox="0 0 1792 1792"
                                        xml:space="preserve"
                                    >
                                        <path
                                            d="M1082.2,896.6l410.2-410c51.5-51.5,51.5-134.6,0-186.1s-134.6-51.5-186.1,0l-410.2,410L486,300.4
	c-51.5-51.5-134.6-51.5-186.1,0s-51.5,134.6,0,186.1l410.2,410l-410.2,410c-51.5,51.5-51.5,134.6,0,186.1
	c51.6,51.5,135,51.5,186.1,0l410.2-410l410.2,410c51.5,51.5,134.6,51.5,186.1,0c51.1-51.5,51.1-134.6-0.5-186.2L1082.2,896.6z"
                                        />
                                    </svg>
                                </template>
                                <Swiper
                                    :slides-per-view="1"
                                    spaceBetween="10"
                                    :modules="[Navigation]"
                                    navigation
                                    class="object-cover w-full lg:h-[500px] max-lg:h-[400px]"
                                >
                                    <SwiperSlide
                                        v-for="(image, index) in post.images"
                                        :key="index"
                                        class="h-full"
                                    >
                                        <img
                                            :src="image.url"
                                            class="object-cover w-full h-full"
                                        />
                                        <!-- style="border:10px solid red;" -->
                                    </SwiperSlide>
                                </Swiper>
                            </a-modal>

                            <Swiper
                                :slides-per-view="slidesPerView"
                                spaceBetween="4"
                                @swiper="setThumbsSwiper"
                                watch-slides-progress
                                :modules="[Thumbs]"
                                :breakpoints="breakpoints"
                                class="w-full h-[60px] mt-2 bg-white"
                                style="background-color: #f6f6f6"
                            >
                                <SwiperSlide
                                    v-for="(image, index) in post.images"
                                    :key="index"
                                    class="opacity-30 hover:opacity-100"
                                >
                                    <img
                                        :src="image.url"
                                        class="object-cover w-full h-full"
                                    />
                                </SwiperSlide>
                            </Swiper>

                            <div v-html="post.body" class="px-3 py-2"></div>
                            <div class="flex justify-between px-3 pb-3">
                                <p class="text-xl font-bold text-black">
                                    Цена:
                                    {{ formatPrice(parseInt(post.price)) }}
                                </p>
                                <a-button
                                    @click="buyPost(post.id)"
                                    type="primary"
                                >
                                    Связаться
                                </a-button>
                            </div>
                        </div>
                    </a-spin>
                </div>

                <div class="px-3 mt-4 bg-white">
                    <div
                        class="flex items-center justify-between w-full py-3 border-b"
                        :class="openComment ? 'border-b' : 'border-b-0'"
                    >
                        <h4 class="mb-0 text-xl font-semibold">
                            Отзывы по кворку
                        </h4>
                        <DownOutlined
                            class="text-[10px] ml-1 ease-linear p-1"
                            @click="() => (openComment = !openComment)"
                            :class="openComment ? 'rotate-0' : 'rotate-180'"
                        />
                    </div>
                    <div v-show="openComment">
                        <div>sa1</div>
                    </div>
                </div>
            </div>

            <div class="max-lg:w-full xl:w-[420px] max-xl:w-[400px]">
                <div class="max-h-[600px] max-lg:w-full lg:mt-0 max-lg:mt-4">
                    <div class="flex w-full gap-3 bg-white lg:p-3 max-lg:p-2">
                        <div class="items-center md:flex max-md:hidden">
                            <img
                                src="../images/garant.svg"
                                class="w-[100px] h-[100px]"
                            />
                        </div>
                        <div class="lg:w-[200px] max-lg:w-full max-lg:p-2">
                            <h4 class="text-xl">Гарантия возврата</h4>
                            <p class="text-xs text-text__grey">
                                Средства моментально вернутся на счет, если
                                что-то пойдет не так
                            </p>
                            <div
                                class="flex items-center text-sm text-blue-600 cursor-pointer"
                                @click="() => (desc = !desc)"
                            >
                                Как это работает?
                                <DownOutlined
                                    class="text-[10px] ml-1 ease-linear"
                                    :class="desc ? 'rotate-180' : 'rotate-0'"
                                />
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white lg:p-3 max-lg:p-2"
                        :class="desc ? 'block' : 'hidden'"
                    >
                        <p class="text-xs">
                            Kwork переводит деньги продавцу, только когда
                            покупатель проверил и принял заказ.
                        </p>
                        <h4 class="text-xl font-bold">Деньги можно вернуть:</h4>
                        <ul class="text-sm list-disc">
                            <li>
                                Моментально, если заказ отменяется покупателем в
                                первые 20 мин. после старта
                            </li>
                            <li>
                                Моментально, если продавец просрочил заказ, и
                                покупатель решил отменить его
                            </li>
                            <li>
                                Моментально, если продавец и покупатель
                                согласовали отмену заказа
                            </li>
                            <li>
                                В течение нескольких часов, если заказ выполнен
                                некачественно или не полностью
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="pt-4 bg-inherit">
                    <a-spin :spinning="loading">
                        <div class="gap-2 p-3 bg-white">
                            <div class="flex items-center">
                                <img
                                    :src="
                                        post.userImage
                                            ? post.userImage
                                            : '/assets/img/avatar.png'
                                    "
                                    class="md:w-[60px] md:h-[60px] rounded-full max-md:w-[30px] max-md:h-[30px]"
                                />

                                <p class="mb-0 text-xl font-semibold">
                                    {{ post.user }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="">Репутация</span>
                                <div class="flex items-center">
                                    <p class="pr-1 m-0 text-sm">5.0</p>
                                    <img
                                        src="../images/star.png"
                                        class="w-[15px] h-[15px] object-contain"
                                    />
                                </div>
                            </div>
                        </div>
                    </a-spin>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 20px !important;
}
.dabba {
    padding: 20px !important;
}
.chats__modal .ant-modal .ant-modal-content {
    padding: 0 !important;
    /* background:transparent !important; */
    box-shadow: none !important;
}

.swiper-slide-thumb-active {
    opacity: 1 !important;
}

/* .ant-modal-content{
    height: 500px !important;
    border:1px solid red !important; 
} */
/* .ant-modal-root .ant-modal-wrap{
    overflow:hidden !important;
} */

.chats__modal .ant-modal .ant-modal-close {
    top: -40px !important;
    inset-inline-end: -40px !important;
    color: #000 !important;
}
@media (max-width: 1024px) {
    .chats__modal .ant-modal .ant-modal-close {
        inset-inline-end: -30px !important;
    }
}
@media (max-width: 768px) {
    .chats__modal .ant-modal .ant-modal-close {
        inset-inline-end: -25px !important;
    }
}
@media (max-width: 640px) {
    .chats__modal .ant-modal .ant-modal-close {
        inset-inline-end: -18px !important;
    }
}
</style>
