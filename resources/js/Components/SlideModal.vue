<script setup>
defineProps(
{
    show: 
    {
        type: Boolean,
        default: false,
    },
    title:
    {
        type: String,
        required: true,
    },
})

defineEmits(['close'])
</script>

<template>
  <Transition name="fade">
    <div
      v-if="show"
      class="fixed inset-0 bg-black/40 z-40"
      @click.self="$emit('close')"
    >
      <Transition name="slide">
        <div
          v-if="show"
          class="fixed top-0 right-0 h-full w-full max-w-md bg-white z-50 flex flex-col shadow-none border-l border-gray-200"
        >
          <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="text-sm font-medium text-gray-800">{{ title }}</h2>
            <button
              @click="$emit('close')"
              class="text-gray-400 hover:text-gray-600 transition-colors"
            >
              <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path d="M4 4l10 10M14 4L4 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
            </button>
          </div>

          <div class="flex-1 overflow-y-auto px-6 py-5">
            <slot />
          </div>

          <div class="px-6 py-4 border-t border-gray-100">
            <slot name="footer" />
          </div>

        </div>
      </Transition>
    </div>
  </Transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.25s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.slide-enter-active,
.slide-leave-active {
  transition: transform 0.25s ease;
}
.slide-enter-from,
.slide-leave-to {
  transform: translateX(100%);
}
</style>