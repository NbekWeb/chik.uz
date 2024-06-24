<template>
    <div class="container min-h-screen px-0">
        <div class="flex justify-between py-4 lg:flex-row max-lg:flex-col gap-x-2">
            <div class="lg:w-[660px] max-lg:w-full">
                <a-spin :spinning="loading" class="flex">
                    <div class="bg-white">
                        <h3 class="px-4 py-3 text-2xl font-semibold text-black">
                            {{ post.title }}
                        </h3>
                        <Swiper
                            :slides-per-view="1"
                            spaceBetween="10"
                            :autoplay="{ delay: 30000 }"
                            :pagination="{ clickable: true }"
                            navigation
                            :thumbs="{ swiper: thumbsSwiper }"
                            :modules="modul"
                            class="object-cover w-full sm:h-[440px] max-sm:h-[300px]"
                        >
                            <SwiperSlide
                                v-for="(image, index) in post.images"
                                :key="index"
                            >
                                <img
                                    :src="image.url"
                                    class="object-cover w-full h-full"
                                />
                            </SwiperSlide>
                        </Swiper>
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
                            >
                                <img
                                    :src="image.url"
                                    class="object-cover w-full h-full"
                                />
                            </SwiperSlide>
                        </Swiper>
                        <div v-html="post.body" class="px-4 py-2"></div>
                        <div class="flex justify-between px-4 pb-3">
                            <p class="text-xl font-bold text-black">
                                Цена: {{ formatPrice(parseInt(post.price)) }}
                            </p>
                            <a-button @click="buyPost(post.id)" type="primary">
                                Связаться
                            </a-button>
                        </div>
                    </div>
                </a-spin>
            </div>
            <div class="max-lg:w-full xl:w-[420px] max-xl:w-[400px] ">
                <div class="max-h-[600px] max-lg:w-full lg:mt-0 max-lg:mt-4">
                    <div class="flex w-full gap-3 bg-white lg:p-3 max-lg:p-2">
                        <div class="items-center md:flex max-md:hidden">
                            <img
                                src="../images/garant.svg"
                                class="w-[100px] h-[100px]"
                            />
                        </div>
                        <div class="lg:w-[200px] max-lg:w-full">
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

                                <p class="text-xl font-semibold mb-0">
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

<script setup>
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { DownOutlined, UpOutlined } from "@ant-design/icons-vue";

import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination, Autoplay, Thumbs } from "swiper/modules";
import "swiper/swiper-bundle.css";

const thumbsSwiper = ref(null);
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
const modul = ref([Navigation, Pagination, Autoplay, Thumbs]);
const post = ref({});
const desc = ref(false);
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
        console.log(err);
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

<style>
.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 20px !important;
}
.dabba {
    padding: 20px !important;
}
</style>
