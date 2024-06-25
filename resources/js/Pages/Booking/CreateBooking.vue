<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { Label } from "@/Components/ui/label";
import { Textarea } from "@/Components/ui/textarea";
import { Checkbox } from "@/Components/ui/checkbox";
import { computed, watchEffect } from "vue";
import { RadioGroup, RadioGroupItem } from "@/Components/ui/radio-group";

const audienceList = [
    {
        label: "Estudiantes",
        value: "Students",
    },
    {
        label: "Docentes",
        value: "Teachers",
    },
    {
        label: "Administrativos",
        value: "AdministrativeStaff",
    },
    {
        label: "Egresados",
        value: "Guaduates",
    },
    {
        label: "Personal externo",
        value: "External",
    },
];

interface Form {
    details: string;
    audience: string[];
    external: string;
    minors: string;
}

const form = useForm<Form>({
    details: "",
    audience: [],
    external: "",
    minors: "",
});

const hasExternal = computed(() => form.audience.includes("External"));

function handleCheckboxChange(value: string, checked: boolean) {
    if (checked) {
        form.audience.push(value);
    } else {
        form.audience = form.audience.filter((audience) => audience !== value);
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <form action="">
            <div>
                <Label for="details">Details</Label>
                <Textarea
                    v-model="form.details"
                    id="details"
                    name="details"
                    rows="4"
                    cols="50"
                    placeholder="Enter booking details"
                ></Textarea>
            </div>
            <div>
                <Label for="audience">Audience</Label>
                <div class="space-y-2">
                    <div
                        class="flex items-center gap-1"
                        v-for="audience in audienceList"
                    >
                        <Checkbox
                            :key="audience.value"
                            :checked="form.audience.includes(audience.value)"
                            @update:checked="
                                (checked) =>
                                    handleCheckboxChange(
                                        audience.value,
                                        checked,
                                    )
                            "
                        />
                        <Label :for="audience.value">
                            {{ audience.label }}
                        </Label>
                    </div>
                </div>
            </div>
            <div v-show="hasExternal">
                <Label for="external">External</Label>
                <Textarea
                    v-model="form.external"
                    id="external"
                    name="external"
                    rows="4"
                    cols="50"
                    placeholder="Enter external details"
                ></Textarea>
            </div>
            <div>
                <Label>
                    ¿El evento contará con la presencia de menores de edad
                    (niños y/o adolescentes) que no están matriculados en la
                    institución? (Marque una opción)
                </Label>
                <RadioGroup v-model="form.minors">
                    <div>
                        <RadioGroupItem value="Yes" />
                        <Label for="Yes">Sí</Label>
                    </div>
                    <div>
                        <RadioGroupItem value="No" />
                        <Label for="No">No</Label>
                    </div>
                </RadioGroup>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
