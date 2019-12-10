<template>
    <div @click="onClick" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full text-center cursor-pointer">
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