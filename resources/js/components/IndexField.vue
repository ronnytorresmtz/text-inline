<template>
  <div>
    <input
      v-if="field.inlineOnIndex && isEditable"
      :id="fieldId"
      ref="input"
      type="text"
      class="w-full form-control form-input form-input-bordered"
      :class="errorClasses"
      :placeholder="field.name"
      v-model="value"
      v-on="listener"
      :disabled="field.readonly"
      @keyup.esc="isEditable=false"
      @blur="isEditable=false"
      tabindex="0"
    />
    <span v-else class="whitespace-no-wrap cursor-pointer" @click="isEditable=true">{{ field.value }}</span>
  </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';

export default {
  
  mixins: [FormField, HandlesValidationErrors],
  
  props: ['resourceName', 'field'],

  created() {

        document.addEventListener('keyup', (evt) => {
            if (evt.keyCode === 27) {
                this.isEditable = false;
            }
        });
    },

  data:() => {
    return {
      isEditable: false,
    };
  },

  methods: {
    submit() {
      this.isEditable = false;
      let formData = new FormData();
      formData.append(this.field.attribute, this.value);
      formData.append('_method', 'PUT');

      this.field.value = this.value;

      return Nova.request()
        .post(
          `/nova-api/${this.resourceName}/${this.$parent.resource.id.value}`,
          formData
        )
        .then(
          () => {
              
            this.$toasted.show(`${this.field.name} updated to ${this.value.substring(0,20)} ...`, {
              type: 'success',
            });
          },
          (response) => this.$toasted.show(response, { type: 'error' })
        )
    },
    capitalize(string) {
      return string.charAt(0).toUpperCase() + string.substr(1);
    },
  },
  computed: {
    resourceId() {
      return this.$parent.resource.id.value;
    },
    fieldId() {
      return `text-inline-field-${this.field.name}-${this.resourceId}`;
    },
    listener() {
      const event = this.field.event.split('.');
      const name = event[0];
      const modifier = event[1] ? this.capitalize(event[1]) : null;
      return {
        [name]: (e) => {
          if (this.valueWasNotChanged) return;
          if (modifier && modifier === e.key) this.submit();
          if (!modifier) this.submit();
        },
      };
    },
    valueWasNotChanged() {
      return this.value === this.field.value;
    },
  },
};
</script>
