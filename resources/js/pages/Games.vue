<template>
    <div class="pt-3 container">
        <div>
            <h2 class="text-center font-bold pb-3">Игры</h2>

            <a-spin :spinning="loading">
                <div class="min-h-[250px] flex justify-center items-center pb-3 flex-col">
                    <template v-if="posts.length && !loading">
                        <a-row :gutter="[16, 24]">
                            <a-col v-for="post in posts" :key="post.id" :span="6" :lg="6" :md="8" :sm="12" :xs="24">
                                <router-link :to="{
                                    name: 'SingleBlog',
                                    params: { slug: post.slug },
                                }">
                                    <div class="bg-white smm__col__wrapper">
                                        <img v-if="post.images.length > 0" :src="post.images[0]?.url"
                                            :alt="`First Image`" class="h-[160px] object-cover w-full" />
                                        <a-skeleton-image active class="smm__row__image" v-else />
                                        <div class="card-body">
                                            <p class="h-10 mx-2 mt-3 text-sm text-light__black desc__text">
                                                {{ post.title }} Lorem ipsum dolor sit amet consectetur
                                                adipisicing elit. Veritatis nam aliquid voluptates nemo
                                                voluptatum quibusdam rerum facere laudantium neque sunt?
                                            </p>

                                            <br />
                                            <h6 class="mb-2 mr-2 text-lg font-bold text-end text-green">
                                                {{ post.price }} Uzs
                                            </h6>
                                            <hr />
                                            <div class="flex items-center mx-2 mb-2">
                                                <img src="./images/avatar.png "
                                                    class="object-cover w-10 h-10 rounded-full" />
                                                <h6 class="mb-0 ml-2 text-lg">
                                                    {{ post.user ? post.user : "Unknown User" }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </a-col>
                            <a-col v-for="post in posts" :key="post.id" :span="6" :lg="6" :md="8" :sm="12" :xs="24">
                                <router-link :to="{
                                    name: 'SingleBlog',
                                    params: { slug: post.slug },
                                }">
                                    <div class="bg-white smm__col__wrapper">
                                        <img v-if="post.images.length > 0" :src="post.images[0]?.url"
                                            :alt="`First Image`" class="h-[160px] object-cover w-full" />
                                        <a-skeleton-image active class="smm__row__image" v-else />
                                        <div class="card-body">
                                            <p class="h-10 mx-2 mt-3 text-sm text-light__black desc__text">
                                                {{ post.title }}
                                            </p>

                                            <br />
                                            <h6 class="mb-2 mr-2 text-lg font-bold text-end text-green">
                                                {{ post.price }} Uzs
                                            </h6>
                                            <hr />
                                            <div class="flex items-center mx-2 mb-2">
                                                <img src="./images/avatar.png "
                                                    class="object-cover w-10 h-10 rounded-full" />
                                                <h6 class="mb-0 ml-2 text-lg">
                                                    {{ post.user ? post.user : "Unknown User" }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </a-col>
                        </a-row>
                        <div class=" w-full flex justify-end mt-3">
                            <a-pagination v-model:current="current" :total="totalPages" :pageSize="2" show-less-items
                                hideOnSinglePage />
                        </div>
                    </template>
                    <template v-else>
                        <a-empty description="Пака Пустой" class="empty" />
                        {{ posts }}
                    </template>
                </div>
            </a-spin>

            <!-- <section class="cards-blog latest-blog">
          <div class="card" v-for="post in posts" :key="post.id">
            <img
              v-if="post.images.length > 0"
              :src="post.images[0]?.url"
              :alt="`First Image`"
            />
            <div class="card-body">
              <h5 class="card-title">
                <a href="single-blog.html"></a>
                <router-link
                  :to="{
                    name: 'SingleBlog',
                    params: { slug: post.slug },
                  }"
                  >{{ post.title }}</router-link
                >
              </h5>

              <br />
              <h6 class="card-subtitle mb-2 text-end">{{ post.price }} Uzs</h6>
              <hr />
              <div class="card-user">
                <img
                  :src="
                    post.userImage ? post.userImage : '@/assets/img/avatar.png'
                  "
                  style="width: 40px; height: 40px; border-radius: 50%"
                />
                <h6>{{ post.user ? post.user : "Unknown User" }}</h6>
              </div>
            </div>
          </div>
        </section>
        <ul class="pagination">
          <li
            v-for="(page, index) in pagination.links"
            :key="index"
            class="page-item"
            :class="{ active: page.active }"
          >
            <a class="page-link" @click.prevent="fetchPage(page.url)" href="#">
              {{ page.label }}
            </a>
          </li>
        </ul> -->
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRoute } from "vue-router";

const posts = ref([]);
const loading = ref();
const pagination = ref({});
const categories = ref([]);

const route = useRoute();
const category = route.params.category || "Игры";

const fetchPage = async (url, category) => {
    try {
        const response = await axios.get(url, { params: { category } });
        posts.value = response.data.data;
        pagination.value = response.data.meta;

        replaceLabels();
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
};

const filterByCategory = (name) => {
    loading.value = true;
    axios
        .get("https://chik.uz/api/posts", {
            params: { category: name },
        })
        .then((response) => {
            posts.value = response.data.data;
            console.log(response);
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => {
            loading.value = false;
        });
};

const replaceLabels = () => {
    if (pagination.value.links) {
        pagination.value.links.forEach((page) => {
            if (page.label === "&laquo; Previous") {
                page.label = "<<";
            } else if (page.label === "Next &raquo;") {
                page.label = ">>";
            }
        });
    }
};

onMounted(async () => {
    //   try {
    //     const response = await axios.get("https://chik.uz/api/categories");
    //     categories.value = response.data;
    //     filterByCategory("Игры");
    //     loading.value = true;
    //   } catch (error) {
    //     console.error(error);
    filterByCategory("Игры");
    //   }
    //   axios
    //   .get("https://chik.uz/api/categories")
    //   .then((response)=>{
    //     categories.value = response.data;
    //     filterByCategory("Игры")
    //     console.log(categories.value)
    //   })
    //   .catch((error) => {
    //       console.log(error);
    //     });
});
</script>

<style>
.right_side_menu {
    color: rgb(0, 0, 0);
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
