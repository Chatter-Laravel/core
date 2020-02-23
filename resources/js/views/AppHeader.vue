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
import { TweenLite, CSSPlugin } from "gsap/all";

/**
 * Do not remove
 * 
 * https://greensock.com/docs/v2/NPMUsage
 */
const plugins = [ TweenLite, CSSPlugin ];
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