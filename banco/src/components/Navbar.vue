<template>
    <fwb-navbar solid>
      <template #logo>
        <fwb-navbar-logo alt="Flowbite logo" image-url="https://flowbite.com/docs/images/logo.svg" link="#">
          Banco W
        </fwb-navbar-logo>
      </template>
      <template #default="{isShowMenu}">
        <fwb-navbar-collapse :is-show-menu="isShowMenu">
          <fwb-navbar-link is-active link="#">
            <router-link to="/">Entrar</router-link>
          </fwb-navbar-link>
          <fwb-navbar-link link="#">
            <router-link to="/register">Registrarse</router-link>
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
  </script>