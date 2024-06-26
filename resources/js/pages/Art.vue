<template>
    <div class="container">
        <div>
            <div class="page__header">
                <h2 class="diz">Арт и иллюстрации</h2>
            </div>
            <h2>{{ category }} </h2>
            <section class="cards-blog latest-blog">
                <div class="card" v-for="post in posts" :key="post.id">
                    <img v-if="post.images.length > 0" :src="post.images[0]?.url" :alt="`First Image`" />
                    <div class="card-body">
                        <h5 class="card-title"><a href="single-blog.html"></a>
                            <router-link :to="{
                                name: 'SingleBlog',
                                params: { slug: post.slug },
                            }">{{ post.title }}</router-link>
                        </h5>

                        <br>
                        <h6 class="mb-2 card-subtitle text-end">{{ post.price }} Uzs</h6>
                        <hr>
                        <div class="card-user">
                            <img :src="post.userImage ? post.userImage : '/assets/img/avatar.png'"
                                style="width: 40px; height: 40px; border-radius: 50%;" />
                            <h6>{{ post.user ? post.user : 'Unknown User' }}</h6>
                        </div>
                    </div>
                </div>

            </section>
            <ul class="pagination">
                <li v-for="(page, index) in pagination.links" :key="index" class="page-item"
                    :class="{ 'active': page.active }">
                    <a class="page-link" @click.prevent="fetchPage(page.url)" href="#">
                        {{ page.label }}
                    </a>
                </li>
            </ul>
        </div>

    </div>
</template>

<script>
export default {
    props: ['posts', 'category'],

    data() {
        return {
            posts: [],
            pagination: {},
        };
    },

    mounted() {
        axios
            .get("/api/categories")
            .then((response) => {
                this.categories = response.data;
                this.filterByCategory('Арт и иллюстрации'); // Move this inside the categories fetch success block
            })
            .catch((error) => {
                console.log(error);
            });
    },
    methods: {

        fetchPage(url, category) {
            axios.get(url, { params: { category } })
                .then((response) => {
                    this.posts = response.data.data; // Update posts data
                    this.pagination = response.data.meta; // Update pagination data
                    this.replaceLabels(); // Call replaceLabels here
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        filterByCategory(name) {
            axios
                .get("/api/posts", {
                    params: {
                        category: name,
                    },
                })
                .then((response) => {
                    this.posts = response.data.data;
                    this.pagination = response.data.meta;
                    this.replaceLabels(); // Call replaceLabels here
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        replaceLabels() {
            this.pagination.links.forEach(page => {
                if (page.label === "&laquo; Previous") {
                    page.label = "<<";
                } else if (page.label === "Next &raquo;") {
                    page.label = ">>";
                }
            });
        },
    },
};
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
