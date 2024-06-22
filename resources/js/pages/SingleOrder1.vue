<template>
    <br />
    <div class="container">
        <div class="order-page">
            <div class="order">
                <h1 class="mb-3 h3">Заказ</h1>
                <ul class="list-group">
                    <li class="list-group-item">Заказ ID: {{ order.id }}</li>
                    <li class="list-group-item">
                        Chik: {{ order.post_title }}
                    </li>
                    <li class="list-group-item">
                        Статус:
                        <span v-if="order.status !== null">
                            <template v-if="order.status === 200"
                                >Под общением</template
                            >
                            <template v-else-if="order.status === 201"
                                >В ожидании...</template
                            >
                            <template v-else-if="order.status === 202"
                                >Принят</template
                            >
                            <template v-else-if="order.status === 203"
                                >Экстренный оператор</template
                            >
                            <template v-else-if="order.status === 204"
                                >Завершен</template
                            >
                            <template v-else-if="order.status === 205"
                                >Представлено на рассмотрение</template
                            >
                            <template v-else-if="order.status === 206"
                                >Заказ отклонен</template
                            >
                            <template v-else>Неизвестный</template>
                        </span>
                    </li>

                    <li class="list-group-item">
                        Время: {{ order.created_at }}
                    </li>
                    <li class="list-group-item">
                        Цена: {{ formatPrice(order.price) }}
                    </li>
                </ul>
            </div>
            <br />

            <main class="content">
                <div class="container p-0">
                    <h1 class="mb-3 h3">Чать</h1>

                    <div class="card">
                        <div class="row g-0">
                            <!-- <div class="col-12 col-lg-5 col-xl-3 border-right">

                                <div class="px-4 d-none d-md-block">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <input type="text" class="my-3 form-control" placeholder="Поиск...">
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3 border-0 list-group-item list-group-item-action">
                                    <div class="float-right badge bg-success">5</div>
                                    <div class="d-flex align-items-start align-items-center">
                                        <img :src="order.post_user_image ? order.post_user_image : '/assets/img/avatar.png'"
                                            class="mr-1 rounded-circle" alt="Vanessa Tucker" width="40" height="40">
                                        <div class="ml-3 flex-grow-1">
                                            <strong> {{ order.post_user_name }}</strong>
                                            <div class="small">
                                                <span class="fas fa-circle chat-online"></span> Online
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-1 mb-0 d-block d-lg-none">
                            </div> -->
                            <div class="col-12">
                                <div class="px-4 py-2 border-bottom d-lg-block">
                                    <div
                                        title="Эта кнопка на случай форс-мажорных или подобных случаев. После нажатия этой кнопки чат будет деактивирован и продолжения не будет."
                                        class="py-1 d-flex align-items-center"
                                    >
                                        <div class="position-relative">
                                            <img
                                                :src="'/assets/img/force_m.png'"
                                                class="mr-1 rounded-circle"
                                                alt="Sharon Lessman"
                                                width="40"
                                                height="40"
                                            />
                                        </div>
                                        <div class="pl-3 flex-grow-1">
                                            <strong>
                                                &nbsp; Экстренный оператор
                                            </strong>
                                            <!-- <div class="text-muted small"><em>Typing...</em></div> -->
                                        </div>
                                        <div>
                                            <button
                                                title="Эта кнопка на случай форс-мажорных или подобных случаев. После нажатия этой кнопки чат будет деактивирован и продолжения не будет."
                                                type="button"
                                                class="btn btn-danger btn-sm"
                                                @click="
                                                    confirmForceMajeure(
                                                        order.id
                                                    )
                                                "
                                                :disabled="
                                                    buying ||
                                                    order.status == 203 ||
                                                    order.status == 204 ||
                                                    !arbitaj
                                                "
                                            >
                                                Арбитраж
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="position-relative">
                                    <div class="p-4 chat-messages">
                                        <div
                                            v-for="(chat, index) in chats"
                                            :key="index"
                                        >
                                            <!-- <div class="pb-4 chat-message-left"> -->
                                            <div
                                                v-if="chat.text !== 'Arbitajed'"
                                                :class="{
                                                    'chat-message-left pb-4':
                                                        chat.user_id !==
                                                        currentUser.id,
                                                    'chat-message-right pb-4':
                                                        chat.user_id ===
                                                        currentUser.id,
                                                }"
                                            >
                                                <div>
                                                    <img
                                                        :src="
                                                            chat.userImage
                                                                ? chat.userImage
                                                                : '/assets/img/avatar.png'
                                                        "
                                                        class="mr-1 rounded-circle"
                                                        width="40"
                                                        height="40"
                                                    />
                                                    <div
                                                        class="mt-2 text-muted small text-nowrap"
                                                    >
                                                        {{ chat.time }}
                                                    </div>
                                                </div>
                                                <div
                                                    class="px-3 py-2 mr-3 rounded flex-shrink-1 bg-light"
                                                >
                                                    <div
                                                        class="mb-1 font-weight-bold"
                                                    >
                                                        {{
                                                            chat.user_id ===
                                                            currentUser.id
                                                                ? "Вы"
                                                                : chat.user
                                                                ? `${chat.user.name}`
                                                                : "Unknown"
                                                        }}
                                                    </div>
                                                    {{ chat.text }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-grow-0 px-4 py-3 border-top">
                                    <div
                                        class="d-flex justify-content-between align-items-center"
                                        v-if="
                                            order &&
                                            order.id &&
                                            arbitaj &&
                                            order.status !== 203 &&
                                            order.status !== 204
                                        "
                                    >
                                        <form
                                            @submit.prevent="submit"
                                            class="mr-2 flex-grow-1 d-flex"
                                        >
                                            <input
                                                v-model="text"
                                                type="text"
                                                id="textAreaExample"
                                                class="mr-2 form-control"
                                                placeholder="Напишите сообщение"
                                                autocomplete="off"
                                            />
                                            <button
                                                type="submit"
                                                class="btn btn-primary"
                                            >
                                                Отправить
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <br />
        <div class="gap-2 pb-4 d-grid d-md-flex justify-content-md-end">
            <button
                class="btn btn-success btn-buy me-md-2"
                @click="buyOrder(order.id, 201)"
                :disabled="buying || order.status !== 200"
                type="button"
            >
                Покупать
            </button>
            <button
                class="btn btn-danger"
                type="button"
                @click="buyOrder(order.id, 206)"
                :disabled="buying || order.status !== 201"
            >
                {{ order.status === 206 ? "Заказ отклонен" : "Отказать заказ" }}
            </button>
            <button
                class="btn btn-primary btn-p"
                type="button"
                @click="buyOrder(order.id, 204)"
                :disabled="buying || order.status !== 205"
            >
                {{ order.status === 204 ? "Подверден" : "Подвердите заказ" }}
            </button>
        </div>
    </div>
   
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import Pusher from "pusher-js";
import Echo from "laravel-echo";

const props = defineProps(["id"]);
const order = ref({});
const chats = ref([]);
const text = ref("");
const loading = ref(false);
const arbitaj = ref(true);
const error = ref(null);
const currentUser = ref(null);
const cash = ref("");
const buying = ref(false);

const formatPrice = (price) => {
    return new Intl.NumberFormat("uz-Uz").format(price);
};

const submit = async () => {
    try {
        loading.value = true;
        const formData = new FormData();
        formData.append("text", text.value);
        await axios.post(`/api/order/${props.id}/messages`, formData);
        chats.value.push({
            text: text.value,
            user_id: currentUser.value.id,
        });
        text.value = "";
    } catch (error) {
        console.error("Error submitting message:", error);
        error.value = "Error submitting message";
    } finally {
        loading.value = false;
    }
};

const buyOrder = async (orderId, status) => {
    try {
        buying.value = true;
        await axios.put(`/api/update-order-status/${orderId}`, {
            status: status,
        });
        // window.location.reload();
    } catch (error) {
        console.error("Purchase failed:", error);
    } finally {
        buying.value = false;
    }
};

const confirmForceMajeure = (orderId) => {
    if (
        window.confirm(
            "Вы уверены, что хотите выполнить арбитраж? После этого чат будет деактивирован."
        )
    ) {
        forceMajeure(orderId);
    }
};

const forceMajeure = async (orderId) => {
    try {
        buying.value = true;
        arbitajFunc();
        await axios.put(`/api/force-majeure/${orderId}`);
        window.location.reload();
    } catch (error) {
        console.error("forceMajeure failed:", error);
    } finally {
        buying.value = false;
    }
};

const fetchData = async () => {
    try {
        const [chatsResponse, currentUserResponse] = await Promise.all([
            axios.get(`/api/order/${props.id}/messages`),
            axios.get(`/api/user`),
        ]);

        chats.value = chatsResponse.data.data;
        currentUser.value = currentUserResponse.data;
    } catch (error) {
        console.error("Error fetching data:", error);
        error.value = "Error fetching data";
    }
};

const fetchOrderData = async () => {
    try {
        const response = await axios.get("/api/order/" + props.id);
        order.value = response.data.data;
    } catch (error) {
        console.log(error);
    }
};

const initializePusher = () => {
    const orderId = props.id;
    const channelName = `chat.${orderId}`;
    window.Echo.private(channelName).listen("NewChat", (e) => {
        // console.log(e.chat.text);
        if (e.chat.text === "Arbitajed") {
            arbitaj.value = false;
        }
        chats.value.push(e.chat);
    });
};

async function arbitajFunc() {
    try {
        const formData = new FormData();
        formData.append("text", "Arbitajed");
        await axios.post(`/api/order/${props.id}/messages`, formData);
        chats.value.push({
            text: "Arbitajed",
            user_id: currentUser.value.id,
        });
    } catch (error) {
        console.error("Error submitting message:", error);
        error.value = "Error submitting message";
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    fetchData();
    initializePusher();
    fetchOrderData();
});
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
    color: #34ce57;
}

.chat-offline {
    color: #e4606d;
}

.chat-messages {
    display: flex;
    flex-direction: column;
    max-height: 800px;
    overflow-y: scroll;
}

.chat-message-left,
.chat-message-right {
    display: flex;
    flex-shrink: 0;
}

.chat-message-left {
    margin-right: auto;
}

.chat-message-right {
    flex-direction: row-reverse;
    margin-left: auto;
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
