<template>
    <transition name="fade">
        <div v-if="show" class="w-full p-2 sm:p-4">
            <div class="flex flex-wrap p-2 sm:p-4 bg-gray-200 rounded shadow">
                <div class="w-full">
                    Don't want to be seen with your name? Setup a username to be visible on the forum
                </div>
                <div v-if="error" class="w-full pt-2 text-red-700">
                    {{ error }}
                </div>
                <div class="w-full pt-2">
                    <span class="inline-block">Username: </span>
                    <input v-model="username" name="username" class="inline-block appearance-none bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" />
                    <div @click="save()" class="w-32 inline-block bg-gray-400 hover:bg-gray-500 font-bold py-2 px-4 rounded-full text-center cursor-pointer ml-2">
                        Save
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    data() {
        return {
            show: false,
            username: null,
            error: null
        }
    },
    mounted() {
        var self = this

        setTimeout(() => self.show = true, 2000)
    },
    methods: {
        save() {
            var self = this

            axios.post('/api/chatter/username', { username: self.username })
                .then(response => {
                    self.error = null
                    self.show = false
                })
                .catch(error => {
                    if (error.response.status) {
                        self.error = error.response.data.errors.username[0]
                    } else {
                        console.error(error)
                    }
                })

        }
    }
}
</script>