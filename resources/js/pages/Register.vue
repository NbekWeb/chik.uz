<template>
    <a-spin :spinning="loading">
        <section class="h-100 bg-dark">
            <div class="container py-5 h-100">
                <div
                    class="row d-flex justify-content-center align-items-center h-100"
                >
                    <div class="col">
                        <div class="my-4 card card-registration">
                            <div class="row g-0">
                                <div class="col-xl-6 d-none d-xl-block">
                                    <img
                                        src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/img4.webp"
                                        alt="Sample photo"
                                        class="img-fluid"
                                        style="
                                            border-top-left-radius: 0.25rem;
                                            border-bottom-left-radius: 0.25rem;
                                        "
                                    />
                                </div>
                                <div class="col-xl-6">
                                    <div class="text-black card-body p-md-5">
                                        <h3 class="mb-5 text-lowcase">
                                            Регистрация
                                        </h3>
                                        <form @submit.prevent="submit">
                                            <div class="mb-4 form-outline">
                                                <input
                                                    type="name"
                                                    id="name"
                                                    v-model="fields.name"
                                                    class="form-control form-control-lg"
                                                />
                                                <label
                                                    class="form-label"
                                                    for="name"
                                                    >Имя</label
                                                >
                                                <span
                                                    v-if="errors.name"
                                                    class="error"
                                                    >{{ errors.name[0] }}</span
                                                >
                                            </div>

                                            <div class="mb-4 form-outline">
                                                <input
                                                    type="email"
                                                    id="email"
                                                    v-model="fields.email"
                                                    class="form-control form-control-lg"
                                                />
                                                <label
                                                    class="form-label"
                                                    for="email"
                                                    >Email адрес</label
                                                >
                                                <span
                                                    v-if="errors.email"
                                                    class="error"
                                                    >{{ errors.email[0] }}</span
                                                >
                                            </div>

                                            <div class="mb-4 form-outline">
                                                <input
                                                    type="password"
                                                    id="password"
                                                    v-model="fields.password"
                                                    class="form-control form-control-lg"
                                                />
                                                <label
                                                    class="form-label"
                                                    for="password"
                                                    >Пароль</label
                                                >
                                                <span
                                                    v-if="errors.password"
                                                    class="error"
                                                    >{{
                                                        errors.password[0]
                                                    }}</span
                                                >
                                            </div>

                                            <div class="mb-4 form-outline">
                                                <input
                                                    type="password"
                                                    id="password_confirmation"
                                                    v-model="
                                                        fields.password_confirmation
                                                    "
                                                    class="form-control form-control-lg"
                                                />
                                                <label
                                                    class="form-label"
                                                    for="password_confirmation"
                                                    >Подтвердите Пароль</label
                                                >
                                                <span
                                                    v-if="
                                                        errors.password_confirmation
                                                    "
                                                    class="error"
                                                    >{{
                                                        errors
                                                            .password_confirmation[0]
                                                    }}</span
                                                >
                                            </div>

                                            <div
                                                class="pt-3 d-flex justify-content-end"
                                            >
                                                <button
                                                    type="submit"
                                                    class="btn btn-warning btn-lg ms-2"
                                                >
                                                    Регистрация
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </a-spin>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

const fields = ref({});
const errors = ref({});
const router = useRouter();
const loading = ref(false);

function submit() {
    loading.value = true;
    axios
        .post("/register", fields.value)
        .then(() => {
            localStorage.setItem("authenticated", "true");
            // router.push({ name: "Home" });
            window.location.href = "/admin/dashboard";
        })
        .catch((error) => {
            errors.value = error.response.data.errors;
        })
        .finally(() => {
            loading.value = false;
        });
}
</script>
<style scoped>
.background-radial-gradient {
    background-color: hsl(218, 41%, 15%);
    background-image: radial-gradient(
            650px circle at 0% 0%,
            hsl(218, 41%, 35%) 15%,
            hsl(218, 41%, 30%) 35%,
            hsl(218, 41%, 20%) 75%,
            hsl(218, 41%, 19%) 80%,
            transparent 100%
        ),
        radial-gradient(
            1250px circle at 100% 100%,
            hsl(218, 41%, 45%) 15%,
            hsl(218, 41%, 30%) 35%,
            hsl(218, 41%, 20%) 75%,
            hsl(218, 41%, 19%) 80%,
            transparent 100%
        );
}

#radius-shape-1 {
    height: 220px;
    width: 220px;
    top: -60px;
    left: -130px;
    background: radial-gradient(#44006b, #ad1fff);
    overflow: hidden;
}

#radius-shape-2 {
    border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
    bottom: -60px;
    right: -110px;
    width: 300px;
    height: 300px;
    background: radial-gradient(#44006b, #ad1fff);
    overflow: hidden;
}

.bg-glass {
    background-color: hsla(0, 0%, 100%, 0.9) !important;
    backdrop-filter: saturate(200%) blur(25px);
}
</style>
