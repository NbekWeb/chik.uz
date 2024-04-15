<template>
    <div class="container">
        <div>
            <div class="page__header">
                <h2 v-if="inquiry" class="diz">{{ inquiry.post_title }}</h2>
            </div>
            <div v-if="inquiry">
                <div class="inquiry-item">
                    <p>Inquiry ID: {{ inquiry.id }}</p>
                    <p>User Name: {{ inquiry.user_name }}</p>
                    <p>Post Title: {{ inquiry.post_title }}</p>
                    <p>Status: {{ inquiry.status }}</p>
                    <p>Price: {{ inquiry.price }}</p>
                    <p>Created At: {{ inquiry.created_at }}</p>
                    <!-- Add more inquiry details here as needed -->
                </div>
            </div>
            <div v-else>
                <hr>
                <h2 style="text-align: center; color:red; font-weight:bold">No Inquiry found.</h2>
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
                            <div v-if="inquiry && inquiry.id && inquiry.status !== 203 && inquiry.status !== 204"
                                class="form-outline">
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
                    <button class="buyBtn" @click="updateOrderStatus(inquiry.id, 202)"
                        :disabled="buying || inquiry.status !== 201">
                        {{ inquiry.status === 202 ? 'Заказ принят' : 'Принять заказ' }}
                    </button>
                    <button class="buyBtn" @click="updateOrderStatus(inquiry.id, 206)"
                        :disabled="buying || inquiry.status !== 201">
                        {{ inquiry.status === 206 ? 'Заказ отклонен' : 'Отказать заказ' }}
                    </button>
                    <button class="buyBtn" @click="updateOrderStatus(inquiry.id, 205)"
                        :disabled="buying || (inquiry.status !== 202 && inquiry.status == 205)">
                        {{ inquiry.status === 205 ? 'поданный' : 'представлять на рассмотрение' }}
                    </button>
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
    emits: ["updateSidebar"],
    data() {
        return {
            buying: false,
            chats: [],
            text: "",
            loading: false,
            error: null,
            currentUser: null,
            inquiry: {},
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
        async fetchInquiry() {
            try {
                const response = await axios.get("/api/inquiry/" + this.id);
                this.inquiry = response.data.data;
            }
            catch (error) {
                console.log(error);
            }
        },
        async updateOrderStatus(orderId, status) {
            try {
                this.buying = true;
                // Make the PUT request to update the order status
                await axios.put(`/api/update-order-status/${orderId}`, { status: status });
                window.location.reload();
            } catch (error) {
                console.error(error);
            } finally {
                this.buying = false;
            }
        },
        initializePusher() {
            const inquiryId = this.$route.params.id;
            const channelName = `chat.${inquiryId}`;

            window.Echo.private(channelName).listen("NewChat", (e) => {
                console.log(e.chat);
                this.chats.push(e.chat);
            });
        },

    },
    mounted() {
        // Retrieve the inquiry ID from the route parameters
        this.fetchData();
        this.initializePusher();
        this.fetchInquiry();
    },
};
</script>

<style scoped>
/* Add any custom styles for your inquiries here */
.inquiry-item {
    margin-bottom: 20px;
    border: 1px solid #ccc;
    padding: 10px;
}
</style>
