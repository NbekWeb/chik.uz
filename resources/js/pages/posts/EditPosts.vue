<template>
    <div class="container pb-5 editPosts">
        <h1 class="py-3 text-center">Создать Chik!</h1>
        <div class="contact-form">
            <a-form
                ref="formRef"
                @submit="submit"
                class="w-full"
                layout="vertical"
                :model="fields"
                :rules="rules"
            >
                <a-form-item
                    label="Заголовок"
                    class="w-full max-w-[400px]"
                    name="title"
                >
                    <a-input v-model:value="fields.title" />
                </a-form-item>

                <a-form-item label="Фото" name="photos">
                    <a-upload
                        v-model:file-list="fileList"
                        accept=".jpg,.jpeg,.png"
                        list-type="picture-card"
                        class="avatar-uploader w-[200px]"
                        :show-upload-list="true"
                        :before-upload="beforeUpload"
                        @change="handleChange"
                        @preview="handlePreview"
                        :customRequest="dummyRequest"
                        multiple
                    >
                        <div v-if="fileList.length < 10">
                            <PlusOutlined />
                            <div class="ant-upload-text">Upload</div>
                        </div>
                    </a-upload>
                </a-form-item>

                <a-form-item
                    label="Выберите категорию"
                    class="w-full max-w-[400px]"
                    name="category_id"
                >
                    <a-select ref="select" v-model:value="fields.category_id">
                        <a-select-option
                            :value="category.id"
                            v-for="category in categories"
                            :key="category.id"
                        >
                            {{ category.name }}
                        </a-select-option>
                    </a-select>
                </a-form-item>

                <a-form-item
                    class="w-full max-w-[400px]"
                    label="Цена"
                    name="price"
                >
                    <MoneyInput v-model:value="fields.price" />
                </a-form-item>

                <a-form-item label="Контент" name="body">
                    <Editor
                        v-model="fields.body"
                        editorStyle="height: 320px;"
                    />
                </a-form-item>
                <a-button type="primary" @click="submit">Изменить</a-button>
            </a-form>
        </div>
        <a-modal v-model:open="previewVisible">
            <img :src="previewImage" alt="Image Preview" style="width: 100%" />
        </a-modal>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import axios from "axios";
import Editor from "primevue/editor";
import { PlusOutlined } from "@ant-design/icons-vue";
import { message } from "ant-design-vue";
import MoneyInput from "@/components/MoneyInput.vue";
import { useRoute, useRouter } from "vue-router";

const success = ref(false);
const route = useRoute();
const router = useRouter();
const slug = ref(route.params.slug);
const formRef = ref(null);
const fields = ref({
    category_id: "",
    body: "",
    price: "",
    title: "",
    img: [],
});
const errors = ref({});
const showPhoto = ref(false);
const urls = ref([]);
const categories = ref([]);
const images = ref([]);
const loading = ref(false);
const imageUrl = ref("");
const fileList = ref([]);
const previewVisible = ref(false);
const previewImage = ref("");

const deleteImg = () => {
    formState.value.img = null;
    showPhoto.value = true;
};

const rules = reactive({
    title: [
        {
            required: true,
            message: "Пожалуйста, введите заголовок",
            trigger: "blur",
        },
    ],
    category_id: [
        {
            required: true,
            message: "Пожалуйста, выберите категорию",
            trigger: "change",
        },
    ],
    price: [
        {
            required: true,
            message: "Пожалуйста, введите цену",
            trigger: "blur",
        },
    ],
    body: [
        {
            required: true,
            message: "Пожалуйста, введите контент",
            trigger: "blur",
        },
    ],
    photos: [{ validator: checkFileList, trigger: "change" }],
});

function checkFileList() {
    return new Promise((resolve, reject) => {
        if (fileList.value.length < 3) {
            reject("Вы должны загрузить минимум 3 изображения!");
        } else if (fileList.value.length > 10) {
            reject("Вы можете загрузить максимум 10 изображений!");
        } else {
            resolve();
        }
    });
}
function change({ coordinates, canvas }) {
    console.log(coordinates, canvas);
}

function getBase64(img, callback) {
    if (!img) return;
    const reader = new FileReader();
    reader.addEventListener("load", () => {
        if (typeof callback === "function") {
            callback(reader.result);
        }
    });
    reader.readAsDataURL(img);
}

const beforeUpload = (file) => {
    const isJpgOrPng = file.type === "image/jpeg" || file.type === "image/png";
    if (!isJpgOrPng) {
        message.error("Вы можете загружать только JPG/PNG файл!");
        return false;
    }
    const isLt2M = file.size / 1024 / 1024 < 2;
    if (!isLt2M) {
        message.error("Изображение должно быть меньше 2MB!");
        return false;
    }
    return true;
};

const handleChange = (info) => {
    const newFileList = info.fileList.slice(-10);

    fileList.value = newFileList;
    if (info.file.status === "done" || info.file.status === "uploading") {
        loading.value = true;
    }

    if (info.file.status === "done") {
        getBase64(info.file.originFileObj, (url) => {
            loading.value = false;
            imageUrl.value = url;
        });
        images.value.push(info.file.originFileObj);
    }
};

const handlePreview = async (file) => {
    if (!file.url) {
        if (!file.url && !file.preview) {
            file.preview = await getBase64(file.originFileObj);
        }

        previewImage.value = file.thumbUrl;
    } else {
        previewImage.value = file.url;
    }
    previewVisible.value = true;
};

const handleCancel = () => {
    previewVisible.value = false;
};

// Dummy request to avoid actual file upload
const dummyRequest = ({ file, onSuccess }) => {
    setTimeout(() => {
        onSuccess("ok");
    }, 0);
};

const submit = () => {
    // let size = 0;
    // for (let i = 0; i < fileList.value.length; i++) {
    //     if (fileList.value?.[i].url) {
    //         size++;
    //     }
    // }
    formRef.value
        .validate()
        .then(() => {
            const formData = new FormData();
            formData.append("category_id", fields.value.category_id);
            formData.append("body", fields.value.body);
            formData.append("price", fields.value.price);
            formData.append("title", fields.value.title);
            images.value.forEach((image, index) => {
                formData.append(`images[${index}]`, image);
            });
            formData.append("_method", "PUT");

            axios
                .post(`/api/posts/${route.params.slug}`, formData)
                .then(() => {
                    fields.category_id = "";
                    fields.body = "";
                    fields.price = "";
                    fields.title = "";
                    urls.value = [];
                    images.value = [];
                    success.value = true;
                    errors.value = {};
                    fileList.value = [];
                    router.push({ name: "DashboardPostsList" });
                })
                .catch((e) => {
                    console.log(e);
                });
        })
        .catch((e) => {
            console.log(e);
        });
};

onMounted(() => {
    axios
        .get("/api/categories")
        .then((response) => (categories.value = response.data))
        .catch((error) => {
            console.log(error);
        });
    axios
        .get("/api/posts/" + route.params.slug)
        .then((response) => {
            fields.value = response.data.data;
            fields.value.price = parseInt(fields.value.price);
            // fields.value.img = response.data.data.images;
            // fileList.value = response.data.data.images;
        })
        .catch((error) => {
            console.log(error);
            // if (error.response.status === 403) {
            //     this.$router.push({ name: "DashboardPostsList" });
            // }
        });
});
</script>

<style>
.editPosts .ql-color {
    display: none !important;
}
.editPosts .ql-background {
    display: none !important;
}
.ql-image {
    display: none !important;
}
.create-post {
    background-color: #fff;
    padding: 0 3vw;
}

.ant-modal-footer {
    display: none !important;
}

input,
textarea,
select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 20px;
    font-size: 16px;
}

.add-post-btn {
    background-color: #e4606d;
    color: white;
    border: none;
    cursor: pointer;
    transition: 0.3s ease;
}

.add-post-btn:hover {
    transform: translateY(-4px);
}

.preview img {
    max-width: 100%;
    max-height: 120px;
}

.titlinput {
    width: 400px;
}

@media (max-width: 380px) {
    .titlinput {
        width: 250px;
    }
}

.error {
    color: red;
}
</style>
