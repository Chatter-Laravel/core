<template>
    <div @click="onClick" class="border border-blue-600 text-blue-800 hover:bg-blue-200 text-white font-bold py-2 px-4 rounded-full text-center cursor-pointer">
        Ask a question
    </div>
</template>

<script>
import { events } from '../events'

export default {
    methods: {
        onClick() {
            window.ChatterEvents.$emit(events.NEW_DISCUSSION)
        }
    }
}
</script>