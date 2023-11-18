<template>
    <div class="flex items-center justify-center">
        <fwb-card class="w-full mt-6 my-1 card">
            <div class="p-6">
                <div class="mb-4">
                    <fwb-input class="mb-1" v-model="depositAmount" label="Monto a depositar" placeholder="Ingresa el monto"
                        size="sm" />
                    <fwb-button @click="deposit" type="primary" size="sm">Depositar</fwb-button>
                </div>
                <div class="mb-4">
                    <fwb-input class="mb-1" v-model="withdrawAmount" label="Monto a retirar" placeholder="Ingresa el monto"
                        size="sm" />
                    <fwb-button @click="withdraw" type="primary" size="sm">Retirar</fwb-button>
                </div>
            </div>
        </fwb-card>

        <fwb-card class="w-full mt-6 my-1 card">
            <div class="p-6">
                <div class="mb-4">
                    <fwb-input class="mb-1" v-model="current" label="Saldo en la cuenta" placeholder="" size="sm"
                        disabled />
                </div>
                <div>
                    <h5 class="mb-5">Transferir dinero</h5>
                    <fwb-input class="mb-1" v-model="reciever" label="Telefono del usuario a transferir"
                        placeholder="Ingresa el telefono" size="sm" />
                    <fwb-input class="mb-1" v-model="tamount" label="Monto a transferir"
                        placeholder="Ingresa el monto" size="sm" />
                    <fwb-button @click="transfer" type="primary" size="sm">Transferir</fwb-button>
                </div>
            </div>
        </fwb-card>

        <fwb-card class="w-full mt-6 my-1 card">
            <div class="p-6">
                <div class="mb-4">
                    <fwb-textarea v-model="movement" :rows="4" label="Movimientos" placeholder="Write you message..." />
                </div>
                </div>
        </fwb-card>

    </div>
</template>
  
<script lang="ts" setup>
import { ref, onMounted } from 'vue'
import { FwbInput, FwbButton, FwbCard, FwbTextarea } from 'flowbite-vue'
import { useRoute } from 'vue-router';

const route = useRoute();

const user = route.params.phone;

const current = ref('')
const depositAmount = ref('')
const withdrawAmount = ref('')
const transferAmount = ref('')
const reciever = ref('')
const tamount = ref('')
const movement = ref('')

const getCurrent = async() => {
    const query = await fetch(`http://localhost/index.php?act=getUser&phone=${user}`)
    const ans = await query.json()
    current.value = ans.cash
    console.log(ans)
}

const deposit = async() => {
    const query = await fetch(`http://localhost/index.php?act=deposit&phone=${user}&money=${depositAmount.value}`)
    const ans = await query.json()
    getCurrent()
    movements()
}

const withdraw = async() => {
    const query = await fetch(`http://localhost/index.php?act=withdraw&phone=${user}&money=${withdrawAmount.value}`)
    const ans = await query.json()
    getCurrent()
    movements()
}

const transfer = async() => {
    const query = await fetch(`http://localhost/index.php?act=transfer&sender=${user}&reciever=${reciever.value}&money=${tamount.value}`)
    const ans = await query.json()
    getCurrent()
    movements()
}

const movements = async() => {
    const query = await fetch(`http://localhost/index.php?act=getTransferences&phone=${user}`)
    const ans = await query.json()
    movement.value = ans.map(movement => `${movement.date}: ${movement.report}`).join('\n')
}


onMounted (()=>{
    getCurrent()
    movements()
})


</script>

<style scoped lang="sass">
  .card 
    min-width: 400px
    height: 400px
    margin: 1rem
  
  </style>
  