<template>
    <div>
        <div class="container">
            <!-- Display post details -->
            <section class="single-blog-post">
                <h1>{{ post?.title }}</h1>
                <p class="time-and-author">
                    {{ post.created_at }}
                    <span v-if="post.user">{{ post.user.name }}</span>
                    <span v-else>Unknown</span>
                </p>
                <div v-for="(image, index) in post.images" :key="index">
                    <img :src="image?.url" :alt="`Image ${index + 1}`" style="width: 150px; height: 150px" />
                </div>
                <div class="about-text" v-if="!shouldHideAboutText">
                    <p class="price">Цена: {{ post.price }} :Uzs</p>
                    <button class="buyBtn" @click="buyPost(post.id, post.price)" :disabled="buying || postIsPurchased">
                        Купить
                    </button>
                </div>
                <div class="about-text">
                    <p>{{ post.body }}</p>
                </div>
            </section>

            <!-- Display related posts -->
            <section class="recommended">
                <p>Related</p>
                <div class="recommended-cards">
                    <router-link v-for="relatedPost in relatedPosts" :key="relatedPost.id" :to="{
                    name: 'SingleBlog',
                    params: { slug: relatedPost.slug },
                }">
                        <div class="recommended-card">
                            <img :src="`/${relatedPost.imagePath}`" alt="" loading="lazy" />
                            <h4>{{ relatedPost.title }}</h4>
                            <h4>Цена: {{ relatedPost.price }}</h4>
                        </div>
                    </router-link>
                </div>
            </section>
        </div>

    </div>
</template>

<script>
import axios from "axios";

export default {
    props: ["slug"],
    data() {
        return {
            post: {},
            relatedPosts: [],
            text: "",
            loading: false,
            error: null,
            currentUser: null,
            cash: "",
            buying: false,
        };
    },
    methods: {
        async fetchData() {
            try {
                const [
                    postResponse,
                    relatedPostsResponse,
                    currentUserResponse,
                ] = await Promise.all([
                    axios.get(`/api/posts/${this.slug}`),
                    axios.get(`/api/related-posts/${this.slug}`),
                    axios.get(`/api/user`),
                ]);
                this.post = postResponse.data.data;
                this.relatedPosts = relatedPostsResponse.data.data;
                this.currentUser = currentUserResponse.data;
            } catch (error) {
                console.error("Error fetching data:", error);
                this.error = "Error fetching data";
            }
        },
        async buyPost(postId, postPrice) {
            try {
                this.buying = true;
                // Make the API request to purchase the post
                await axios.post(`/api/buy-order/${postId}`);

                // Update the total price in your frontend if needed
                this.totalPrice += postPrice;
                this.postIsPurchased = true;
            } catch (error) {
                console.error('Purchase failed:', error);
            } finally {
                this.buying = false; // Reset buying to false whether the purchase succeeds or fails
            }
        },
        async cancelPurchase(postId, postPrice) {
            try {
                this.buying = true;
                // Make the API request to cancel the purchase
                await axios.post(`/api/cancel-order/${postId}`);

                // Update the total price in your frontend if needed
                this.totalPrice -= postPrice;
                this.postIsPurchased = false;
            } catch (error) {
                console.error('Cancellation failed:', error);
            }
            finally {
                this.buying = false; // Reset buying to false whether the cancellation succeeds or fails
            }
        },
        async fetchPostData() {
            try {
                const response = await axios.get("/api/posts/" + this.slug);
                this.post = response.data.data;

                // Check if the authenticated user is the author of the post
                const isCurrentUserPostAuthor = this.post.user.id === Auth.id();

                // Check if user is logged in and is the author of the post
                this.shouldHideAboutText = Auth.isLoggedIn() && isCurrentUserPostAuthor;
            } catch (error) {
                console.log(error);
            }
        },
    },
    mounted() {
        this.fetchData();
        this.buyPost();
        this.cancelPurchase();
        this.fetchPostData();
    },
};
</script>

<style scoped>
.buyBtn {
    background-color: orange;
    border-color: white;
    width: 86px;
    border-radius: 40px;
    margin-left: 20px;
    margin-right: 20px;
}

.cancelBtn {

    background-color: red;
    border-color: white;
    width: 86px;
    border-radius: 40px;
    color: white;

}

.price {
    margin-bottom: 0 0;
}

/* Your existing styles */
</style>
