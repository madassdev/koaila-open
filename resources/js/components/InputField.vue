<template>
  <input
    :id="id"
    :type="type"
    :class="`${inputClass} ${isError && 'is-invalid'}`"
    :name="name"
    :value="value"
    :required="required"
    :autofocus="autofocus"
  />
</template>
  
  <script>
export default {
  props: {
    id: String,
    type: String,
    isError: Boolean,
    inputClass: {
      type: String,
      default:
        "form-control bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block p-2.5",
    },
    name: String,
    value: String,
    required: Boolean,
    autofocus: Boolean,
  },
};
</script>
  