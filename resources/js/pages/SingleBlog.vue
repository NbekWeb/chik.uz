<script setup>
import { ref, onMounted, computed, reactive, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
import axios from "axios";
import { DownOutlined, UpOutlined } from "@ant-design/icons-vue";
import { message } from "ant-design-vue";
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
const formApply = ref(null);
const desc = ref(false);
const apply = ref(false);
const openComment = ref(false);
const relatedPosts = ref([]);
const error = ref(null);
const currentUser = ref(null);
const cash = ref("");
const buying = ref(false);
const loading = ref(true);
const shouldHideAboutText = ref(false);

const formState = reactive({
    msg: "",
});

const rules = reactive({
    msg: [
        {
            required: true,
            message: "Пожалуйста, введите сообщение",
            trigger: "blur",
        },
    ],
});

// Router instance
const router = useRouter();
const route = useRoute();

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
    }
};
const fetchPostData = async () => {
    try {
        const response = await axios.get(`/api/posts/${props.slug}`);
        post.value = response.data.data;
        loading.value = true;
    } catch (err) {
        if (err.response.status == 404) {
            router.push({ name: "NotFound" });
        }
    } finally {
        loading.value = false;
    }
};

const submit = () => {
    formApply.value
        .validate()
        .then(() => {
            axios
                .post(`/api/complaint`, {
                    post_id: post.value.id,
                    comment: formState.msg,
                })
                .then(() => {
                    formState.msg = "";
                    apply.value = false;
                    message.success("Отправил");
                })
                .catch((e) => {
                    apply.value = false;
                    formState.msg = "";
                    message.error(
                        "Что-то пошло не так. Пожалуйста, попробуйте еще раз позже."
                    );
                    console.log(e);
                });
        })
        .catch((e) => {
            console.log(e);
        });
};
watch(
    () => route.params.slug,
    (newSlug, oldSlug) => {
        if (newSlug !== oldSlug) {
            loading.value = true;
            openComment.value=false
            fetchPostData();
        }
    }
);
// Lifecycle hook
onMounted(() => {
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
                            <div class="flex items-center justify-between p-3">
                                <h3 class="text-2xl font-semibold text-black">
                                    {{ post.title }}
                                </h3>

                                <div class="">
                                    <a-popover>
                                        <template #content>
                                            <p class="m-0">Пожалаватся</p>
                                        </template>
                                        <span @click="() => (apply = true)">
                                            <svg
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    clip-rule="evenodd"
                                                    d="M12.8123 1.66837C12.295 1.43834 11.7044 1.43834 11.1871 1.66837C10.7876 1.84602 10.5281 2.15894 10.3475 2.41391C10.1699 2.66461 9.9798 2.99303 9.77072 3.35422L1.50357 17.6339C1.29366 17.9964 1.1029 18.3258 0.973562 18.6054C0.842112 18.8895 0.699508 19.2714 0.744957 19.7074C0.803767 20.2715 1.09931 20.7841 1.55802 21.1176C1.91252 21.3753 2.31451 21.4433 2.62627 21.4719C2.93302 21.5 3.31368 21.5 3.73257 21.5H20.2669C20.6857 21.5 21.0664 21.5 21.3732 21.4719C21.6849 21.4433 22.0869 21.3753 22.4414 21.1176C22.9001 20.7841 23.1957 20.2715 23.2545 19.7074C23.2999 19.2714 23.1573 18.8895 23.0259 18.6054C22.8966 18.3258 22.7058 17.9964 22.4959 17.6339L14.2287 3.35419C14.0197 2.99301 13.8295 2.66459 13.652 2.41391C13.4714 2.15894 13.2119 1.84602 12.8123 1.66837ZM12.9998 9C12.9998 8.44772 12.552 8 11.9998 8C11.4475 8 10.9998 8.44772 10.9998 9V13C10.9998 13.5523 11.4475 14 11.9998 14C12.552 14 12.9998 13.5523 12.9998 13V9ZM11.9998 16C11.4475 16 10.9998 16.4477 10.9998 17C10.9998 17.5523 11.4475 18 11.9998 18H12.0098C12.562 18 13.0098 17.5523 13.0098 17C13.0098 16.4477 12.562 16 12.0098 16H11.9998Z"
                                                    fill="#8c093d"
                                                />
                                            </svg>
                                        </span>
                                    </a-popover>
                                    <a-modal
                                        v-model:open="apply"
                                        title="Сообщить о некорректном контенте"
                                    >
                                        <div class="">
                                            <p class="p-3 m-0">
                                                Пожалуйста, укажите подробности,
                                                почему вы считаете этот контент
                                                некорректным или нарушающим наши
                                                правила.
                                            </p>
                                            <a-form
                                                ref="formApply"
                                                :model="formState"
                                                :rules="rules"
                                                @submit="submit"
                                            >
                                                <a-form-item
                                                    has-feedback
                                                    label="Жалоба"
                                                    name="msg"
                                                >
                                                    <a-input
                                                        v-model:value="
                                                            formState.msg
                                                        "
                                                        type="text"
                                                        autocomplete="off"
                                                        placeholder="Пожалуйста, введите вашу жалобу здесь"
                                                    />
                                                </a-form-item>
                                                <div
                                                    class="flex justify-end w-full"
                                                >
                                                    <a-button
                                                        type="primary"
                                                        @click="submit"
                                                        >Отправлять</a-button
                                                    >
                                                </div>
                                            </a-form>
                                        </div>
                                    </a-modal>
                                </div>
                            </div>

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

                <div class="mt-4 bg-white">
                    <div
                    @click="() => (openComment = !openComment)"
                        class="flex items-center justify-between w-full px-3 py-3 hover:cursor-pointer"
                    >
                        <h4 class="mb-0 text-xl font-semibold" >
                            Отзывы по чику
                        </h4>
                        <DownOutlined
                            class="text-[10px] ml-1 ease-linear p-1 text-blue-600"
                            :class="openComment ? 'rotate-180' : 'rotate-0'"
                        />
                    </div>
                    <div v-show="openComment" class="pt-2 mb-2 single_com">
                        <div
                            v-for="com of post.reviews"
                            :key="com.id"
                            class="px-3 py-2 border-t"
                            v-show="post?.reviews?.length !=0"
                        >
                            <div class="flex justify-between">
                                <div class="flex items-center gap-2">
                                    <img
                                        :src="
                                            com.user_avatar
                                                ? com.user_avatar
                                                : '/assets/img/avatar.png'
                                        "
                                        class="md:w-[40px] md:h-[40px] rounded-full max-md:w-[25px] max-md:h-[25px] object-cover "
                                    />
                                    <p class="mb-0 text-lg font-medium">
                                        {{ com.user_name }}
                                    </p>
                                </div>
                                <a-rate v-model:value="com.star" disabled />
                            </div>
                            <div>
                                <p class="pt-1 mb-0 light__black">
                                    {{ com.comment }}
                                </p>
                                <p
                                    class="pt-1 mb-0 text-xs text-end"
                                    style="color: #9f9fa3"
                                >
                                    {{
                                        new Date(
                                            com.created_at
                                        ).toLocaleDateString("en-US")
                                    }}
                                </p>
                            </div>
                        </div>
                        
                        <div v-show="post?.reviews?.length==0">
                            <a-empty description="Пака Пустой" class="empty" />
                        </div>
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

                                <p class="pl-1 mb-0 text-xl font-semibold">
                                    {{ post.user }}
                                </p>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="pt-1">Репутация</span>
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
.ant-modal .ant-modal-close:hover,
.ant-modal-close-x:hover {
    background: transparent !important;
}
.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 20px !important;
}
.single_com .ant-empty .ant-empty-image{
    height: 70px !important;
}

.single_com .ant-empty{
    padding-bottom: 10px !important;
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

.ant-popover {
    z-index: 10 !important;
}

.single_com .ant-rate {
    font-size: 14px !important;
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
