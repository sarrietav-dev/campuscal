<script setup lang="ts">
import {
    DateFormatter,
    getLocalTimeZone,
    DateValue,
    today,
} from "@internationalized/date";

import { Calendar as CalendarIcon } from "lucide-vue-next";
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

interface Props {
    modelValue: DateRange;
    startTime: string | undefined;
    endTime: string | undefined;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue() {
        return {
            start: undefined,
            end: undefined,
        };
    },
    startTime: undefined,
    endTime: undefined,
});

const emit = defineEmits<{
    "update:modelValue": [DateRange];
    "update:startTime": [string | undefined];
    "update:endTime": [string | undefined];
}>();

function handleStartValueChange(startDate: DateValue | undefined) {
    emit("update:modelValue", {
        start: startDate,
        end: props.modelValue.end ?? startDate,
    });
}
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                :class="
                    cn(
                        'w-full justify-start text-left font-normal',
                        !modelValue && 'text-muted-foreground',
                    )
                "
            >
                <CalendarIcon class="mr-2 h-4 w-4" />
                <template v-if="modelValue.start">
                    <template v-if="modelValue.end">
                        {{
                            df.format(
                                modelValue.start.toDate(getLocalTimeZone()),
                            )
                        }}
                        -
                        {{
                            df.format(modelValue.end.toDate(getLocalTimeZone()))
                        }}
                    </template>

                    <template v-else>
                        {{
                            df.format(
                                modelValue.start.toDate(getLocalTimeZone()),
                            )
                        }}
                    </template>
                </template>
                <template v-else> Seleccione un rango de fechas</template>
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <RangeCalendar
                class="w-full"
                initial-focus
                :is-date-disabled="
                    (date: DateValue) =>
                        date.compare(today(getLocalTimeZone())) < 0
                "
                :number-of-months="2"
                v-model:start-time="startTime"
                v-model:end-time="endTime"
                @update:modelValue="emit('update:modelValue', $event)"
                @update:startValue="handleStartValueChange($event)"
            />
        </PopoverContent>
    </Popover>
</template>
