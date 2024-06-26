<script setup lang="ts">
import {
    DateFormatter,
    getLocalTimeZone,
    toCalendarDateTime,
    parseTime,
    CalendarDate,
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
import { cn } from "@/lib/utils";

const df = new DateFormatter("es-CO", {
    dateStyle: "long",
});

const startTime = defineModel<string | undefined>("startTime");
const endTime = defineModel<string | undefined>("endTime");

const model = defineModel<DateRange>({
    default: { start: undefined, end: undefined },
});
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                :class="
                    cn(
                        'w-full justify-start text-left font-normal',
                        !model && 'text-muted-foreground',
                    )
                "
            >
                <CalendarIcon class="mr-2 h-4 w-4" />
                <template v-if="model.start">
                    <template v-if="model.end">
                        {{ df.format(model.start.toDate(getLocalTimeZone())) }}
                        -
                        {{ df.format(model.end.toDate(getLocalTimeZone())) }}
                    </template>

                    <template v-else>
                        {{ df.format(model.start.toDate(getLocalTimeZone())) }}
                    </template>
                </template>
                <template v-else> Pick a date</template>
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <RangeCalendar
                class="w-full"
                v-model="model"
                initial-focus
                :number-of-months="2"
                v-model:start-time="startTime"
                v-model:end-time="endTime"
                @update:start-value="(startDate) => (model.start = startDate)"
            />
        </PopoverContent>
    </Popover>
</template>
