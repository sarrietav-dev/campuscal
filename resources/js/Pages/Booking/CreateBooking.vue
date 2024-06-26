<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { Label } from "@/Components/ui/label";
import { Textarea } from "@/Components/ui/textarea";
import { Checkbox } from "@/Components/ui/checkbox";
import { computed, ref, watchEffect } from "vue";
import { RadioGroup, RadioGroupItem } from "@/Components/ui/radio-group";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import SpaceDialog from "@/Components/SpaceDialog.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import SelectedSpaceCard from "@/Components/SelectedSpaceCard.vue";
import Text from "@/Components/ui/Text.vue";
import FormItem from "@/Components/FormItem.vue";

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
        value: "Graduates",
    },
    {
        label: "Personal externo",
        value: "External",
    },
];

const modalOpen = ref(false);

function handleModalOpen(open: boolean) {
    modalOpen.value = open;
}

interface Form {
    details: string;
    audience: string[];
    external: string;
    minors: string;
    agreementContract: string;
    agreementContractFile?: File;
    assistance: number;
    spaces: {
        id: string;
        name: string;
        imageUrl: string;
        date: {
            start: Date;
            end: Date;
        };
    }[];
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
    agreementContract: "",
    assistance: 0,
    spaces: [],
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
const hasAgreementContract = computed(() => form.agreementContract === "Yes");

function handleCheckboxChange(value: string, checked: boolean) {
    if (checked) {
        form.audience.push(value);
    } else {
        form.audience = form.audience.filter((audience) => audience !== value);
    }
}

function handleFileChange(event: Event) {
    const target = event.target as HTMLInputElement;
    form.agreementContractFile = target.files?.[0];
}

function handleSpacesChange(spaces: Form["spaces"][0]) {
    form.spaces = [...form.spaces, spaces];
}

function handleSpaceDelete(index: number) {
    form.spaces.splice(index, 1);
}
</script>

<template>
    <GuestLayout>
        <form class="container mx-auto max-w-4xl space-y-5">
            <Text variant="heading2">Datos de la petición</Text>
            <FormItem>
                <Label for="details">Detalle de la actividad a realizar</Label>
                <Textarea
                    v-model="form.details"
                    id="details"
                    name="details"
                    rows="4"
                    cols="50"
                    placeholder="Anote detalladamente la actividad que desea realizar"
                ></Textarea>
            </FormItem>
            <div class="grid grid-cols-2">
                <FormItem>
                    <Label for="audience"
                        >¿A qué público está dirigida la actividad?</Label
                    >
                    <div class="space-y-2">
                        <div
                            class="flex items-center gap-1"
                            v-for="audience in audienceList"
                        >
                            <Checkbox
                                :id="audience.value"
                                :key="audience.value"
                                :checked="
                                    form.audience.includes(audience.value)
                                "
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
                </FormItem>
                <div class="space-y-3" v-show="hasExternal">
                    <Label for="external">Para personal externo: ¿Cuál?</Label>
                    <Textarea
                        v-model="form.external"
                        id="external"
                        name="external"
                        rows="4"
                        cols="50"
                        placeholder="Indique el grupo poblacional"
                    ></Textarea>
                </div>
            </div>
            <FormItem>
                <Label>
                    ¿El evento contará con la presencia de menores de edad
                    (niños y/o adolescentes) que no están matriculados en la
                    institución? (Marque una opción)
                </Label>
                <RadioGroup v-model="form.minors">
                    <div class="flex gap-2 items-center">
                        <RadioGroupItem id="MinorsYes" value="Yes" />
                        <Label for="MinorsYes">Sí</Label>
                    </div>
                    <div class="flex gap-2 items-center">
                        <RadioGroupItem id="MinorsNo" value="No" />
                        <Label for="MinorsNo">No</Label>
                    </div>
                </RadioGroup>
            </FormItem>
            <FormItem>
                <Label>
                    ¿La actividad a realizar se llevará a cabo en cumplimiento
                    de obligaciones en el marco de un Convenio o Contrato
                    Inter-administrativo? (Si marca Si, favor anexar copia del
                    convenio o contrato)
                </Label>
                <RadioGroup v-model="form.agreementContract">
                    <div class="flex gap-2 items-center">
                        <RadioGroupItem id="agreementContractYes" value="Yes" />
                        <Label for="agreementContractYes">Sí</Label>
                    </div>
                    <div class="flex gap-2 items-center">
                        <RadioGroupItem id="agreementContractNo" value="No" />
                        <Label for="agreementContractNo">No</Label>
                    </div>
                </RadioGroup>
            </FormItem>
            <FormItem v-show="hasAgreementContract">
                <Label for="agreementContract">
                    Anexar copia del convenio o contrato
                </Label>
                <Input
                    type="file"
                    @change="handleFileChange($event)"
                    id="agreementContract"
                    name="agreementContract"
                />
            </FormItem>
            <SelectedSpaceCard
                deletable
                v-for="(space, index) in form.spaces"
                :space-name="space.name"
                @delete="handleSpaceDelete(index)"
                :date="{
                    to: space.date.end.toLocaleDateString(),
                    from: space.date.start.toLocaleDateString(),
                }"
                :image-url="space.imageUrl"
            />
            <SpaceDialog
                :open="modalOpen"
                @update:open="handleModalOpen($event)"
                @create="handleSpacesChange($event)"
            />
            <FormItem>
                <Label for="assistance">Número de asistentes</Label>
                <Input
                    type="number"
                    v-model.number="form.assistance"
                    id="assistance"
                    name="assistance"
                    min="1"
                />
            </FormItem>
            <Text variant="heading2">Datos del solicitante</Text>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <FormItem>
                    <Label for="requester.name">Nombre</Label>
                    <Input
                        v-model="form.requester.name"
                        id="requester.name"
                        name="requester.name"
                        type="text"
                    />
                </FormItem>
                <FormItem>
                    <Label for="requester.surname">Apellido</Label>
                    <Input
                        v-model="form.requester.surname"
                        id="requester.surname"
                        name="requester.surname"
                        type="text"
                    />
                </FormItem>
                <FormItem>
                    <Label for="requester.identification">
                        N° de Identificación
                    </Label>
                    <Input
                        v-model="form.requester.identification"
                        id="requester.identification"
                        name="requester.identification"
                        type="text"
                    />
                </FormItem>
                <FormItem>
                    <Label for="requester.phone">Teléfono</Label>
                    <Input
                        v-model="form.requester.phone"
                        id="requester.phone"
                        name="requester.phone"
                        type="tel"
                    />
                </FormItem>
                <FormItem class="sm:col-span-2">
                    <Label for="requester.email">Correo electrónico</Label>
                    <Input
                        v-model="form.requester.email"
                        id="requester.email"
                        name="requester.email"
                        type="email"
                    />
                </FormItem>
                <FormItem>
                    <Label>
                        Entidad, empresa u organización a la que se encuentra
                        afiliado
                    </Label>
                    <Input
                        v-model="form.requester.companyName"
                        id="requester.companyName"
                        name="requester.companyName"
                        type="text"
                    />
                </FormItem>
                <FormItem>
                    <Label for="requester.companyRole">
                        Cargo en la empresa
                    </Label>
                    <Input
                        v-model="form.requester.companyRole"
                        id="requester.companyRole"
                        name="requester.companyRole"
                        type="text"
                    />
                </FormItem>
                <FormItem>
                    <Label for="requester.academicUnit">
                        Unidad Académica o Administrativa de la U de C a la que
                        pertenece
                    </Label>
                    <Input
                        v-model="form.requester.academicUnit"
                        id="requester.academicUnit"
                        name="requester.academicUnit"
                        type="text"
                    />
                </FormItem>
            </div>
            <div>
                <Button type="submit">Submit</Button>
            </div>
        </form>
    </GuestLayout>
</template>
