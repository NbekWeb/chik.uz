<script setup>
import { ref, onMounted, watch } from "vue";
import { useRoute ,useRouter} from "vue-router";
import axios from "axios";

import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination, Autoplay } from "swiper/modules";
import "swiper/swiper-bundle.css";

const posts = ref([]);
const totalPages = ref(0);
const current = ref(1);
const pagination = ref({});
const categories = ref([]);
const loading = ref();
const route = useRoute();
const router = useRouter();

const modul = ref([Navigation, Pagination, Autoplay]);

watch(
    () => route.query.category,
    () => {
        current.value = 1;
    }
);

const filterByCategory = (name, page = 1) => {
    loading.value = true;
    axios
        .get("/api/posts", {
            params: { category: name.toLowerCase(), page: page },
        })
        .then((response) => {
            posts.value = response.data.data;
            totalPages.value = Math.ceil(response.data.meta.total / 12);
            pagination.value = response.data.meta;
            replaceLabels();
        })
        .catch((error) => {
            if(error.response.status == 404) {
                router.push({name:"NotFound"})
            };
        })
        .finally(() => {
            loading.value = false;
        });
};

const formatPrice = (num) => {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
};

const replaceLabels = () => {
    pagination.value.links.forEach((page) => {
        if (page.label === "&laquo; Previous") {
            page.label = "<<";
        } else if (page.label === "Next &raquo;") {
            page.label = ">>";
        }
    });
};

watch(
    () => route.query.category,
    (newCategory) => {
        filterByCategory(newCategory);
    }
);

onMounted(() => {
    filterByCategory(route.query.category);
});
</script>
<template>
    <div class="container pt-3">
        <div class="">
            <h2 class="m-0 font-bold text-center capitalize">
                {{ route.query.category }}
            </h2>

            <a-spin :spinning="loading">
                <div
                    class="min-h-[250px] flex flex-col justify-center items-center md:mt-6 max-md:mt-3"
                >
                    <template v-if="posts.length && !loading">
                        <a-row
                            :gutter="[
                                { xs: 8, sm: 12, md: 16 },
                                { xs: 8, sm: 12, md: 16 },
                            ]"
                            class="w-full post-comp"
                        >
                            <a-col
                                v-for="post in posts"
                                :key="post.id"
                                :span="6"
                                :lg="6"
                                :md="8"
                                :sm="12"
                                :xs="24"
                                class="w-full"
                            >
                                <router-link
                                    :to="{
                                        name: 'SingleBlog',
                                        params: { slug: post.slug },
                                    }"
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
                                        >
                                            <SwiperSlide
                                                v-for="(
                                                    image, index
                                                ) in post.images"
                                                :key="index"
                                            >
                                                <img
                                                    :src="image.url"
                                                    class="object-cover w-full h-full"
                                                />
                                            </SwiperSlide>
                                        </Swiper>
                                        <!-- <img v-if="post.images.length > 0" :src="post.images[0]?.url"
                                            :alt="`First Image`" class="h-[160px] object-cover w-full" />
                                        <a-skeleton-image active class="smm__row__image" v-else /> -->
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
                                                {{
                                                    formatPrice(
                                                        parseInt(post.price)
                                                    )
                                                }}
                                                Uzs
                                            </h6>

                                            <div
                                                class="flex items-center pt-1 pb-2 mx-2 border-t"
                                            >
                                                <img
                                                    src="../images/avatar.png "
                                                    class="object-cover w-10 h-10 rounded-full"
                                                />
                                                <h6
                                                    class="mb-0 ml-2 text-lg font-semibold text-black"
                                                >
                                                    {{
                                                        post.user
                                                            ? post.user
                                                            : "Unknown User"
                                                    }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </a-col>
                        </a-row>
                        <div class="flex justify-end w-full my-3">
                            <a-pagination
                                v-model:current="current"
                                :total="totalPages"
                                :pageSize="1"
                                show-less-items
                                hideOnSinglePage
                                @change="
                                    filterByCategory(
                                        route.query.category,
                                        current
                                    )
                                "
                            />
                        </div>
                    </template>
                    <template v-else>
                        <a-empty description="Пака Пустой" class="empty" />
                    </template>
                </div>
            </a-spin>
        </div>
    </div>
</template>

<style>
.smm {
    min-height: 250px;
}

.right_side_menu {
    color: rgb(0, 0, 0);
}

.smm__col__wrapper {
    border: 1px solid #e2e2e2;
}

.post-comp .swiper-button-prev,
.post-comp .swiper-button-next {
    display: none !important;
}

.ant-skeleton.ant-skeleton-element .ant-skeleton-image {
    /* object-fit: cover; */
    height: 160px !important;
    width: 100% !important;
}

.ant-skeleton.ant-skeleton-element {
    width: 100% !important;
}

.design_page {
    display: flex;
    margin-top: 40px;
}

.col-md-8 {
    width: 60vw;
}

.page__header {
    margin: 40px 0 34px;
    text-align: center;
}

.item_title {
    color: #111;
    font-size: 14px;
    height: 36px;
    line-height: 18px;
    margin-bottom: 8px;
    max-height: 100%;
    min-height: auto;
    padding: 0;
}

.item-price {
    height: 50px;
    padding: 13px 0 0;
    color: #04b70a;
    font-size: 16px;
    font-weight: 700;
}

.card-subtitle {
    color: #04b70a !important;
}

.card-user img {
    /*flex-basis: 12%;*/
    width: 30px;
    height: 30px;
    border-radius: 50%;
}

.card-user h6 {
    position: relative;
    /*flex-basis: 80%;*/
    left: 10px;
}

.card-user {
    display: flex;
}

.card-title a {
    font-weight: 400;
    color: #111;
    text-decoration: none;
    list-style: none;
}

.diz {
    display: block;
    font-size: 2em;
    margin-block-start: 0.67em;
    margin-block-end: 0.67em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}

.card-blog-content {
    box-sizing: border-box;
    padding: 6px;
    width: 25%;
}

.card_item {
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    align-items: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    justify-content: center;
    margin: 13px -6px 0;
}

@media (min-width: 768px) {
    .rubrics_item {
        width: 25%;
    }
}

@media (max-width: 768px) {
    .rubrics_item {
        width: 50%;
    }
}
</style>
