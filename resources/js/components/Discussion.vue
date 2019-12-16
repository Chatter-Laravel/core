<template>
    <div class="flex cursor-pointer items-center flex-col md:flex-row md:hover:bg-gray-200 hover:rounded-lg md:px-6 md:py-4 mb-6 md:mb-0 transition-all px-6 py-5 md:px-0 md:py-0 rounded-lg -mx-2 md:mx-0">
        <div class="w-full md:w-auto md:mr-6 flex items-center md:block mb-4 md:mb-0">
            <span class="icon mr-3 md:mr-0">
                <img
                    :alt="discussion.user.username" width="50" height="50"
                    class="bg-white relative rounded-full"
                    style="max-width: none; max-height: 50px;"
                    :src="discussion.user.avatar" />
            </span>
            <strong class="uppercase md:hidden">{{ discussion.user.username }}</strong>

            <div class="flex md:hidden items-center justify-center ml-auto">
                <span class="mr-3 inline-flex text-white rounded-full h-6 px-3 justify-center items-center text-xs" :style="`background-color: ${discussion.category.color}`">{{ discussion.category.name }}</span>

                <div class="flex bg-gray-200 rounded-full h-6 items-center">
                    <div class="flex py-2 px-3 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 15 14" class="mr-2">
                            <path fill="#78909C" fill-rule="evenodd"
                                d="M7.5 0C3.344 0 0 2.818 0 6.286c0 1.987 1.094 3.757 2.781 4.914l.117 2.35c.022.438.338.58.704.32l2.023-1.442c.594.144 1.219.18 1.875.18 4.156 0 7.5-2.817 7.5-6.285C15 2.854 11.656 0 7.5 0z"
                                opacity=".5"></path>
                        </svg>
                        <span class="text-xs text-gray-800 font-semibold leading-none">{{ discussion.answers }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full md:pr-10 lg:pr-0 lg:w-5/6 md:mb-0">
            <div class="lg:pr-10">
                <h4 class="mb-3 md:mb-1 text-base md:text-lg font-bold md:font-semibold tracking-tight text-gray-900 hover:text-gray-900" style="word-break: break-word;">
                    {{ discussion.title }}

                    <span class="hidden md:inline-flex text-white rounded-full h-4 px-3 justify-center items-center text-xs lowercase" :style="`background-color: ${discussion.category.color}`">{{ discussion.category.name }}</span>
                </h4>
                
                <div v-if="discussion.last_replay" class="text-gray-800 text-xs">
                    <span class="text-blue-600 uppercase font-bold">
                        {{ discussion.last_replay.user.username }}
                    </span>
                    replied
                    <span class="font-bold">
                        {{ discussion.last_replay.time_ago }}
                    </span>
                </div>
            </div>
        </div>
        <div class="hidden md:flex md:items-center md:flex-row-reverse text-center md:ml-auto relative" style="top: -10px;">
            <div class="flex items-center justify-center ml-4">
                <div class="mr-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="19" viewBox="0 0 15 10"
                        class="relative" style="top: -2px;">
                        <path fill="#78909C" fill-rule="evenodd"
                            d="M7.5 0C3.344 0 0 2.818 0 6.286c0 1.987 1.094 3.757 2.781 4.914l.117 2.35c.022.438.338.58.704.32l2.023-1.442c.594.144 1.219.18 1.875.18 4.156 0 7.5-2.817 7.5-6.285C15 2.854 11.656 0 7.5 0z"
                            opacity=".5"></path>
                    </svg>
                </div>
                <span class="text-xs text-gray-800 font-semibold text-left leading-none relative">{{ discussion.answers }}</span>
            </div>
            <div class="flex items-center justify-center">
                <div class="mr-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="13" viewBox="0 0 19 13">
                        <g fill="none" fill-rule="evenodd">
                            <path d="M0-3h19v19H0z"></path>
                            <path fill="#78909C"
                                d="M9.5.562C5.542.562 2.161 3.025.792 6.5c1.37 3.475 4.75 5.937 8.708 5.937s7.339-2.462 8.708-5.937C16.838 3.025 13.458.562 9.5.562zm0 9.896A3.96 3.96 0 0 1 5.542 6.5 3.96 3.96 0 0 1 9.5 2.542 3.96 3.96 0 0 1 13.458 6.5 3.96 3.96 0 0 1 9.5 10.458zm0-6.333A2.372 2.372 0 0 0 7.125 6.5 2.372 2.372 0 0 0 9.5 8.875 2.372 2.372 0 0 0 11.875 6.5 2.372 2.372 0 0 0 9.5 4.125z"
                                opacity=".5"></path>
                        </g>
                    </svg>
                </div>
                <span class="text-xs text-gray-800 font-semibold text-left leading-none">{{ discussion.views }}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        discussion: Object
    }
}
</script>