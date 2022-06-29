<template>
    <div class="form-floating mb-3">
        <input
            :type="type"
            tabindex="0"
            @input='handleInput($event)'
            :value="modelValue"
            class="form-control"
            :class="{
                'is-valid': errors.length === 0 && modelValue !== null && modelValue !== '',
                'is-invalid': errors.length > 0
            }"
            :readonly="isReadonly"
        />
        <label>{{ label }}</label>
        <div v-if="errors.length > 0 " class="invalid-feedback">
            <ul>
                <li v-for="error in errors">{{ error.$message }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'FormInput',
    emits: ['update:modelValue'],
    props: {
        modelValue: {
            type: String,
            required: false
        },
            label: {
            required: true,
            type: String,
        },
            type: {
            required: false,
            default: 'text'
        },
        validator: {
            required: false
        },
        errors: {
            required: false,
            default: []
        },
        isReadonly: {
            required: false,
            default: false
        }
    },
    data() {
        return {
            v$: this.validator,
        }
    },
    methods: {
        handleInput($event) {
            this.$emit("update:modelValue", $event.target.value);
            if (this.v$ === undefined) return;
            this.v$.$validate(); console.log(123);
        }
    },
}
</script>

<style lang="scss">
</style>
