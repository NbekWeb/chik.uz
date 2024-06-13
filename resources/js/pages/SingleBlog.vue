<template>
    <div
        class="container flex flex-wrap justify-between py-4 lg:flex-row max-lg:flex-col"
    >
        <div class="bg-white lg:w-[660px] max-lg:w-full">
            <h3 class="px-4 py-3 text-2xl font-semibold text-black">
                {{ post.title }}
            </h3>
            <Swiper
                :slides-per-view="1"
                spaceBetween="10"
                :autoplay="{ delay: 3000 }"
                :pagination="{ clickable: true }"
                navigation
                :modules="modul"
                class="object-cover w-full sm:h-[440px] max-sm:h-[300px]"
            >
                <SwiperSlide v-for="(image, index) in post.images" :key="index">
                    <img :src="image.url" class="object-cover w-full h-full" />
                </SwiperSlide>
            </Swiper>
            <div v-html="post.body" class="px-4 py-2"></div>
            <div class="flex justify-between px-4 pb-3">
                <p class="text-xl font-bold text-black">
                    Цена: {{ post.price }}
                </p>
                <a-button @click="buyPost(post.id)" type="primary">
                    Связаться
                </a-button>
            </div>
        </div>
        <div>
            <div
                class="lg:w-[335px] max-h-[500px] max-lg:w-full lg:mt-0 max-lg:mt-4"
            >
                <div class="flex w-full gap-3 p-3 bg-white">
                    <div class="items-center md:flex max-md:hidden">
                        <img
                            src="../images/garant.svg"
                            class="w-[100px] h-[100px] "
                        />
                    </div>
                    <div class="lg:w-[200px] max-lg:w-full">
                        <h4 class="text-xl">Гарантия возврата</h4>
                        <p class="text-xs text-text__grey">
                            Средства моментально вернутся на счет, если что-то
                            пойдет не так
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
                <div class="p-3 bg-white" :class="desc ? 'block' : 'hidden'">
                    <p class="text-xs">
                        Kwork переводит деньги продавцу, только когда покупатель
                        проверил и принял заказ.
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
                            Моментально, если продавец и покупатель согласовали
                            отмену заказа
                        </li>
                        <li>
                            В течение нескольких часов, если заказ выполнен
                            некачественно или не полностью
                        </li>
                    </ul>
                </div>
            </div>
            <div class="gap-2 p-3 mt-4 bg-white">
                <div class="flex items-center">
                    <img
                        :src="
                            post.userImage
                                ? post.userImage
                                : '/assets/img/avatar.png'
                        "
                        class="w-[60px] h-[60px] rounded-full"
                    />

                    <p class="text-xl font-semibold">{{ post.user }}</p>
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
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { DownOutlined, UpOutlined } from "@ant-design/icons-vue";

import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination, Autoplay } from "swiper/modules";
import "swiper/swiper-bundle.css";

// Props
const props = defineProps({
    slug: {
        type: String,
        required: true,
    },
});

// Reactive state
const modul = ref([Navigation, Pagination, Autoplay]);
const post = ref({});
const desc = ref(false);
const relatedPosts = ref([]);
const error = ref(null);
const currentUser = ref(null);
const cash = ref("");
const buying = ref(false);
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
    try {
        buying.value = true;
        const response = await axios.post(`/api/buy-order/${postId}`);
        const orderId = response.data.order_id;
        router.push(`/order/${orderId}`);

    } catch (err) {
        console.error("Purchase failed:", err);
    } finally {
        buying.value = false;
    }
};

const fetchPostData = async () => {
    try {
        const response = await axios.get(`/api/posts/${props.slug}`);
        post.value = response.data.data;

        const isCurrentUserPostAuthor = post.value.user.id === Auth.id();
        shouldHideAboutText.value =
            Auth.isLoggedIn() && isCurrentUserPostAuthor;
    } catch (err) {
        console.log(err);
    }
};

// Lifecycle hook
onMounted(() => {
    fetchData();
    fetchPostData();
});
</script>

<style>
.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 20px !important;
}
</style>
