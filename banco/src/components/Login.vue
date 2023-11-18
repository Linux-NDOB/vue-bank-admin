<template>
    <div class="flex items-center justify-center w-full mt-6 px-8">
        <FwbCard class="w-full">
            <div class="p-6 mx-6">
                <fwb-input v-model="phone" label="Usuario" placeholder="Ingresa tu nombre de usuario" size="sm" />
                <fwb-input class="mb-1" v-model="password" label="Contraseña" placeholder="Ingresa tu contraseña"
                    type="password" size="sm" />
                <fwb-button @click="login" type="primary" size="sm">Iniciar Sesión</fwb-button>
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
const password = ref('')

const popup = (err: string) => {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: err,

    })
}

const isAuthenticated = () => {
     const token = localStorage.setItem('authToken', 'true');
     console.log(token);
    };

const login = async () => {
    const query = await fetch(`http://localhost/index.php?act=validateUser&phone=${phone.value}&password=${password.value}`)
    const ans = await query.json()
    isAuthenticated()
    ans.mensaje === 'ok' ? router.push({ name: 'admin', params: { phone: phone.value } }) : popup(ans.mensaje);
}
</script>
  