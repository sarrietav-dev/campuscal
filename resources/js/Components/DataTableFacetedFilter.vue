<script setup lang="ts">
import type { Column } from "@tanstack/vue-table";
import { computed } from "vue";
import { cn } from "@/lib/utils";
import {
    Popover,
    PopoverTrigger,
    PopoverContent,
} from "@/Components/ui/popover";
import { PlusCircleIcon, CheckIcon } from "lucide-vue-next";
import { Separator } from "radix-vue";
import { Badge } from "@/Components/ui/badge";
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
    CommandSeparator,
} from "@/Components/ui/command";
import { Button } from "@/Components/ui/button";

interface DataTableFacetedFilter {
    column?: Column<Request, string>;
    title?: string;
    options: {
        label: string;
        value: string;
    }[];
}

const props = defineProps<DataTableFacetedFilter>();

const facets = computed(() => props.column?.getFacetedUniqueValues());

const selectedValues = computed(
    () => new Set(props.column?.getFilterValue() as string[]),
);

const handleSelect = (option: { label: string; value: string }) => {
    const isSelected = selectedValues.value.has(option.value);
    if (isSelected) {
        selectedValues.value.delete(option.value);
    } else {
        selectedValues.value.add(option.value);
    }
    const filterValues = Array.from(selectedValues.value);
    props.column?.setFilterValue(
        filterValues.length > 0 ? filterValues : undefined,
    );
};
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button variant="outline" size="sm" class="h-8 border-dashed">
                <PlusCircleIcon class="mr-2 h-4 w-4" />
                {{ title }}
                <template v-if="selectedValues.size > 0">
                    <Separator orientation="vertical" class="mx-2 h-4" />
                    <Badge
                        variant="secondary"
                        class="rounded-sm px-1 font-normal lg:hidden"
                    >
                        {{ selectedValues.size }}
                    </Badge>
                    <div class="hidden space-x-1 lg:flex">
                        <Badge
                            v-if="selectedValues.size > 2"
                            variant="secondary"
                            class="rounded-sm px-1 font-normal"
                        >
                            {{ selectedValues.size }} seleccionado
                        </Badge>

                        <template v-else>
                            <Badge
                                v-for="option in options.filter((option) =>
                                    selectedValues.has(option.value),
                                )"
                                :key="option.value"
                                variant="secondary"
                                class="rounded-sm px-1 font-normal"
                            >
                                {{ option.label }}
                            </Badge>
                        </template>
                    </div>
                </template>
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-[200px] p-0" align="start">
            <Command
                :filter-function="
                    (list: Record<string, any>, term) =>
                        list.filter((i: any) =>
                            i.value.toLowerCase()?.includes(term),
                        ) as Record<string, any>[]
                "
            >
                <CommandList>
                    <CommandEmpty>
                        No hay resultados para la búsqueda
                    </CommandEmpty>
                    <CommandGroup>
                        <CommandItem
                            v-for="option in options"
                            :key="option.value"
                            :value="option.value"
                            @select="handleSelect(option)"
                        >
                            <div
                                :class="
                                    cn(
                                        'mr-2 flex h-4 w-4 items-center justify-center rounded-sm border border-primary',
                                        selectedValues.has(option.value)
                                            ? 'bg-primary text-primary-foreground'
                                            : 'opacity-50 [&_svg]:invisible',
                                    )
                                "
                            >
                                <CheckIcon class="size-4" />
                            </div>
                            <span>{{ option.label }}</span>
                            <span
                                v-if="facets?.get(option.value)"
                                class="ml-auto flex h-4 w-4 items-center justify-center font-mono text-xs"
                            >
                                {{ facets.get(option.value) }}
                            </span>
                        </CommandItem>
                    </CommandGroup>

                    <template v-if="selectedValues.size > 0">
                        <CommandSeparator />
                        <CommandGroup>
                            <CommandItem
                                :value="{ label: 'Clear filters' }"
                                class="justify-center text-center"
                                @select="column?.setFilterValue(undefined)"
                            >
                                Limpiar filtros
                            </CommandItem>
                        </CommandGroup>
                    </template>
                </CommandList>
            </Command>
        </PopoverContent>
    </Popover>
</template>
