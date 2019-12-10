<template>
    <div id="header" v-show="head.title !== null" class="flex flex-wrap w-full py-12 px-4 text-white items-center text-center">
        <div class="w-full text-center">
            <h1 class="text-3xl sm:text-4xl">{{ head.title }}</h1>
            <h2 class="hidden md:block w-full text-center text-lg sm:text-xl">{{ head.subtitle }}</h2>
        </div>
	</div>
</template>

<script>
import { mapGetters } from 'vuex';
import { TweenLite } from 'gsap'

export default {
    computed: {
        ...mapGetters({
            head: 'header',
        })
    },
    watch: {
        head: {
            handler(val){
                TweenLite.to('#header', 1, { backgroundColor: val.color });
            },
            deep: true
        }
    }
}
</script>