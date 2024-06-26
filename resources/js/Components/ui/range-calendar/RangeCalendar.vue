<script lang="ts" setup>
import { type HTMLAttributes, computed } from "vue";
import {
    RangeCalendarRoot,
    type RangeCalendarRootEmits,
    type RangeCalendarRootProps,
    useForwardPropsEmits,
} from "radix-vue";
import {
    RangeCalendarCell,
    RangeCalendarCellTrigger,
    RangeCalendarGrid,
    RangeCalendarGridBody,
    RangeCalendarGridHead,
    RangeCalendarGridRow,
    RangeCalendarHeadCell,
    RangeCalendarHeader,
    RangeCalendarHeading,
    RangeCalendarNextButton,
    RangeCalendarPrevButton,
} from ".";
import { cn } from "@/lib/utils";
import { Input } from "@/Components/ui/input";
import { Label } from "@/Components/ui/label";
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from "@/Components/ui/tooltip";
import { useColorMode } from "@vueuse/core";

const props = defineProps<
    RangeCalendarRootProps & { class?: HTMLAttributes["class"] }
>();

const emits = defineEmits<RangeCalendarRootEmits>();

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});

const forwarded = useForwardPropsEmits(delegatedProps, emits);

const startTime = defineModel<string | undefined>("startTime");
const endTime = defineModel<string | undefined>("endTime");

const mode = useColorMode();
</script>

<template>
    <RangeCalendarRoot
        v-slot="{ grid, weekDays }"
        :class="cn('p-3', props.class)"
        v-bind="forwarded"
    >
        <RangeCalendarHeader>
            <RangeCalendarPrevButton />
            <RangeCalendarHeading />
            <RangeCalendarNextButton />
        </RangeCalendarHeader>

        <div
            class="flex flex-col gap-y-4 mt-4 sm:flex-row sm:gap-x-4 sm:gap-y-0"
        >
            <RangeCalendarGrid
                v-for="month in grid"
                :key="month.value.toString()"
            >
                <RangeCalendarGridHead>
                    <RangeCalendarGridRow>
                        <RangeCalendarHeadCell
                            v-for="day in weekDays"
                            :key="day"
                        >
                            {{ day }}
                        </RangeCalendarHeadCell>
                    </RangeCalendarGridRow>
                </RangeCalendarGridHead>
                <RangeCalendarGridBody>
                    <RangeCalendarGridRow
                        v-for="(weekDates, index) in month.rows"
                        :key="`weekDate-${index}`"
                        class="mt-2 w-full"
                    >
                        <RangeCalendarCell
                            v-for="weekDate in weekDates"
                            :key="weekDate.toString()"
                            :date="weekDate"
                        >
                            <RangeCalendarCellTrigger
                                :day="weekDate"
                                :month="month.value"
                            />
                        </RangeCalendarCell>
                    </RangeCalendarGridRow>
                </RangeCalendarGridBody>
            </RangeCalendarGrid>
        </div>
        <div
            class="flex flex-col w-full gap-y-4 mt-4 sm:flex-row sm:gap-x-4 sm:gap-y-0"
        >
            <div class="w-full flex flex-col gap-2">
                <Label>Hora de inicio</Label>
                <Input v-model="startTime" type="time" :data-color="mode" />
            </div>
            <div class="w-full flex flex-col gap-2">
                <Label>
                    <TooltipProvider :delay-duration="250">
                        <Tooltip>
                            <TooltipTrigger as-child>
                                <p
                                    class="underline inline decoration-dashed cursor-pointer"
                                >
                                    Hora de fin
                                </p>
                            </TooltipTrigger>
                            <TooltipContent>
                                <p>
                                    Si seleccionó más de un día, la hora de fin
                                    será del último día elegido.
                                </p>
                            </TooltipContent>
                        </Tooltip>
                    </TooltipProvider>
                </Label>
                <Input v-model="endTime" type="time" :data-color="mode" />
            </div>
        </div>
    </RangeCalendarRoot>
</template>

<style scoped>
input[type="time"][data-color="light"]::-webkit-calendar-picker-indicator {
    cursor: pointer;
}

input[type="time"][data-color="dark"]::-webkit-calendar-picker-indicator {
    filter: invert(1);
    cursor: pointer;
}
</style>
