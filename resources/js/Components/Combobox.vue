<script setup lang="ts">
import { Check, ChevronsUpDown } from "lucide-vue-next";

import { ref } from "vue";
import { cn } from "@/lib/utils";
import { Button } from "@/Components/ui/button";
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
} from "@/Components/ui/command";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/Components/ui/popover";

defineProps<{
    options: { label: string; value: string }[];
    placeholder?: string;
}>();

const open = ref(false);
const model = defineModel<string>();
</script>

<template>
    <Popover v-model:open="open">
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                role="combobox"
                :aria-expanded="open"
                class="w-[200px] justify-between overflow-hidden"
            >
                <p class="truncate">
                    {{
                        model
                            ? options.find((option) => option.value === model)
                                  ?.label
                            : placeholder ?? "Seleccionar..."
                    }}
                </p>

                <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-[200px] p-0">
            <Command v-model="model">
                <CommandList>
                    <CommandGroup>
                        <CommandItem
                            v-for="option in options"
                            :key="option.value"
                            :value="option.value"
                            @select="open = false"
                        >
                            <Check
                                :class="
                                    cn(
                                        'mr-2 h-4 w-4',
                                        model === option.value
                                            ? 'opacity-100'
                                            : 'opacity-0',
                                    )
                                "
                            />
                            {{ option.label }}
                        </CommandItem>
                    </CommandGroup>
                </CommandList>
            </Command>
        </PopoverContent>
    </Popover>
</template>
