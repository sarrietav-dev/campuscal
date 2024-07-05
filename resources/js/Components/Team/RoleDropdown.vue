<script setup lang="ts">
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/Components/ui/popover";
import { Button } from "@/Components/ui/button";
import { ChevronDownIcon } from "lucide-vue-next";
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
} from "@/Components/ui/command";
import { ref } from "vue";

const props = defineProps<{
    roles: {
        name: string;
        display_name: string;
        description?: string;
    }[];
}>();

defineSlots<{
    default: void;
    trigger: void;
}>();

const model = defineModel<string>();
const open = ref(false);
</script>

<template>
    <Popover v-model="open">
        <PopoverTrigger as-child>
            <slot name="trigger">
                <Button variant="outline">
                    {{ model || "Selecciona un rol" }}
                    <ChevronDownIcon
                        class="ml-2 h-4 w-4 text-muted-foreground"
                    />
                </Button>
            </slot>
        </PopoverTrigger>
        <PopoverContent class="p-0">
            <Command v-model="model">
                <CommandInput placeholder="Ningún rol encontrado" />
                <CommandList>
                    <CommandEmpty> No se encontraron roles </CommandEmpty>
                    <CommandGroup>
                        <CommandItem
                            v-for="role in props.roles"
                            :value="role.name"
                            class="space-y-1 flex flex-col items-start px-4 py-2"
                            @select="() => $emit('update:model', role.name)"
                        >
                            <p>{{ role.display_name }}</p>
                            <p
                                class="text-sm text-muted-foreground"
                                v-if="role.description"
                            >
                                {{ role.description }}
                            </p>
                        </CommandItem>
                    </CommandGroup>
                </CommandList>
            </Command>
        </PopoverContent>
    </Popover>
</template>
