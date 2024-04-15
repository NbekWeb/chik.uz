<template>
    <div class="container">
        <div>
            <div class="page__header">
                <h2 class="diz">Owners all orders</h2>
            </div>
            <div v-if="orders.length === 0">
                <p>No orders found.</p>
            </div>
            <div v-else>
                <div v-for="order in orders" :key="order.id" class="order-item">
                    <p>Order ID: {{ order.id }}</p>
                    <p>User ID: {{ order.user_id }}</p>
                    <p>Post ID: {{ order.post_id }}</p>
                    <p>Status: {{ order.status }}</p>
                    <p>Price: {{ order.price }}</p>
                    <p>Created At: {{ order.created_at }}</p>
                    <button @click="cancelPurchase(order.id, 206)" :disabled="buying || order.status !== 201">
                        {{ order.status === 206 ? 'Заказ отклонен' : 'Отказать заказ' }}
                    </button>
                    <br>
                    <router-link :to="'/order/' + order.id">open order</router-link>

                </div>
            </div>
        </div>
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
</style>
