<template>
    <fwb-footer class="fixed bottom-0">
      <fwb-footer-copyright
        by="Flowbite™"
        href="https://flowbite.com/"
        copyright-message="All Rights Reserved."
      />
      <fwb-footer-link-group>
        <fwb-footer-link href="#">
          About
        </fwb-footer-link>
        <fwb-footer-link href="#">
          Privacy Policy
        </fwb-footer-link>
        <fwb-footer-link href="#">
          Licensing
        </fwb-footer-link>
        <fwb-footer-link href="#">
          Contact
        </fwb-footer-link>
      </fwb-footer-link-group>
    </fwb-footer>
  </template>
  
  <script setup>
  import {
    FwbFooter,
    FwbFooterCopyright,
    FwbFooterLink,
    FwbFooterLinkGroup,
  } from 'flowbite-vue'
  </script>