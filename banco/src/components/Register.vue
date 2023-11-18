<template>
    <div class="flex items-center justify-center w-full mt-6 px-8">
        <FwbCard class="w-full">
            <h5 class="text-center mt-6">Registro</h5>
            <div class="p-6 mx-6">
                <fwb-input v-model="phone" label="Telefono" placeholder="Ingresa tu nombre de usuario" size="sm" />
                <fwb-input v-model="name" label="Nombre" placeholder="Ingresa tu nombre de usuario" size="sm" />
                <fwb-input class="mb-1" v-model="password" label="Contraseña" placeholder="Ingresa tu contraseña" type="password"
                    size="sm" />
                <fwb-button @click="register" type="primary" size="sm">Registrarse</fwb-button>
            </div>
        </FwbCard>
    </div>
</template>
  
<script lang="ts" setup>
import { ref } from 'vue'
import { FwbInput, FwbButton, FwbCard } from 'flowbite-vue'
import router from '../router/index';
import Swal from 'sweetalert2';

const phone = ref('')
const name = ref('')
const password = ref('')

const popup = (err) => {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Revise los campos o usuario ya creado",  
    })
}

const success = () => {
    Swal.fire({
        icon: "success",
        title: "Exito...",
        text: "Usuario registrado",  
    })
}

const register = async () => {
    name.value || password.value || phone.value === "" ? popup("rellene los campos") : console.log('ok')
    const query = await fetch(`http://localhost/index.php?act=createUser&phone=${phone.value}&name=${name.value}&password=${password.value}`)
    const ans = await query.json()
    console.log(ans)
    const err = JSON.stringify(ans.success)
    ans.success === 'Usuario registrado con exito!' ? success() : popup(err);
}
</script>