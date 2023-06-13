<template>
  <div class="flex items-center space-x-4">
    <button
      @click="scrollToPrevious"
      class="text-xs transform rotate-180 rounded-full opacity-80 hover:opacity-100 bg-gray-500 hover:bg-gray-900 transition-all ease-in-out text-white flex items-center justify-center p-2 cursor-pointer"
    >
      <ChevronRight />
    </button>
    <div
      class="flex items-start overflow-x-scroll w-full relative select-none cursor-grab"
      @scroll="updateActiveSlideInView"
      @mousedown="startDrag"
      ref="cardRow"
    >
      <div
        class="bordser border-teal-400 space-y-4 flex flex-col items-center"
        v-for="(step, i) in items"
        :key="i"
      >
        <div class="flex items-center">
          <hr class="w-16" />
          <div
            class="z-10 flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full ring-0 ring-gray-100 shrink-0"
          >
            <svg
              aria-hidden="true"
              class="w-3 h-3 text-blue-800"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </div>
          <hr class="w-16" />
        </div>
        <p class="text-xs text-center px-3">
          {{ convertToWords(step) }}
        </p>
      </div>
    </div>
    <button
      @click="scrollToNext"
      class="text-xs rounded-full opacity-80 hover:opacity-100 bg-gray-500 hover:bg-gray-900 transition-all ease-in-out text-white flex items-center justify-center p-2 cursor-pointer"
    >
      <ChevronRight />
    </button>
  </div>
</template>
<script>
import ChevronRight from "./Icons/ChevronRight.vue";
export default {
  props: { saleFunnelData: Array },
  data() {
    return {
      items: this.saleFunnelData,
      activeSlide: 0,
      scrollWidth: 280,
    };
  },
  mounted() {
    console.log("tt", this.saleFunnelData);
  },

  methods: {
    // Converts  snake_cased string to capitalized words.
    convertToWords(string) {
      const stringWithSpaces = string.replace(/_/g, " ");
      const wordsArray = stringWithSpaces
        .split(" ")
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1));
      const wordsString = wordsArray.join(" ");
      return wordsString;
    },
    scrollToPrevious() {
      if (this.activeSlide > 0) {
        this.activeSlide--;
        this.scrollToActiveSlide();
      }
    },
    scrollToNext() {
      if (this.activeSlide < this.items.length - 1) {
        this.activeSlide++;
        this.scrollToActiveSlide();
      }
    },

    // Scrolls smoothly to active slide.
    scrollToActiveSlide() {
      const cardRow = this.$refs.cardRow;
      const scrollLeft = this.scrollWidth * this.activeSlide;

      // Reset active slide value.
      this.updateActiveSlideInView();

      // Scroll smoothly.
      cardRow.scrollTo({ left: scrollLeft, behavior: "smooth" });
    },

    // Resets activeSlide state to amount of scroll in interaction other than button click.
    updateActiveSlideInView() {
      const scrollAmount = this.$refs.cardRow.scrollLeft;
      this.activeSlide = scrollAmount / this.scrollWidth;
    },

    // Enables dragging on the sale funnel container.
    startDrag(event) {
      const cardRow = this.$refs.cardRow;

      // Capture initial scroll position  of container.
      const initialMouseX = event.clientX;
      const initialScrollX = cardRow.scrollLeft;

      //  Update the scroll position of the container based on the distance.
      const handleMouseMove = (event) => {
        const delta = event.clientX - initialMouseX;
        cardRow.scrollLeft = initialScrollX - delta;
      };

      //   Cleanup events.
      const handleMouseUp = () => {
        document.removeEventListener("mousemove", handleMouseMove);
        document.removeEventListener("mouseup", handleMouseUp);
      };
      document.addEventListener("mousemove", handleMouseMove);
      document.addEventListener("mouseup", handleMouseUp);
    },
  },
  components: { ChevronRight },
};
</script>
