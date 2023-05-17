<script setup>
import { ref } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import vueFilePond from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";

// Import styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import { computed } from "vue";

// Create FilePond component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

const page = usePage();
const pond = ref(null);
const files = ref([]);
const csrf = computed(() => page.props.csrf_token);

const form = useForm({
    title: "",
    description: "",
});
</script>

<template>
    <GuestLayout>
        <Head title="Store the Post" />

        <form @submit.prevent="form.post('/')">
            <div>
                <InputLabel for="title" value="Title" />

                <TextInput
                    id="title"
                    type="title"
                    class="mt-1 block w-full p-2 bg-slate-100 border"
                    v-model="form.title"
                    placeholder="Title"
                />

                <InputError class="mt-2" :message="form.errors.title" />
            </div>

            <div class="mt-4">
                <InputLabel for="description" value="Description" />

                <textarea
                    id="message"
                    rows="4"
                    v-model="form.description"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Write your thoughts here..."
                ></textarea>

                <InputError class="mt-2" :message="form.errors.description" />
            </div>
            <div class="mt-4">
                <file-pond
                    name="image"
                    ref="pond"
                    class-name="my-pond"
                    label-idle="Drop files here..."
                    allow-multiple="true"
                    accepted-file-types="application/pdf"
                    :files="files"
                    :server="{
                        process: '/upload',
                        revert: '/revert',
                        headers: {
                            'X-CSRF-TOKEN': $page.props.csrf_token,
                        },
                    }"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Store Post
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
