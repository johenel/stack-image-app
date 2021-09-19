<template>
    <transition name="modal">
        <div class="modal-mask" >
            <div class="modal-wrapper"
                 @click="clickModalWrapper($event)">
                <div
                      class="modal-container loading flex flex-col justify-between relative"
                     :style="{width: width, height: height}"
                     @click="$event.stopPropagation()">
                     <div style="height:10px;width:100%;background:var(--burgundy3);position:absolute;top:0;left:0px">
                     </div>
                    <div class="modal-header">
                        <slot name="header">
                            <h2  class="font-bold text-black-50">
                                {{ title }}
                            </h2>
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot></slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            <div class="flex flex-row justify-end">
                                <button class="button danger"
                                        @click="$emit('close')">
                                    Close
                                </button>
                            </div>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: "pop-up",
    props: {
        title: {
            required: false,
            default: ''
        },

        width: {
            required: false,
            default: '35rem',
            type: String
        },

        height: {
            required: false,
            default: 'auto',
            type: String
        },

        wrapper_click_close: {
            required: false,
            type: Boolean,
            default: true
        }
    },

    data() {
        return {

        }
    },

    mounted() {

    },

    methods: {
        close() {
            this.$emit('close')
        },

        clickModalWrapper(e) {
            e.stopPropagation();
            if (this.wrapper_click_close) {
                this.$emit('close')
            }
        }
    }
}
</script>

<style scoped>
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: top;
    padding-top: 10rem;
}

.modal-container {
    margin: 0 auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
    font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
    margin-top: 0;
    color: #42b983;
}

.modal-body {
    margin: 20px 0;
}

.modal-default-button {
    float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
    opacity: 0;
}

.modal-leave-active {
    opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}

</style>
