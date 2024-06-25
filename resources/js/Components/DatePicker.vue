<script setup lang="ts">
import { ref } from "vue";
import {
    DateFormatter,
    type DateValue,
    getLocalTimeZone,
} from "@internationalized/date";

import { Calendar as CalendarIcon } from "lucide-vue-next";
import { Calendar } from "@/Components/ui/calendar";
import { Button } from "@/Components/ui/button";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/Components/ui/popover";
import { RangeCalendar } from "@/Components/ui/range-calendar";
import { DateRange } from "radix-vue";

const props = defineProps<{
    range?: boolean;
}>();

const df = new DateFormatter("en-US", {
    dateStyle: "long",
});

const value = defineModel<DateRange>();
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                class="w-[280px] justify-start text-left font-normal"
                :class="{ 'text-muted-foreground': !value }"
            >
                <CalendarIcon class="mr-2 h-4 w-4" />
                {{
                    value
                        ? df.format(value.toDate(getLocalTimeZone()))
                        : "Pick a date"
                }}
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <RangeCalendar
                v-if="props.range"
                locale="es-ES"
                v-model="value"
                initial-focus
                :number-of-months="2"
            />
            <Calendar v-else locale="es-ES" initial-focus />
        </PopoverContent>
    </Popover>
</template>
