<template>
    <div>
        <h2 class="header-title">Все</h2>
        <div class="searchbar">
            <form action="">
                <input type="text" placeholder="Search..." name="search" v-model="title" />

                <button type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>
        <div class="categories">
            <ul>
                <li v-for="category in categories" :key="category.id">
                    <a href="#" @click="filterByCategory(category.name)">{{
                    category.name
                }}</a>
                </li>
            </ul>
        </div>
        <section class="cards-blog latest-blog">
            <div class="card-blog-content" v-for="post in posts" :key="post.id">
                <img :src="post.imagePath" alt="" />
                <p>
                    {{ post.created_at }}
                    <span style="float: right">Автор {{ post.user }}</span>
                </p>
                <h4 style="font-weight: bolder">
                    <a href="single-blog.html"></a>
                    <router-link :to="{
                    name: 'SingleBlog',
                    params: { slug: post.slug },
                }">{{ post.title }}</router-link>
                </h4>
                <h4 style="font-weight: bolder">Цена:
                    {{ post.price }} :Uzs
                </h4> <button @click="buyPost(post.id, post.price)" :disabled="buying">Купить</button>
                <button @click="cancelPurchase(post.id, post.price)" :disabled="!buying">Отменить</button>
                <!--<h2>Total Price: ${{ totalPrice }}</h2>-->
            </div>
        </section>
        <h3 v-if="!posts.length">Sorry, no match was found!</h3>
        <!-- pagination -->
        <div class="pagination" id="pagination">
            <a href="#" v-for="(link, index) in links" :key="index" v-html="link.label"
                :class="{ active: link.active, disabled: !link.url }" @click="changePage(link)"></a>
        </div>
    </div>
</template>
<script>
export default {
    emits: ["updateSidebar"],
    data() {
        return {
            posts: [],
            categories: [],
            title: "",
            links: [],
            totalPrice: 0,
            cash: "",
        };
    },

    /*computed: {
      cartTotal: function () {
        var i;
        var total = 0;

        for (i = 0; i < this.cart.length; i++) {
          total += this.cart[i].price;
        }

        return total;
      },
      totalItem: function () {
        let sum = 0;
        let summ = 0;
        this.cart.forEach(function (item) {
          var sum = item.price;
          summ += sum * parseFloat(item.qty);
          if (summ < 1) {
            $(".modal").hide();
          }
        });

        return summ;
      },
    },*/
    methods: {

        filterByCategory(name) {
            axios
                .get("/api/posts", {
                    params: {
                        category: name,
                    },
                })
                .then((response) => {
                    this.posts = response.data.data;
                    this.links = response.data.meta.links;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async buyPost(postId, postPrice) {
            try {
                this.buying = true;
                // Make the API request to purchase the post
                await axios.post(`/api/buy-order/${postId}`);

                // Update the total price in your frontend if needed
                this.totalPrice += postPrice;
            } catch (error) {
                console.error('Purchase failed:', error);
            } finally {
                this.buying = false; // Reset buying to false whether the purchase succeeds or fails
            }
        },
        async cancelPurchase(postId, postPrice) {
            try {
                this.buying = false;
                // Make the API request to cancel the purchase
                await axios.post(`/api/cancel-order/${postId}`);

                // Update the total price in your frontend if needed
                this.totalPrice -= postPrice;
            } catch (error) {
                console.error('Cancellation failed:', error);
            }
        },
        changePage(link) {
            if (!link.url || link.active) {
                return;
            }
            axios
                .get(link.url)
                .then((response) => {
                    this.posts = response.data.data;
                    this.links = response.data.meta.links;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },

    watch: {
        title() {
            axios
                .get("/api/posts", {
                    params: {
                        search: this.title,
                    },
                })
                .then((response) => {
                    this.posts = response.data.data;
                    this.links = response.data.meta.links;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },

    mounted() {
        axios
            .get("/api/user")
            .then((response) => {
                this.name = response.data.name;
                this.cash = response.data.cash;
            })
            .catch((error) => {
                if (error.response.status === 401) {
                    this.$emit("updateSidebar");
                    localStorage.removeItem("authenticated");
                    this.$router.push({ name: "Login" });
                }
            });

        axios
            .get("/api/posts")
            .then((response) => {
                this.posts = response.data.data;
                console.log(response.data.meta.links);
                this.links = response.data.meta.links;
            })
            .catch((error) => {
                console.log(error);
            });

        axios
            .get("/api/categories")
            .then((response) => (this.categories = response.data))
            .catch((error) => {
                console.log(error);
            });
    },
};
</script>
<style scoped>
h3 {
    font-size: 30px;
    text-align: center;
    margin: 50px 0;
    color: #fff;
}

.disabled {
    pointer-events: none;
}
</style>
