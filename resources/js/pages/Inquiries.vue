<template>
    <div class="container">
        <div>
            <div class="page__header">
                <h2 v-if="inquiries.length !== 0" class="diz">All Inquiries</h2>
            </div>
            <div v-if="inquiries.length === 0">
                <hr>
                <h2 style="text-align: center; color:red; font-weight:bold">No Inquiries found.</h2>
            </div>
            <div v-else>
                <div v-for="(inquiry, i) in inquiries" :key="inquiry.id" class="inquiry-item">
                    <p>Inquiries ID: {{ i + 1 }}</p>
                    <p>User Name: {{ inquiry.user_name }}</p>
                    <p>Post Title: {{ inquiry.post_title }}</p>
                    <p>Status: {{ inquiry.status }}</p>
                    <p>Price: {{ inquiry.price }}</p>
                    <p>Created At: {{ inquiry.created_at }}</p>
                    <!-- <button @click="cancelPurchase(inquiry.id)">Cancel Purchase</button> -->
                </div>
            </div>


            <div v-for="inquiry in inquiries" :key="inquiry.id">
                <!-- Link to specific inquiry ID page -->
                <router-link :to="'/inquiry/' + inquiry.id">{{ inquiry.id }}</router-link>
                <!-- Display other inquiry details -->
                <span>{{ inquiry.status }}</span>
                <!-- Add more inquiry details here as needed -->
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
            inquiries: [],
        };
    },
    methods: {
        fetchinquiries() {
            axios
                .get("/api/inquiries")
                .then((response) => {
                    this.inquiries = response.data.data;
                })
                .catch((error) => {
                    console.error("Error fetching inquiries:", error);
                });
        },
        // cancelPurchase(inquiryId) {
        //     // Implement cancellation logic as needed
        //     // Example:
        //     axios
        //         .post(`/api/cancel-inquiry/${inquiryId}`)
        //         .then(() => {
        //             this.fetchinquiries(); // Refresh inquiries after cancellation
        //             // Update the total price if needed
        //             // this.totalPrice -= postPrice;
        //         })
        //         .catch((error) => {
        //             console.error("Cancellation failed:", error);
        //         });
        // },
    },
    mounted() {
        this.fetchinquiries();
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
