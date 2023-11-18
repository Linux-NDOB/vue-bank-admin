<template>
    <fwb-navbar solid>
        <template #logo>
            <fwb-navbar-logo alt="Flowbite logo" image-url="https://flowbite.com/docs/images/logo.svg" link="#">
                Bienvenido
            </fwb-navbar-logo>
        </template>
        <template #default="{ isShowMenu }">
            <fwb-navbar-collapse :is-show-menu="isShowMenu">
                <fwb-navbar-link is-active link="#" @click="salir()"> Salir
                </fwb-navbar-link>
            </fwb-navbar-collapse>
        </template>
    </fwb-navbar>
</template>
  
<script setup>
import {
    FwbNavbar,
    FwbNavbarCollapse,
    FwbNavbarLink,
    FwbNavbarLogo,
} from 'flowbite-vue'
import router from '../router';
const salir = () => {
    const token = localStorage.setItem('authToken', 'false');
    router.push('/')
}
</script>