<template>
    <br>
    <div class="container">
        <div class="order-page">
            <div class="order">
                <h1 class="h3 mb-3">Заказ</h1>
                <ul class="list-group">
                    <li class="list-group-item">Заказ ID: {{ order.id }}</li>
                    <li class="list-group-item">Chik: {{ order.post_title }}</li>
                    <li class="list-group-item">
                        Статус:
                        <span v-if="order.status !== null">
                            <template v-if="order.status === 200">Под общением</template>
                            <template v-else-if="order.status === 201">В ожидании...</template>
                            <template v-else-if="order.status === 202">Принят</template>
                            <template v-else-if="order.status === 203">Экстренный оператор</template>
                            <template v-else-if="order.status === 204">Завершен</template>
                            <template v-else-if="order.status === 205">Представлено на рассмотрение</template>
                            <template v-else-if="order.status === 206">Заказ отклонен</template>
                            <template v-else>Неизвестный</template>
                        </span>
                    </li>

                    <li class="list-group-item">Время: {{ order.created_at }}</li>
                    <li class="list-group-item">Цена: {{ formatPrice(order.price) }}</li>
                </ul>
            </div>
            <br>

            <main class="content">
                <div class="container p-0">

                    <h1 class="h3 mb-3">Чать</h1>

                    <div class="card">
                        <div class="row g-0">
                            <!-- <div class="col-12 col-lg-5 col-xl-3 border-right">

                                <div class="px-4 d-none d-md-block">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <input type="text" class="form-control my-3" placeholder="Поиск...">
                                        </div>
                                    </div>
                                </div>

                                <div class="list-group-item p-3 list-group-item-action border-0">
                                    <div class="badge bg-success float-right">5</div>
                                    <div class="d-flex align-items-start align-items-center">
                                        <img :src="order.post_user_image ? order.post_user_image : '/assets/img/avatar.png'"
                                            class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
                                        <div class="flex-grow-1 ml-3">
                                            <strong> {{ order.post_user_name }}</strong>
                                            <div class="small">
                                                <span class="fas fa-circle chat-online"></span> Online
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="d-block d-lg-none mt-1 mb-0">
                            </div> -->
                            <div class="col-12 ">
                                <div class="py-2 px-4 border-bottom d-lg-block">
                                    <div title="Эта кнопка на случай форс-мажорных или подобных случаев. После нажатия этой кнопки чат будет деактивирован и продолжения не будет."
                                        class="d-flex align-items-center py-1">
                                        <div class="position-relative">
                                            <img :src="'/assets/img/force_m.png'" class="rounded-circle mr-1"
                                                alt="Sharon Lessman" width="40" height="40">
                                        </div>
                                        <div class="flex-grow-1 pl-3">
                                            <strong> &nbsp; Экстренный оператор</strong>
                                            <!-- <div class="text-muted small"><em>Typing...</em></div> -->
                                        </div>
                                        <div>
                                            <button
                                                title="Эта кнопка на случай форс-мажорных или подобных случаев. После нажатия этой кнопки чат будет деактивирован и продолжения не будет."
                                                type="button" class="btn btn-danger btn-sm"
                                                @click="confirmForceMajeure(order.id)"
                                                :disabled="buying || order.status == 203 || order.status == 204">Арбитраж</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="position-relative">
                                    <div class="chat-messages p-4">
                                        <div v-for="(chat, index) in chats" :key="index">
                                            <!-- <div class="chat-message-left pb-4"> -->
                                            <div
                                                :class="{ 'chat-message-left pb-4': chat.user_id !== currentUser.id, 'chat-message-right pb-4': chat.user_id === currentUser.id }">

                                                <div>
                                                    <img :src="chat.userImage ? chat.userImage : '/assets/img/avatar.png'"
                                                        class="rounded-circle mr-1" width="40" height="40">
                                                    <div class="text-muted small text-nowrap mt-2">
                                                        {{ chat.time }}
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                                    <div class="font-weight-bold mb-1 ">{{ chat.user_id ===
                                                        currentUser.id ?
                                                        "Вы" : chat.user ?
                                                            `${chat.user.name}` : "Unknown" }}</div>
                                                    {{ chat.text }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-grow-0 py-3 px-4 border-top">
                                    <div class="d-flex justify-content-between align-items-center"
                                        v-if="order && order.id && order.status !== 203 && order.status !== 204">
                                        <form @submit.prevent="submit" class="flex-grow-1 mr-2 d-flex">
                                            <input v-model="text" type="text" id="textAreaExample"
                                                class="form-control mr-2" placeholder="Напишите сообщение"
                                                autocomplete="off">
                                            <button type="submit" class="btn btn-primary">Отправить</button>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <br>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-success btn-buy me-md-2" @click="buyOrder(order.id, 201)"
                :disabled="buying || order.status !== 200" type="button">Покупать</button>
            <button class="btn btn-danger" type="button" @click="buyOrder(order.id, 206)"
                :disabled="buying || order.status !== 201">{{ order.status === 206 ? 'Заказ отклонен' : 'Отказать заказ'
                }}</button>
            <button class="btn btn-primary btn-p" type="button" @click="buyOrder(order.id, 204)"
                :disabled="buying || order.status !== 205">
                {{ order.status === 204 ? 'Подверден' : 'Подвердите заказ' }}
            </button>
        </div>
    </div>

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
        formatPrice(price) {
            return new Intl.NumberFormat('uz-Uz').format(price);
        },
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
        async buyOrder(orderId, status) {
            try {
                this.buying = true;
                // Make the PUT request to update the order status
                await axios.put(`/api/update-order-status/${orderId}`, { status: status });
                window.location.reload();
            } catch (error) {
                console.error('Purchase failed:', error);
            } finally {
                this.buying = false;
            }
        },
        confirmForceMajeure(orderId) {
            if (window.confirm("Вы уверены, что хотите выполнить арбитраж? После этого чат будет деактивирован.")) {
                this.forceMajeure(orderId);
            }
        },
        async forceMajeure(orderId) {
            try {
                this.buying = true;
                // Make the PUT request to update the order status
                await axios.put(`/api/force-majeure/${orderId}`);
                window.location.reload();
            } catch (error) {
                console.error('forceMajeure failed:', error);
            } finally {
                this.buying = false;
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

<style scoped>
/* Add any custom styles for your orders here */
.order-item {
    margin-bottom: 20px;
    border: 1px solid #ccc;
    padding: 10px;
}

.order-page {
    display: flex;
}

.order-table {
    border: 1px solid #ccc;
}

.order {
    flex-basis: 26%;
}

.content {
    margin-left: 35px;

    flex-basis: 71%;
}

/* .btn-buy {
    background-color: #e4606d;
    border-color: #e4606d
} */

.btn-p {
    background-color: #34ce57;
    border-color: #34ce57;
}

.chat-online {
    color: #34ce57
}

.chat-offline {
    color: #e4606d
}

.chat-messages {
    display: flex;
    flex-direction: column;
    max-height: 800px;
    overflow-y: scroll
}

.chat-message-left,
.chat-message-right {
    display: flex;
    flex-shrink: 0
}

.chat-message-left {
    margin-right: auto
}

.chat-message-right {
    flex-direction: row-reverse;
    margin-left: auto
}

.py-3 {
    padding-top: 1rem !important;
    padding-bottom: 1rem !important;
}

.px-4 {
    padding-right: 1.5rem !important;
    padding-left: 1.5rem !important;
}

.flex-grow-0 {
    flex-grow: 0 !important;
}

.border-top {
    border-top: 1px solid #dee2e6 !important;
}

@media screen and (max-width: 425px) {
    .order-page {
        display: grid;

    }

    .order {
        flex-basis: none;
    }

    .content {
        margin-left: 0px;

        flex-basis: none;
    }
}
</style>
