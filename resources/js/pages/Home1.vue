<template>
    <div class="container">
        <div class="">
            <div class="categories-list">
                <h1>Chiki</h1>
                <!-- success message -->
                <div class="success-msg" v-if="success">
                    <i class="fa fa-check"></i>
                    Chik удалено успешно !
                </div>
                <div class="success-msg" v-if="editSuccess">
                    <i class="fa fa-check"></i>
                    Chik изменено успешно !
                </div>


                <div class="row">
                    <div class="col-md-3" v-for="(post, index) in posts" :key="post.id">
                        <div class="mx-1 card card_box">
                            <img class="card-img-top" v-if="post.images.length > 0" :src="post.images[0]?.url"
                                :alt="post.title" />
                            <div class="card-body card_text">
                                <h5 class="card-title">#{{ index + 1 }} {{ post.title }}</h5>
                                <p class="card-text">{{ post.body }}</p>
                            </div>
                            <div class="bg-transparent card-footer d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ post.updated_at }}</small>
                                <div class="d-flex">
                                    <router-link :to="{ name: 'EditPosts', params: { slug: post.slug } }"
                                        class="px-1 fa fa-edit text-info text-decoration-none"></router-link>
                                    <a class="px-1 text-danger fas fa-window-close" @click="destroy(post.slug)"></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="index-categories">
                    <router-link :to="{ name: 'CreatePosts' }">Создать Chik<span>&#8594;</span></router-link>
                </div>
            </div>
            <div class="description"></div>
        </div>

    </div>

</template>
<script>
export default {
    props: ["editSuccess"],
    emits: ["updateSidebar"],
    data() {
        return {
            posts: [],
            success: false,
        };
    },
    methods: {
        destroy(slug) {
            if (confirm("Вы уверены, что хотите удалить эту запись?")) {

                axios
                    .delete(`/api/posts/${slug}`)
                    .then(() => {
                        this.fetchPosts();
                        this.success = true;
                        setTimeout(() => {
                            this.success = false;
                        }, 2500);
                    })
                    .catch((error) => {
                        console.log(error.response.data);
                    });
            }
        }
        ,

        fetchPosts() {
            axios
                .get("/api/dashboard-posts")
                .then((response) => (this.posts = response.data.data))
                .catch((error) => {
                    console.log(error);
                });
        },
    },

    mounted() {
        this.fetchPosts();
    },
};
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
    background: #f1f1f1;
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
    background: #fff;
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
