<template>
    <div class="container">
        <br>
        <div class="order">
            <div v-if="orders.length === 0">
                <h1 class="h3 mb-3 text-center text-danger fw-bold">Заказов не найдено.</h1>
            </div>
            <div v-else>
                <h1 class="h3 mb-3">Заказы</h1>
                <div v-for="order in orders" :key="order.id">
                    <ul class="list-group py-2 pt-3">
                        <li class="list-group-item">Заказ ID: {{ order.id }}</li>
                        <li class="list-group-item">Владелец Чика: {{ order.post_user_name }}</li>
                        <li class="list-group-item">Chik: {{ order.post_title }}</li>
                        <li class="list-group-item">Статус:
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
                        <li class="list-group-item">Цена: {{ order.price }}</li>
                        <li class="list-group-item">Сделано: {{ order.created_at }}</li>
                    </ul>
                    <router-link :to="'/order/' + order.id" type="button" class="btn btn-primary btn-sm">Открыть
                        Заказ</router-link>
                </div>
            </div>
        </div>
        <br>
    </div>
</template>

<script>
import axios from "axios";

export default {
    emits: ["updateSidebar"],
    data() {
        return {
            orders: [],
        };
    },
    methods: {
        fetchOrders() {
            axios
                .get("/api/orders")
                .then((response) => {
                    this.orders = response.data.data;
                })
                .catch((error) => {
                    console.error("Error fetching orders:", error);
                });
        },
        async cancelPurchase(orderId, status) {
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
    },
    mounted() {
        this.fetchOrders();
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

.btn {
    background-color: #e4606d;
    border-color: #e4606d;
}
</style>
