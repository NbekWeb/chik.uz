<template>
    <div class="container">
        <div>
            <div class="page__header">
                <h2 class="diz">Single Order</h2>
            </div>
            <div>
                <h1>Order Details</h1>
                <div v-if="order">
                    <p>Order ID: {{ order.id }}</p>
                    <p>Status: {{ order.status }}</p>
                    <!-- Display other order details -->
                </div>
                <div v-else>
                    <p>Loading...</p>
                </div>
            </div>

        </div>
    </div>
    <!-- Display chat chats -->
    <section style="background-color: #eee">
        <div class="container py-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card" id="chat1" style="border-radius: 15px">
                        <div class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
                            style="
                                    border-top-left-radius: 15px;
                                    border-top-right-radius: 15px;
                                ">
                            <p class="mb-0 fw-bold">Mini chat</p>
                        </div>
                        <div class="card-body">
                            <!-- Display chat chats -->
                            <div v-for="(chat, index) in chats" :key="index"
                                :class="'d-flex justify-content-start mb-4'">
                                <div>
                                    <p class="small mb-0">
                                        {{
                                            chat.user_id ===
                                                currentUser.id
                                                ? `(${currentUser.name})`
                                                : chat.user
                                                    ? `(${chat.user.name})`
                                                    : "Unknown"
                                        }}
                                        {{ chat.text }}
                                    </p>
                                </div>
                            </div>
                            <!-- End Chat chats -->

                            <!-- Chat input form -->
                            <div v-if="order && order.status === 202" class="form-outline">
                                <form @submit.prevent="submit">
                                    <input v-model="text" type="text" id="textAreaExample" />
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </form>
                            </div>
                            <!-- End Chat input form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</template>

<script>
import axios from "axios";
import Pusher from "pusher-js";

export default {
    props: ["id"],
    data() {
        return {
            order: {},
            chats: [],
            text: "",
            loading: false,
            error: null,
            currentUser: null,
            cash: "",
            buying: false,
        };
    },
    methods: {
        async submit() {
            try {
                this.loading = true;
                const formData = new FormData();
                formData.append("text", this.text);
                await axios.post(
                    `/api/order/${this.id}/messages`,
                    formData
                );
                this.chats.push({
                    text: this.text,
                    user_id: this.currentUser.id,
                });
                this.text = "";
            } catch (error) {
                console.error("Error submitting message:", error);
                this.error = "Error submitting message";
            } finally {
                this.loading = false;
            }
        },
        async fetchData() {
            try {
                const [
                    chatsResponse,
                    currentUserResponse
                ] = await Promise.all([
                    axios.get(`/api/order/${this.id}/messages`),
                    axios.get(`/api/user`)
                ]);

                this.chats = chatsResponse.data.data;
                this.currentUser = currentUserResponse.data;
            } catch (error) {
                console.error("Error fetching data:", error);
                this.error = "Error fetching data";
            }
        },


        async fetchOrderData() {
            try {
                const response = await axios.get("/api/order/" + this.id);
                this.order = response.data.data;

                // You need to replace Auth.id() and Auth.isLoggedIn() with your actual authentication logic
                const isCurrentUserOrderAuthor = this.order.user.id === Auth.id();

                // Check if user is logged in and is the author of the post
                this.shouldHideAboutText = Auth.isLoggedIn() && isCurrentUserOrderAuthor;
            } catch (error) {
                console.log(error);
            }
        },
        initializePusher() {
            const orderId = this.id;
            const channelName = `chat.${orderId}`;
            window.Echo.private(channelName).listen("NewChat", (e) => {
                console.log(e.chat);
                this.chats.push(e.chat);
            });
        },
    },
    mounted() {
        this.fetchData();
        this.initializePusher();
        this.fetchOrderData();
    },
};
</script>
