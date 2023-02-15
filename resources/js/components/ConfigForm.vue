<template>
    <div id="app" class="container">
        <div class="row" v-for="(experience, index) in fields" :key="index">
            <div class="columns-3">
                <div class="row mb-3 mt-3">
                    <label for="api-key" class="col-md-4 col-form-label text-md-end">{{this.label1}}</label>

                    <div class="col-md-6">
                        <input id="api-key" v-model="experience.title" :name="`fields[${index}][title]`" type="text" class="form-control" autocomplete="api-amplitude" autofocus>
                    </div>
                </div>
                <div class="row mb-3 mt-3">
                    <label for="api-key" class="col-md-4 col-form-label text-md-end">{{this.label2}}</label>

                    <div class="col-md-6">
                        <input id="api-key" v-model="experience.title" :name="`fields[${index}][title]`" type="text" class="form-control" autocomplete="api-amplitude" autofocus>
                    </div>
                </div>
                <div class="form-group ">
                    <button @click="deleteField" type="button" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">Delete</button>
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
    name: "App",
    props: ['label1','label2'],
    
    data: () => ({
      fields: [
        {
          company: '',
          title: '',
        }
      ]
    }),
  
    methods: {
      addField () {
        this.fields.push({
          company: '',
          title: ''
        })
      },

      deleteField(counter){
      this.fields.splice(counter,1);
}
    }
  };
  </script>