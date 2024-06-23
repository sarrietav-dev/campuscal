<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { Input } from './ui/input';

const model = defineModel<string>({ required: true });

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <Input
        v-model="model"
        ref="input"
    />
</template>
