<template>
    <div v-if="!loading && this.getter.last_page > 1" class="w-full">
        <ul class="flex justify-center pl-0 list-none rounded my-2 mx-auto">
            <li v-if="this.getter.page > 1" :class="liClass" class="rounded-l border-l">
                <router-link :to="{ name: this.route, query: { page: this.getter.page - 1 }}">
                    Previous
                </router-link>
            </li>
            <li v-if="this.getter.page > 2" :class="liClass">
                <router-link :to="{ name: this.route, query: { page: this.getter.page - 2 }}">
                    {{  this.getter.page - 2 }}
                </router-link>
            </li>
            <li v-if="this.getter.page > 1" :class="liClass">
                <router-link :to="{ name: this.route, query: { page: this.getter.page - 1 }}">
                    {{  this.getter.page - 1 }}
                </router-link>
            </li>
            <li :class="liClass" class="bg-gray-300">
                {{ this.getter.page }}
            </li>
            <li v-if="(this.getter.page + 1) <= this.getter.last_page" :class="liClass">
                <router-link :to="{ name: this.route, query: { page: this.getter.page + 1 }}">
                    {{  this.getter.page + 1 }}
                </router-link>
            </li>
            <li v-if="(this.getter.page + 2) <= this.getter.last_page" :class="liClass">
                <router-link :to="{ name: this.route, query: { page: this.getter.page + 2 }}">
                    {{ this.getter.page + 2 }}
                </router-link>
            </li>
            <li v-if="this.getter.page < this.getter.last_page" :class="liClass" class="rounded-r border-r">
                <router-link :to="{ name: this.route, query: { page: this.getter.page + 1 }}">
                    Next
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        getter: Object,
        route: String,
        loading: Boolean,
    },
    data() {
        return {
            liClass: "inline-block py-2 px-3 leading-tight bg-white border border-gray-300 text-blue-700 border-r-0 hover:bg-gray-200"
        }
    }
}
</script>