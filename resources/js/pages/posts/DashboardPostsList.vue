<template>
    <div class="container">
        <div class="">
            <div class="categories-list">
                <h1>Chiki</h1>
                <!-- success message -->
                <!-- <div class="success-msg" v-if="success">
                    <i class="fa fa-check"></i>
                    Chik удалено успешно !
                </div>
                <div class="success-msg" v-if="editSuccess">
                    <i class="fa fa-check"></i>
                    Chik изменено успешно !
                </div> -->
                <div class="container">
                    <a-row
                        :gutter="[
                            { xs: 8, sm: 12, md: 16 },
                            { xs: 8, sm: 12, md: 16 },
                        ]"
                        class="w-full post-comp"
                    >
                        <a-col
                            v-for="(post, i) in posts"
                            :key="i"
                            :span="6"
                            :lg="6"
                            :md="8"
                            :sm="12"
                            :xs="24"
                            class="w-full"
                        >
                            <div class="bg-white">
                                <Swiper
                                    :slides-per-view="1"
                                    spaceBetween="10"
                                    :autoplay="{ delay: 3000 }"
                                    :pagination="{ clickable: true }"
                                    navigation
                                    :modules="modul"
                                    class="object-cover w-full h-[160px]"
                                    v-if="post.images.length != 0"
                                >
                                    <SwiperSlide
                                        v-for="(image, index) in post.images"
                                        :key="index"
                                    >
                                        <img
                                            :src="image.url"
                                            :alt="image.url"
                                            class="object-cover w-full h-full"
                                        />
                                    </SwiperSlide>
                                </Swiper>
                                <a-skeleton-image v-else class="object-cover" />
                                <div class="card-body">
                                    <p
                                        class="h-10 mx-2 mt-3 text-sm text-light__black desc__text"
                                    >
                                        {{ post.title }}
                                    </p>

                                    <br />
                                    <h6
                                        class="mb-2 mr-3 font-bold tex4t-lg text-end text-green"
                                    >
                                        {{ formatPrice(parseInt(post.price)) }}
                                        Uzs
                                    </h6>

                                    <div
                                        class="flex items-center justify-between pt-1 pb-2 mx-2 border-t"
                                    >
                                        <small class="text-muted">{{
                                            post.updated_at
                                        }}</small>
                                        <div class="flex">
                                            <router-link
                                                :to="{
                                                    name: 'EditPosts',
                                                    params: { slug: post.slug },
                                                }"
                                                class="mr-2"
                                            >
                                                <svg
                                                    width="1em"
                                                    height="1em"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
                                                    <path
                                                        d="M18 10L14 6M2.49997 21.5L5.88434 21.124C6.29783 21.078 6.50457 21.055 6.69782 20.9925C6.86926 20.937 7.03242 20.8586 7.18286 20.7594C7.35242 20.6475 7.49951 20.5005 7.7937 20.2063L21 7C22.1046 5.89543 22.1046 4.10457 21 3C19.8954 1.89543 18.1046 1.89543 17 3L3.7937 16.2063C3.49952 16.5005 3.35242 16.6475 3.24061 16.8171C3.1414 16.9676 3.06298 17.1307 3.00748 17.3022C2.94493 17.4954 2.92195 17.7021 2.87601 18.1156L2.49997 21.5Z"
                                                        stroke="#111"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                    />
                                                </svg>
                                            </router-link>
                                            <a-popconfirm
                                                title="Вы уверены, что удалите этот пост?"
                                                ok-text="Да"
                                                cancel-text="Нет"
                                                @confirm="destroy(post.slug)"
                                            >
                                                <span>
                                                    <svg
                                                        width="1em"
                                                        height="1em"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                            d="M16 6V5.2C16 4.0799 16 3.51984 15.782 3.09202C15.5903 2.71569 15.2843 2.40973 14.908 2.21799C14.4802 2 13.9201 2 12.8 2H11.2C10.0799 2 9.51984 2 9.09202 2.21799C8.71569 2.40973 8.40973 2.71569 8.21799 3.09202C8 3.51984 8 4.0799 8 5.2V6M10 11.5V16.5M14 11.5V16.5M3 6H21M19 6V17.2C19 18.8802 19 19.7202 18.673 20.362C18.3854 20.9265 17.9265 21.3854 17.362 21.673C16.7202 22 15.8802 22 14.2 22H9.8C8.11984 22 7.27976 22 6.63803 21.673C6.07354 21.3854 5.6146 20.9265 5.32698 20.362C5 19.7202 5 18.8802 5 17.2V6"
                                                            stroke="#8c093d"
                                                            stroke-width="2"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                        />
                                                    </svg>
                                                </span>
                                            </a-popconfirm>
                                        </div>
                                    </div>
                                </div>
                            </div> </a-col
                    ></a-row>
                </div>

                <div class="index-categories">
                    <router-link :to="{ name: 'CreatePosts' }">
                        Создать Chik
                        <span>&#8594;</span></router-link
                    >
                </div>
            </div>
            <div class="description"></div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination, Autoplay } from "swiper/modules";
import "swiper/swiper-bundle.css";

const modul = ref([Navigation, Pagination, Autoplay]);

const formatPrice = (num) => {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
};

const props = defineProps(["editSuccess"]);
const emit = defineEmits(["updateSidebar"]);

const posts = ref([]);
const success = ref(false);

const fetchPosts = () => {
    axios
        .get("/api/dashboard-posts")
        .then((response) => {
            posts.value = response.data.data;
        })
        .catch((error) => {
            console.log(error);
        });
};

const destroy = (slug) => {
    if (confirm("Вы уверены, что хотите удалить эту запись?")) {
        axios
            .delete(`/api/posts/${slug}`)
            .then(() => {
                fetchPosts();
                success.value = true;
                setTimeout(() => {
                    success.value = false;
                }, 2500);
            })
            .catch((error) => {
                console.log(error.response.data);
            });
    }
};

onMounted(() => {
    fetchPosts();
});
</script>

<style scoped>
.card_box {
    height: 350px;
}

.card_text {
    overflow: scroll;
    overflow-x: hidden;
    /* Hide vertical scrollbar */
}

.card_text {
    flex-grow: 1;
    overflow-y: scroll;
    /* Ensure content is scrollable */
    margin-bottom: 1rem;
    /* Adjusts space between text and footer */
    max-height: 200px;
    /* Adjust this value as needed */
    padding-right: 10px;
    /* Space for the scrollbar */
}

/* Custom Scrollbar Styling for WebKit-based browsers (Chrome, Safari) */
.card_text::-webkit-scrollbar {
    width: 8px;
    /* Width of the entire scrollbar */
}

.card_text::-webkit-scrollbar-track {
    /* background: #f1f1f1; */
    /* Color of the track */
    border-radius: 4px;
}

.card_text::-webkit-scrollbar-thumb {
    background: #888;
    /* Color of the scroll thumb */
    border-radius: 4px;
}

.card_text::-webkit-scrollbar-thumb:hover {
    background: #555;
    /* Color when hovered */
}

/* Custom Scrollbar Styling for Firefox */
.card_text {
    scrollbar-width: thin;
    /* Makes the scrollbar thinner */
    scrollbar-color: #888 #f1f1f1;
    /* Color of thumb and track */
}

.categories-list {
    flex-basis: 50%;
    min-height: 100vh;
    /* background: #fff; */
}

.categories-list h1 {
    font-weight: 300;
    padding: 50px 0 30px 0;
    text-align: center;
}

.categories-list .item {
    display: flex;
    justify-content: right;
    align-items: center;
    max-width: 300px;
    margin: 0 auto !important;
}

.categories-list .item p {
    font-size: 16px;
}

.categories-list .item p,
.categories-list .item div,
.categories-list .item {
    margin: 15px 8px;
}

.categories ul li {
    list-style: none;
    background-color: #494949;
    margin: 20px 5px;

    border-radius: 15px;
}

.categories ul {
    display: flex;
    justify-content: center;
}

.categories a {
    color: white;
    padding: 10px 20px;
    display: inline-block;
}

.create-categories a,
.index-categories a {
    all: revert;
    margin: 20px 0;
    display: inline-block;
    text-decoration: none;
}

.create-categories a span,
.index-categories a span {
    font-size: 22px;
}

.index-categories {
    text-align: center;
}

.postlist {
    display: flex;
}
</style>
