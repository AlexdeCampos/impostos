<template>
  <div class="form-container">
    <h6>{{ titulo }}</h6>
    <form @submit.prevent="$emit('formSubmit')">
      <slot name="formulario-body"> </slot>
      <div class="footer">
        <slot name="formulario-footer"></slot>
      </div>
    </form>
  </div>
</template>
<script>
export default {
  props: {
    titulo: {
      type: String,
      required: true,
    },
  },
};
</script>
<style scoped>
.footer {
  margin-top: 5px;
}

.form-container {
  border: 1px solid #000;
  padding: 10px;
  margin-bottom: 10px;
}
</style>