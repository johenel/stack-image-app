<template>
    <div class="flex flex-col">
        <div class="flex flex-row justify-between">
            <upload-image-button @image_uploaded="loadImages"></upload-image-button>
            <button class="bg-red-500" @click="clearImages">Clear Images</button>
        </div>
        <div class="flex flex-col p-4 my-5">
            <div v-for="(image_set, index) in images" :key="index" class="flex flex-row">
                <div class="p-5 border flex flex-col justify-center">
                    <b style="font-size:2rem">{{index}}</b>
                </div>
                <div v-for="(is, i) in image_set" :key="i" class="p-5 border">
                    <img :src="is['image_url']" alt="" style="width:5rem;height:5rem">
                </div>
            </div>
        </div>
        <button @click="generate" style="width:fit-content" class="my-5">Generate</button>
        <div class="grid grid-flow-row grid-cols-3 gap-5">
            <div v-for="(images, index) in combinations" :key="index" style="position:relative" class="flex flex-col justify-center text-center w-32 h-32">
                <img v-for="image in images" :key="image" :src="image" style="position:absolute;top:0;left:0" class="w-32 h-32">
            </div>
        </div>
    </div>
</template>
<script>
import uploadImageButton from '../components/upload-image-button.vue'
    export default {
  components: { uploadImageButton },
        data() {
            return {
                images: [],
                combinations: []
            }
        },

        mounted() {
            this.loadImages()
        },

        methods: {
            loadImages() {
                axios.get('/api/images')
                .then(res => {
                    this.images = res.data
                })
            },

            generate() {
                axios.get('/api/images/combinations/generate')
                .then(res => {
                    this.combinations = res.data
                })
            },

            clearImages() {
                axios.delete('/api/images/clear')
                .then(res => {
                    this.loadImages()
                })
            }
        }
    }
</script>
