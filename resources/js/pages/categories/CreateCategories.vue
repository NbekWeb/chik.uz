<template>
    <div class="container create_category">
        <div>
            <h1 class="pt-3 text-center">Создать новую категорию!</h1>
            <div class="success-msg" v-if="success">
                <i class="fa fa-check"></i>
                Категория успешно создана
            </div>
            <a-modal v-model:open="previewVisible">
                <img
                    :src="previewImage"
                    alt="Image Preview"
                    style="width: 100%"
                />
            </a-modal>
            <div class="mt-5 max-w-[450px] mb-3">

                <a-form
                    ref="formRef"
                    :model="formState"
                    name="horizontal_login"
                    layout="vertical"
                    :rules="rules"
                >
                    <a-form-item label="Название" name="name">
                        <a-input v-model:value="formState.name"></a-input>
                    </a-form-item>

                    <a-form-item label="Фото" name="photos">
                        <a-upload
                            v-model:file-list="fileList"
                            list-type="picture-card"
                            accept=".jpg,.jpeg,.png"
                            class="avatar-uploader w-[300px]"
                            :show-upload-list="true"
                            :before-upload="beforeUpload"
                            @change="handleChange"
                            @preview="handlePreview"
                            :customRequest="dummyRequest"
                            multiple
                        >
                            <div v-if="fileList.length < 1">
                                <PlusOutlined />
                                <div class="ant-upload-text">Загрузить</div>
                            </div>
                        </a-upload>
                    </a-form-item>

                    <a-form-item label="Menu Id" name="menu_id">
                        <a-input v-model:value="formState.menu_id"></a-input>
                        <span v-if="errors.menu_id" class="error">{{
                            errors.menu_id[0]
                        }}</span>
                    </a-form-item>

                    <a-button type="primary" @click="submit">Добавить</a-button>
                </a-form>
            </div>
            <div class="pb-3 text-center create-categories">
                <router-link :to="{ name: 'CategoriesList' }"
                    >Список категорий <span>&#8594;</span></router-link
                >
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import axios from "axios";
import { PlusOutlined } from "@ant-design/icons-vue";
import { message } from "ant-design-vue";

const loading = ref(false);
const imageUrl = ref("");

const formState = ref({
    name: "",
    menu_id: "",
    img: null,
});

const dummyRequest = ({ file, onSuccess }) => {
    setTimeout(() => {
        onSuccess("ok");
    }, 0);
};

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
    if (!file.url && !file.preview) {
        file.preview = await getBase64(file.originFileObj);
    }
    previewImage.value = file.thumbUrl;
    previewVisible.value = true;
};

const fileList = ref([]);
const previewImage = ref("");
const previewVisible = ref(false);
const images = ref([]);
const errors = ref({});
const success = ref(false);
const formRef = ref(null);

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

const rules = reactive({
    name: [
        {
            required: true,
            message: "Пожалуйста, введите заголовок",
            trigger: "blur",
        },
    ],
    menu_id: [
        {
            required: true,
            message: "Пожалуйста, введите заголовок",
            trigger: "blur",
        },
    ],
    photos: [{ validator: checkFileList, trigger: "change" }],
});



function checkFileList() {
    return new Promise((resolve, reject) => {
        if (fileList.value.length < 1) {
            reject("Изображение обязательно!");
        } else {
            resolve();
        }
    });
}

const submit = () => {
    formRef.value
        .validate()
        .then(() => {
            const formData = new FormData();
            formData.append("name", formState.value.name);
            formData.append("menu_id", formState.value.menu_id);
            formData.append(`photo`, images.value[0]);

            axios
                .post("/api/categories/create", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(() => {
                    formState.value = {
                        name: "",
                        menu_id: "",
                        img: null,
                    };
                    fileList.value = [];
                    message.success("Меню успешно добавлено!");
                })
                .catch((error) => {
                    message.error(error.message);
                });
        })
        .catch((e) => {
            console.log("Validation failed:", e);
        });
};
</script>

<style scoped>
#create-categories {
    background-color: #f3f4f6;
    height: 90vh;
    padding: 50px;
}

.success-msg {
    color: green;
}

.error {
    color: red;
}

#contact-us input {
    padding: 5px !important;
}
</style>
