<template>
    <div id="app" class="container">
        <div class="row" v-for="(field, index) in fields" :key="index">
            <div class="columns-3">
                <div class="row py-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{$this.existing_config}}</label>

                    <div class="col-md-6">
                        <input id="name" v-model="field.first_field" :name="`fields[${index}][name]`" type="text" class="form-control" autocomplete="name" autofocus>
                    </div>
                </div>
                <div class="row py-3">
                    <label for="event" class="col-md-4 col-form-label text-md-end">Event</label>

                    <div class="col-md-6">
                        <input id="event" v-model="field.second_field" :name="`fields[${index}][event]`" type="text" class="form-control" autocomplete="event" autofocus>
                    </div>
                </div>
                <div class="form-group py-3">
                    <button @click="deleteField(index)" type="button" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Delete</button>
                </div>
            </div>
        </div>
        
        <div class="form-group flex justify-end">
            <button @click="addField" type="button" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Add</button>
        </div>
    </div>
  </template>
  
  <script>
  
  export default {
    name: 'ConfigForm',
    props:['existing_config'],
    
    // data: () => ({
    //   fields: [
    //     this.existing_config
    //   ]
    // }),
  
    data: () => ({
      fields: [
        {
            name: '',
            event: '',
        }
      ]
    }),

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
  };
  </script>