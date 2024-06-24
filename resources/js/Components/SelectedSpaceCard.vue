<script setup lang="ts">
import { computed, getCurrentInstance } from "vue";
import { Trash } from "lucide-vue-next";

const props = defineProps<{
    spaceName: string;
    imageUrl: string;
    date: {
        from: string;
        to: string;
    };
}>();

const emit = defineEmits(["delete"]);

const hasDelete = computed(() => !!getCurrentInstance()?.vnode.props?.onDelete);
</script>

<template>
    <div
        :style="{ '--image-url': `url(${props.imageUrl})` }"
        class="group relative flex w-full items-center justify-center rounded-md border border-input bg-background bg-[image:var(--image-url)] bg-cover bg-center text-sm font-medium"
    >
        <button
            v-if="hasDelete"
            @click="emit('delete')"
            class="invisible absolute -right-3 -top-3 z-10 flex size-7 scale-0 cursor-pointer items-center justify-center rounded-full border border-input bg-background text-foreground transition group-hover:visible group-hover:scale-100"
        >
            <Trash class="h-4 w-4" />
        </button>
        <div
            class="flex size-full items-center justify-center space-x-3 rounded-md py-10 text-white backdrop-brightness-50 backdrop:rounded-md"
        >
            <span>{{ props.spaceName }}</span>
            <span>
                {{ props.date.from }} -
                {{ props.date.to }}
            </span>
        </div>
    </div>
</template>

<style scoped></style>
