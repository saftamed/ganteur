<template>
 <div>
     <h1>hello bar</h1>
     <img :src="image" alt="">
        <input type="file" accept="image/*" @change="uploadImage($event)">
     <button @click="get" > click</button>
 </div>
</template>

<script>


    export default {
          data: function () {
            return {
                image:{}
            }
         },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            uploadImage(event) {

            const URL = 'http://127.0.0.1:8000/api/test3'; 

            let data = new FormData();
            data.append('name', 'my-picture');
            data.append('file', event.target.files[0]); 

            let config = {
            header : {
                'Content-Type' : 'image/png',
                'enctype': 'multipart/form-data'
            }
            }

            axios.post(
            URL, 
            data,
            config
            ).then(
            response => {
                console.log('image upload response > ', response)
            }
            )
        }
        }
    }
</script>
