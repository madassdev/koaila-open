<template>
    <div class="container">
        <div class="grid grid-cols-3">
            <div class="flex justify-center col-start-1 p-3">
                <h1 class="text-lg">{{ this.title }}</h1>
            </div>
        </div>
        <div v-for="(field, index) in fields" :key="index">
            <div class="grid grid-cols-3">
                <div class="flex justify-center row py-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                    <div class="col-md-6">
                        <input id="name" v-model="field.name" :name="`${this.type}[${index}][name]`" type="text" class="form-control" autocomplete="name" autofocus>
                    </div>
                </div>
                <div class="flex justify-center row py-3">
                    <label for="event" class="col-md-4 col-form-label text-md-end">Event</label>

                    <div class="col-md-6">
                        <input id="event" v-model="field.event" :name="`${this.type}[${index}][event]`" type="text" class="form-control" autocomplete="event" autofocus>
                    </div>
                </div>
                <div class="flex justify-center form-group py-3">
                    <button @click="deleteField(index)" type="button" class="text-red-700 hover:text-red-800 font-bold py-2 px-4 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-3">
            <div class="flex justify-center col-start-3 mt-3">
                <button @click="addField" type="button" class="text-blue-700 hover:text-blue-800 font-bold py-2 px-4 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ConfigForm',
        props:['existingConfig','title','type'],

        data: () => ({
            fields: [{
                name: '',
                event: '',
            }]
        }),

        mounted(){
            if (this.existingConfig) {
                this.fields = this.existingConfig
            }

        },

        methods: {
            addField () {
                this.fields.push({
                    name: '',
                    event: ''
                })
            },
            deleteField(counter){
                this.fields.splice(counter,1);
            }
        }
    }
</script>
