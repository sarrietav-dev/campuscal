<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { Label } from "@/Components/ui/label";
import { Textarea } from "@/Components/ui/textarea";
import { Checkbox } from "@/Components/ui/checkbox";
import { watchEffect } from "vue";

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
}

const form = useForm<Form>({
    details: "",
    audience: [],
});

watchEffect(() => {
    console.log(form.audience);
});

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
            <div></div>
        </form>
    </AuthenticatedLayout>
</template>
