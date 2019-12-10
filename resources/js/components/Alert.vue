<!--
PURGE CSS
border-teal-500 text-teal-900 text-teal-500
border-red-500 text-red-900 text-red-500
border-blue-500 text-blue-900 text-blue-500
-->
<template>
    <transition name="fade">
        <div 
            v-show="alert.show" 
            class="flex"
            @mouseover="timer.pause()"
            @mouseleave="timer.resume()"
            @click="closeAlert()"
        >
            <div :class="`fixed bg-gray-100 border-t-4 border-${alert.color}-500 rounded-b text-${alert.color}-900 px-4 py-3 shadow-md w-full max-w-3xl sm:w-1/3 xl:w-2/6 lg:mt-2 lg:mr-4 lg:right-0`"
                role="alert"
                style="z-index: 99999999;">
                <div class="flex items-center">
                    <div class="py-3"><svg :class="`fill-current h-6 w-6 text-${alert.color}-500 mr-4`"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path
                                d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                            </svg></div>
                    <div>
                        <p class="font-bold">{{ alert.title }}</p>
                        <p v-if="alert.text !== null && alert.text !==''" class="text-sm">{{ alert.text }}</p>
                        <slot class="text-sm"></slot>
                    </div>
                </div>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="closeAlert(this);">
                    <svg class="fill-current h-6 w-6 text-gray-600" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </span>
            </div>
        </div>
    </transition>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex';
export default {
    computed: {
        ...mapGetters([
            'alert'
        ])
    },
    data() {
        let self = this;
        let timer = {};

        timer.timeout = 10000;
        timer.pause = function() {
            window.clearTimeout(timer.id);
            timer.timeout -= Date.now() - timer.start;
        };
        timer.resume = function() {
            timer.start = Date.now();
            window.clearTimeout(timer.id);
            timer.id = window.setTimeout(self.closeAlert, timer.timeout);
        };

        return {
            hover: false,
            timer
        }
    },
    mounted() {
        let self = this;

        setTimeout(function() {
            // self.showAlert();
            self.timer.resume();
        }, 200);
    },
    methods: {
        ...mapMutations([
            'showAlert',
            'hideAlert'
        ]),
        closeAlert() {
            this.hideAlert();
        },
    }
}
</script>