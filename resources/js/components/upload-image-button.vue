<template>
    <div>
        <modal v-if="show_modal" @close ="show_modal = false">
            <div class="flex flex-col gap-3">
                <div class="flex flex-col">
                    <b>Index:</b>
                    <select name="" id="" v-model="form.index" class="border rounded w-12 p-2">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                     </select>
                </div>
                <div class="flex flex-col">
                    <b>Select file</b>
                    <input type="file" id="imageFileInput">
                </div>
            </div>
            <template #footer>
                <div class="modal-footer flex flex-row justify-end mt-5 mb-3">
                    <button class="button success w-full"
                            @click="uploadImage">
                        Upload
                    </button>
                </div>
            </template>
        </modal>
        <button @click="show_modal = true">Add New Image</button>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                show_modal: false,
                form: {
                    index: 0
                }
            }
        },

        methods: {
            uploadImage() {

                let file = this.$el.querySelector('#imageFileInput')
                let form_data = new FormData

                form_data.append('image_file', file.files[0])
                form_data.append('index', this.form.index)

                axios.post('/api/images', form_data)
                .then(res => {
                    this.$emit('image_uploaded')
                    this.show_modal = false
                })
                .catch(err => {
                    let messages = [];
                    if (err.response.data.errors) {
                        let errors = Object.values(err.response.data.errors)
                        for (let error of errors) {
                            messages.push(error[0])
                        }
                    }

                    alert(messages.join('. '))
                })
            }
        }
    }
</script>
