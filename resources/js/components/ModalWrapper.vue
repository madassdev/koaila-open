<template>
  <div
    v-if="isOpen"
    class="fixed overflow-hidden top-0 right-0 left-0 bottom-0 z-50 bg-black bg-opacity-25 h-screen flex pt-32"
  >
    <div
      class="bg-white mx-auto rounded-xl relative"
      :class="`${width ?? 'w-[30vw]'} ${height ?? 'h-[30vh]'}`"
    >
      <div class="p-2 flex items-center justify-end">
        <Close @click="closeModal" class="cursor-pointer" />
      </div>
      <slot></slot>
    </div>
  </div>
</template>
<script>
import Close from "@/components/Icons/Close.vue";
export default {
  components: {
    Close,
  },
  props: {
    isOpen: {
      type: Boolean,
      default: false,
    },
    width: String,
    height: String,
  },

  computed: {
    styleSizeProps() {
      return "x";
      switch (this.size) {
        case "sm":
          return "w-1/3";
          break;
        case "md":
          return "w-1/2";
          break;
        case "lg":
          return "w-2/3";

        default:
          return "w-2/3";
          break;
      }
    },
  },
  methods: {
    closeModal() {
      this.$emit("close");
    },
  },
};
</script>