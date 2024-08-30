<script setup>
import { useForm, Head } from "@inertiajs/vue3";
import { Label } from "@/Components/ui/label";
import { Textarea } from "@/Components/ui/textarea";
import { Checkbox } from "@/Components/ui/checkbox";
import { computed, ref } from "vue";
import { RadioGroup, RadioGroupItem } from "@/Components/ui/radio-group";
import { Input } from "@/Components/ui/input";
import { Button } from "@/Components/ui/button";
import SpaceDialog from "@/Components/SpaceDialog.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import SelectedSpaceCard from "@/Components/SelectedSpaceCard.vue";
import Text from "@/Components/ui/Text.vue";
import FormItem from "@/Components/FormItem.vue";
import {produce, setAutoFreeze} from "immer";
import { format } from "date-fns";
import ErrorMessage from "@/Components/ErrorMessage.vue";
import Combobox from "@/Components/Combobox.vue";
import { toast } from "vue-sonner";

const props = defineProps({
    audience: {
        type: Object,
    },
    institutions: { type: Array },
});

const OTHER_INSTITUTION_ID = 0;

const institutions = computed(() => {
    return props.institutions.map((institution) => ({
        value: institution.id,
        label: institution.name,
    }));
});

const step = ref("request");

function handleStepChange(stepValue) {
    step.value = stepValue;
}

const modalOpen = ref(false);

function handleModalOpen(open) {
    modalOpen.value = open;
}

const form = useForm({
    details: "",
    audience: [],
    external: "",
    minors: "",
    agreement_contract: "",
    agreement_contract_file: undefined,
    assistance: 0,
    appointments: [],
    requester: {
        name: "",
        surname: "",
        identification: "",
        phone: "",
        email: "",
        institution: "",
        new_institution: "",
        company_role: "",
        academic_unit: "",
    },
}).transform((form) => {
    setAutoFreeze(false);
    return produce(form, (draft) => {
        draft.appointments.forEach((appointment) => {
            appointment.date.start = format(
                appointment.date.start,
                "yyyy-MM-dd HH:mm:ss",
            );
            appointment.date.end = format(
                appointment.date.end,
                "yyyy-MM-dd HH:mm:ss",
            );
        });
    });
});

const choseOtherInstitution = computed(
    () => form.requester.institution === OTHER_INSTITUTION_ID,
);

const hasExternal = computed(() =>
    form.audience.includes(
        props.audience?.find((audience) => audience.name === "Personal externo")
            ?.id ?? 0,
    ),
);
const hasAgreementContract = computed(() => form.agreement_contract === "1");

function handleCheckboxChange(value, checked) {
    if (checked) {
        form.audience.push(value);
    } else {
        form.audience = form.audience.filter((audience) => audience !== value);
    }
}

function handleFileChange(event) {
    const target = event.target;
    form.agreement_contract_file = target.files?.[0];
}

function handleSpacesChange(spaces) {
    form.appointments = [...form.appointments, spaces];
}

function handleSpaceDelete(index) {
    form.appointments.splice(index, 1);
}

function handleSubmit() {
    form.post(route("bookings.store"), {
        preserveState: 'errors',
        onSuccess: () => {
            toast.success("Reserva creada exitosamente");
            handleStepChange("request");
            form.reset();
        },
    });
}
</script>

<template>
    <GuestLayout>

        <Head title="Reservar espacio" />
        <form @submit.prevent="handleSubmit" class="container mx-auto max-w-4xl space-y-5">
            <template v-if="step === 'request'">
                <Text variant="heading2">Datos de la petición</Text>
                <FormItem>
                    <Label for="details">
                        Detalle de la actividad a realizar
                    </Label>
                    <Textarea v-model="form.details" id="details" name="details" rows="4" cols="50"
                        placeholder="Anote detalladamente la actividad que desea realizar"></Textarea>
                    <ErrorMessage v-show="form.errors.details">
                        {{ form.errors.details }}
                    </ErrorMessage>
                </FormItem>
                <div class="grid grid-cols-2">
                    <FormItem>
                        <Label for="audience">¿A qué público está dirigida la actividad?</Label>
                        <div class="space-y-2">
                            <div class="flex items-center gap-1" v-for="audience in props.audience">
                                <Checkbox :id="audience.id.toString()" :key="audience.id" :checked="form.audience.includes(audience.id)
                                    " @update:checked="(checked) =>
                                            handleCheckboxChange(
                                                audience.id,
                                                checked,
                                            )
                                        " />
                                <Label :for="audience.id.toString()">
                                    {{ audience.name }}
                                </Label>
                            </div>
                        </div>
                        <ErrorMessage v-show="form.errors.audience">
                            {{ form.errors.audience }}
                        </ErrorMessage>
                    </FormItem>
                    <div class="space-y-3" v-show="hasExternal">
                        <Label for="external">Para personal externo: ¿Cuál?</Label>
                        <Textarea v-model="form.external" id="external" name="external" rows="4" cols="50"
                            placeholder="Indique el grupo poblacional"></Textarea>
                        <ErrorMessage v-show="form.errors.external">
                            {{ form.errors.external }}
                        </ErrorMessage>
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
                            <RadioGroupItem id="MinorsYes" value="1" />
                            <Label for="MinorsYes">Sí</Label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <RadioGroupItem id="MinorsNo" value="0" />
                            <Label for="MinorsNo">No</Label>
                        </div>
                    </RadioGroup>
                    <ErrorMessage v-show="form.errors.minors">
                        {{ form.errors.minors }}
                    </ErrorMessage>
                </FormItem>
                <FormItem>
                    <Label>
                        ¿La actividad a realizar se llevará a cabo en
                        cumplimiento de obligaciones en el marco de un Convenio
                        o Contrato Inter-administrativo? (Si marca Si, favor
                        anexar copia del convenio o contrato)
                    </Label>
                    <RadioGroup v-model="form.agreement_contract">
                        <div class="flex gap-2 items-center">
                            <RadioGroupItem id="agreementContractYes" value="1" />
                            <Label for="agreementContractYes">Sí</Label>
                        </div>
                        <div class="flex gap-2 items-center">
                            <RadioGroupItem id="agreementContractNo" value="0" />
                            <Label for="agreementContractNo">No</Label>
                        </div>
                    </RadioGroup>
                    <ErrorMessage v-show="form.errors.agreement_contract">
                        {{ form.errors.agreement_contract }}
                    </ErrorMessage>
                </FormItem>
                <FormItem v-show="hasAgreementContract">
                    <Label for="agreementContract">
                        Anexar copia del convenio o contrato
                    </Label>
                    <Input type="file" @change="handleFileChange($event)" id="agreementContract"
                        name="agreementContract" />
                    <ErrorMessage v-show="form.errors.agreement_contract_file">
                        {{ form.errors.agreement_contract_file }}
                    </ErrorMessage>
                </FormItem>
                <FormItem>
                    <template v-for="(space, index) in form.appointments">
                        <SelectedSpaceCard deletable :space-name="space.name" @delete="handleSpaceDelete(index)" :date="{
                            to: space.date.end.toLocaleDateString(),
                            from: space.date.start.toLocaleDateString(),
                        }" :image-url="space.imageUrl" />
                        <ErrorMessage v-show="form.errors[`appointments.${index}`]">
                            {{ form.errors[`appointments.${index}`] }}
                        </ErrorMessage>
                    </template>
                    <SpaceDialog :open="modalOpen" @update:open="handleModalOpen($event)"
                        @create="handleSpacesChange($event)" />
                    <ErrorMessage v-show="form.errors.appointments">
                        {{ form.errors.appointments }}
                    </ErrorMessage>
                </FormItem>
                <FormItem>
                    <Label for="assistance">Número de asistentes</Label>
                    <Input type="number" v-model.number="form.assistance" id="assistance" name="assistance" min="1" />
                    <ErrorMessage v-show="form.errors.assistance">
                        {{ form.errors.assistance }}
                    </ErrorMessage>
                </FormItem>
                <div class="flex justify-end">
                    <Button @click="handleStepChange('requester')" type="button">
                        Siguiente
                    </Button>
                </div>
            </template>
            <template v-else-if="step === 'requester'">
                <Text variant="heading2">Datos del solicitante</Text>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <FormItem>
                        <Label for="requester.name">Nombre</Label>
                        <Input v-model="form.requester.name" id="requester.name" name="requester.name" type="text" />
                        <ErrorMessage v-if="form.errors['requester.name']">
                            {{ form.errors["requester.name"] }}
                        </ErrorMessage>
                    </FormItem>
                    <FormItem>
                        <Label for="requester.surname">Apellido</Label>
                        <Input v-model="form.requester.surname" id="requester.surname" name="requester.surname"
                            type="text" />
                        <ErrorMessage v-if="form.errors['requester.surname']">
                            {{ form.errors["requester.surname"] }}
                        </ErrorMessage>
                    </FormItem>
                    <FormItem>
                        <Label for="requester.identification">
                            N° de Identificación
                        </Label>
                        <Input v-model.number="form.requester.identification" id="requester.identification"
                            name="requester.identification" type="text" />
                        <ErrorMessage v-show="form.errors['requester.identification']">
                            {{ form.errors["requester.identification"] }}
                        </ErrorMessage>
                    </FormItem>
                    <FormItem>
                        <Label for="requester.phone">Teléfono</Label>
                        <Input v-model.number="form.requester.phone" id="requester.phone" name="requester.phone"
                            type="tel" />
                        <ErrorMessage v-show="form.errors['requester.phone']">
                            {{ form.errors["requester.phone"] }}
                        </ErrorMessage>
                    </FormItem>
                    <FormItem class="sm:col-span-2">
                        <Label for="requester.email">Correo electrónico</Label>
                        <Input v-model="form.requester.email" id="requester.email" name="requester.email"
                            type="email" />
                        <ErrorMessage v-show="form.errors['requester.email']">
                            {{ form.errors["requester.email"] }}
                        </ErrorMessage>
                    </FormItem>
                    <FormItem>
                        <Label>
                            Entidad, empresa u organización a la que se
                            encuentra afiliado
                        </Label>
                        <Combobox v-model="form.requester.institution" id="requester.institution"
                            name="requester.institution" :options="institutions" />
                        <ErrorMessage v-show="form.errors['requester.institution']">
                            {{ form.errors["requester.institution"] }}
                        </ErrorMessage>
                    </FormItem>
                    <FormItem v-show="choseOtherInstitution">
                        <Label>
                            Indique la entidad, empresa u organización a la que
                            se encuentra afiliado
                        </Label>
                        <Input v-model="form.requester.new_institution" id="requester.new_institution"
                            name="requester.new_institution" />
                        <ErrorMessage v-show="form.errors['requester.new_institution']">
                            {{ form.errors["requester.new_institution"] }}
                        </ErrorMessage>
                    </FormItem>
                    <FormItem>
                        <Label for="requester.companyRole">
                            Cargo en la empresa
                        </Label>
                        <Input v-model="form.requester.company_role" id="requester.companyRole"
                            name="requester.companyRole" type="text" />
                        <ErrorMessage v-show="form.errors['requester.company_role']">
                            {{ form.errors["requester.company_role"] }}
                        </ErrorMessage>
                    </FormItem>
                    <FormItem>
                        <Label for="requester.academicUnit">
                            Unidad Académica o Administrativa de la U de C a la
                            que pertenece
                        </Label>
                        <Input v-model="form.requester.academic_unit" id="requester.academicUnit"
                            name="requester.academicUnit" type="text" />
                        <ErrorMessage v-show="form.errors['requester.academic_unit']">
                            {{ form.errors["requester.academic_unit"] }}
                        </ErrorMessage>
                    </FormItem>
                </div>
                <div class="flex justify-between">
                    <Button type="button" @click="handleStepChange('request')">
                        Atrás
                    </Button>
                    <Button type="submit" :disabled="form.processing"> Enviar</Button>
                </div>
            </template>
        </form>
    </GuestLayout>
</template>
