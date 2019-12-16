<template>
    <div class="flex items-center text-gray-700">
        <div v-for="r in post.reactions" :key="r.id" @click="toggle({ name: r.emoji_name, emoji: r.emoji })" :class="{ 'bg-blue-100 hover:bg-blue-300 border border-2 border-blue-500': r.user_reacted, 'bg-gray-200 hover:bg-gray-300': !r.user_reacted }" class="px-2 py-1 mr-1 text-center text-sm text-gray-700 rounded-full cursor-pointer">
            {{ r.emoji }}{{ r.count }}
        </div>

        <emoji-picker
            v-if="auth"
            :post="post"
        ></emoji-picker>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import EmojiPicker from './EmojiPicker'
import { events } from '../events'

export default {
    components: {
        EmojiPicker
    },
    props: {
        post: Object
    },
    mounted() {
        var self = this

        window.ChatterEvents.$on(events.EMOJI_CHANGED, ({emoji, post}) => {
            if (self.post.id === post.id) {
                self.toggle(emoji)
            }
        })
    },
    computed: {
        ...mapGetters([ 'auth' ])
    },
    methods: {
        toggle(emoji) {
            var self = this;

            axios.post('/api/chatter/post/react/' + this.post.id, {
                emoji_name: emoji.name,
                emoji: emoji.emoji
            })
            .then(response => {
                self.post.reactions = response.data.reactions
            })
            .catch(error => {
                console.error(error)
            })
        }
    }
}
</script>

<style scoped>
@-webkit-keyframes heartBeat {
  0% {
    -webkit-transform: scale(1);
    transform: scale(1);
  }

  14% {
    -webkit-transform: scale(1.3);
    transform: scale(1.3);
  }

  28% {
    -webkit-transform: scale(1);
    transform: scale(1);
  }

  42% {
    -webkit-transform: scale(1.3);
    transform: scale(1.3);
  }

  70% {
    -webkit-transform: scale(1);
    transform: scale(1);
  }
}

@keyframes heartBeat {
  0% {
    -webkit-transform: scale(1);
    transform: scale(1);
  }

  14% {
    -webkit-transform: scale(1.3);
    transform: scale(1.3);
  }

  28% {
    -webkit-transform: scale(1);
    transform: scale(1);
  }

  42% {
    -webkit-transform: scale(1.3);
    transform: scale(1.3);
  }

  70% {
    -webkit-transform: scale(1);
    transform: scale(1);
  }
}

.heartBeat {
    -webkit-animation-name: heartBeat;
    animation-name: heartBeat;
    -webkit-animation-duration: .75s;
    animation-duration: .75s;
    -webkit-animation-timing-function: ease-in-out;
    animation-timing-function: ease-in-out;
}
</style>