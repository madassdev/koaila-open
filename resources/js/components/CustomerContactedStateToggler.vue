<template>
  <form method="POST" ref="contactUpdateForm" :action="`/update-customer-contacted-state/` + customer.id">
    <input type="hidden" name="_token" :value="csrfToken" />
    <input type="checkbox" v-model="isChecked" name="contacted" id="" @change="updateContactStatus" />
  </form>
</template>

<script>
export default {
  props: { customer: Object },
  data() {
    return {
      isChecked: this.customer.contacted,
      csrfToken: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    };
  },
  methods: {
    // Updates the backend after confirmation
    updateContactStatus() {
      // Submit tne form
      this.$refs.contactUpdateForm.submit();
    },
  },
};
</script>
