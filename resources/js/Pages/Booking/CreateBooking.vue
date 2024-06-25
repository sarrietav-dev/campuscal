<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { Label } from "@/Components/ui/label";
import { Textarea } from "@/Components/ui/textarea";
import { Checkbox } from "@/Components/ui/checkbox";
import { computed, watchEffect } from "vue";
import { RadioGroup, RadioGroupItem } from "@/Components/ui/radio-group";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import SpaceDialog from "@/Components/SpaceDialog.vue";

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
    interadministrative: string;
    interadministrativeFile?: File;
    assistance: number;
    requester: {
        name: string;
        surname: string;
        identification: string;
        phone: string;
        email: string;
        companyName: string;
        companyRole: string;
        academicUnit: string;
    };
}

const form = useForm<Form>({
    details: "",
    audience: [],
    external: "",
    minors: "",
    interadministrative: "",
    assistance: 0,
    requester: {
        name: "",
        surname: "",
        identification: "",
        phone: "",
        email: "",
        companyName: "",
        companyRole: "",
        academicUnit: "",
    },
});

const hasExternal = computed(() => form.audience.includes("External"));
const hasInteradministrative = computed(
    () => form.interadministrative === "Yes",
);

function handleCheckboxChange(value: string, checked: boolean) {
    if (checked) {
        form.audience.push(value);
    } else {
        form.audience = form.audience.filter((audience) => audience !== value);
    }
}

function handleFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    form.interadministrativeFile = target.files?.[0];
}
</script>

<template>
    <AuthenticatedLayout>
        <form>
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
            <div>
                <Label>
                    ¿La actividad a realizar se llevará a cabo en cumplimiento
                    de obligaciones en el marco de un Convenio o Contrato
                    Interadministrativo? (Si marca Si, favor anexar copia del
                    convenio o contrato)
                </Label>
                <RadioGroup v-model="form.interadministrative">
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
            <div v-show="hasInteradministrative">
                <Label for="interadministrative"
                    >Anexar copia del convenio o contrato</Label
                >
                <Input
                    type="file"
                    @change="handleFileChange($event)"
                    id="interadministrative"
                    name="interadministrative"
                />
            </div>
            <div>
                <Label for="assistance">Número de asistentes</Label>
                <Input
                    type="number"
                    v-model.number="form.assistance"
                    id="assistance"
                    name="assistance"
                    min="1"
                />
            </div>
            <div>
                <Label for="requester.name">Nombre</Label>
                <Input
                    v-model="form.requester.name"
                    id="requester.name"
                    name="requester.name"
                    type="text"
                />
            </div>
            <div>
                <Label for="requester.surname">Apellido</Label>
                <Input
                    v-model="form.requester.surname"
                    id="requester.surname"
                    name="requester.surname"
                    type="text"
                />
            </div>
            <div>
                <Label for="requester.identification">Identificación</Label>
                <Input
                    v-model="form.requester.identification"
                    id="requester.identification"
                    name="requester.identification"
                    type="text"
                />
            </div>
            <div>
                <Label for="requester.phone">Teléfono</Label>
                <Input
                    v-model="form.requester.phone"
                    id="requester.phone"
                    name="requester.phone"
                    type="tel"
                />
            </div>
            <div>
                <Label for="requester.email">Correo electrónico</Label>
                <Input
                    v-model="form.requester.email"
                    id="requester.email"
                    name="requester.email"
                    type="email"
                />
            </div>
            <div>
                <Label for="requester.companyName">Nombre de la empresa</Label>
                <Input
                    v-model="form.requester.companyName"
                    id="requester.companyName"
                    name="requester.companyName"
                    type="text"
                />
            </div>
            <div>
                <Label for="requester.companyRole">Cargo en la empresa</Label>
                <Input
                    v-model="form.requester.companyRole"
                    id="requester.companyRole"
                    name="requester.companyRole"
                    type="text"
                />
            </div>
            <div>
                <Label for="requester.academicUnit"
                    >Unidad académica a la que pertenece</Label
                >
                <Input
                    v-model="form.requester.academicUnit"
                    id="requester.academicUnit"
                    name="requester.academicUnit"
                    type="text"
                />
            </div>
            <div>
                <Button type="submit">Submit</Button>
            </div>
            <SpaceDialog />
        </form>
    </AuthenticatedLayout>
</template>
