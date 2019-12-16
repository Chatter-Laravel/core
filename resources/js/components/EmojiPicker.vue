<template>
    <div class="flex">
        <div class="flex items-center w-8 h-8 rounded-full justify-center text-white text-lg font-bold bg-gray-300 hover:bg-gray-400 cursor-pointer" @click="openPicker()">+</div>
        
        <transition name="fade">
            <div v-if="pickerOpened" class="flex flex-wrap absolute w-full mt-10 left-0 sm:left-auto sm:mt-0 sm:ml-10 sm:w-64 h-16 bg-gray-200 sm:rounded sm:shadow p-2 text-lg">
                <div class="flex w-full pb-2">
                    <div class="w-2/4">Pick a reaction</div>
                    <div class="w-2/4 w-6 h-6 close opacity-50 hover:opacity-100 cursor-pointer" @click="closePicker()"></div>
                </div>

                <div class="w-full flex flex-wrap">
                    <div v-for="e in emojis" :key="e.name" @click="emojiPicked(e)" class="flex-grow cursor-pointer">
                        {{ e.emoji }}
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import { events } from '../events'

export default {
    props: {
        post: Object
    },
    data() {
        return {
            pickerOpened: false,
            emojis: [
                {
                    name: ':thumbs_up:',
                    emoji: '👍'
                },
                {
                    name: ':thumbs_down:',
                    emoji: '👎'
                },
                {
                    name: ':smile:',
                    emoji: '😁'
                },
                {
                    name: ':tada:',
                    emoji: '🎉'
                },
                {
                    name: ':confused:',
                    emoji: '😕'
                },
                {
                    name: ':heart:',
                    emoji: '❤️'
                },
                {
                    name: ':rocket:',
                    emoji: '🚀'
                },
                {
                    name: ':raising:',
                    emoji: '🙌'
                }
            ]
        }
    },
    mounted() {
        var self = this

        window.ChatterEvents.$on(events.CLOSE_ALL_REACTION_PICKERS, () => {
            self.pickerOpened = false
        })
    },
    methods: {
        openPicker() {
            window.ChatterEvents.$emit(events.CLOSE_ALL_REACTION_PICKERS)
            this.pickerOpened = true
        },
        closePicker() {
            window.ChatterEvents.$emit(events.CLOSE_ALL_REACTION_PICKERS)
        },
        emojiPicked(emoji) {
            window.ChatterEvents.$emit(events.EMOJI_CHANGED, { emoji, post: this.post })
            this.closePicker()
        }
    }
}
</script>

<style scoped>
.close {
    position: absolute;
    right: 0;
}
.close:before, .close:after {
  position: absolute;
  right: 15px;
  content: ' ';
  height: 20px;
  width: 2px;
  background-color: #333;
}
.close:before {
  transform: rotate(45deg);
}
.close:after {
  transform: rotate(-45deg);
}
</style>