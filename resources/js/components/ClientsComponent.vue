<template>
 <div>
     <h1 class="cu">Clients <i class="fas fa-users"></i></h1>
      <div class="card-body">
          <div>
              <div class="form-row">
                  <div class="form-group col-md-3">
                      <div class="re">
                        <input class="form-control" type="text" v-model="q" @keyup="search" placeholder="Recherche des produits">
                        <i class="fas fa-search"></i>
                      </div>
                  </div>
                  <!--
                  <div class="form-group col-md-2">
                    <select id="inputState" class="form-control">
                      <option selected>Choose...</option>
                      <option>...</option>
                    </select>
                  </div>
                  -->
              </div>
          
            <button type="button" class="btn btn-primary mr" @click="add">Nouveau Clients <i class="far fa-plus-square"></i></button>
        </div>
    <div class="table-responsive">
        
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Tel</th>
                    <th>Adresse</th>
                    <th>Ville</th>
                    <th>Creer en</th>
                    <th>Creer une Commande</th>
                    <th>Modifier</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="produit in produits.data" :key="produit.id">
                    <td>{{produit.name}}</td>
                    <td>{{produit.email}}</td>
                    <td>{{produit.tel}}</td>
                    <td>{{produit.adresse}}</td>
                    <td>{{produit.ville}}</td>
                    <td>{{date(produit.created_at)}}</td>
                    <td> <router-link :to="'/commandes/'+produit.id" class="btn btn-info">Commander</router-link></td>
                    <td> <button type="button" class="btn btn-success" @click="edit(produit)">Modifier</button></td>
                </tr>
            </tbody>
        </table>
    </div>
        <pagination :data="produits"  :limit="limit" @pagination-change-page="getResults" class=""></pagination>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<form>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Name</label>
      <input type="text" class="form-control" v-model="produit.name" >
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Email</label>
      <input type="email" class="form-control" v-model="produit.email" >
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Adresse</label>
    <input type="text" class="form-control" v-model="produit.adresse" >
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Ville</label>
      <input type="text" class="form-control" v-model="produit.ville" >
    </div>
    <div class="form-group col-md-6">
      <label for="inputZip">Telephone</label>
      <input type="number" class="form-control" v-model="produit.tel" >
    </div>
  </div>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" @click="save">Enregistrer</button>
      </div>
    </div>
  </div>
</div>
 </div>
</template>

<script>
    export default {
        data: function () {
            return {
                url:'/admin/public/api/clients',
                produits:{},
                produit:{
                    name:'TV',
                    tel:'',
                    id:-1,
                    adresse:'',
                    ville:'',
                    email:'',
                },
                name:'Nouveau Client',
                q:'',
                 limit:1,
            }
        },
        methods:{
          date(d){
            var h = new Date(d);
            return h.getDate()+"/"+h.getMonth()+"/"+h.getFullYear()+" ("+h.getHours()+":"+h.getMinutes()+")";
          },
            getResults(page = 1){
                axios.get(this.url + '?page='+page,{
                }).then(response =>{
                    console.log(response);
                    if(response.data != "f"){
                        this.produits =response.data;
                    }else{
                        
                    }
                });
            },delate(id){
               if(confirm("tu veut le suprimer??")){
                    axios.get(this.url + '/delate/'+id,{
                    }).then(response =>{
                        console.log(response);
                        if(response.data != "f"){
                            this.produits =response.data;
                        }else{
                            
                        }
                    });
                }
            },add(){
                this.produit = {
                    name:'',
                    tel:'',
                    id:-1,
                    adresse:'',
                    ville:'',
                    email:'',
                };
                this.name = 'Nouveau Client';
                $('#exampleModal').modal('show');
            },edit(p){
                this.produit = p;
                this.name = 'Edit => '+ this.produit.name;
                $('#exampleModal').modal('show');
            },save(){
                  axios.post(this.url + '/add',this.produit).then(response =>{
                        console.log(response);
                        if(response.data != "f"){
                            this.produits =response.data;
                            $('#exampleModal').modal('hide');
                        }else{
                            
                        }
                    });
            },search(){
              if(this.q.length > 1){
                  axios.get(this.url + '/search/'+ this.q,{
                  }).then(response =>{
                      console.log(response);
                      if(response.data != "f"){
                          this.produits =response.data;
                      }else{
                          
                      }
                  });
              }else{
                 this.getResults();
              }
               
            },
        },
        mounted() {
           
        },created(){
          this.getResults();
        }
    }
</script>

<style  scoped>
    .mr{
        position: absolute;
        right: 20px;
        top: 25px;
    }
    .card-body{
        position: relative;
    }
    h1.cu{
        margin:35px 20px;
    }
    .fa-search{
      position: absolute;
      top: 9px;
      right: 12px;
      font-size: 20px;
      color: #6cb2eb;
    }
    .re{
      position: relative;
      /*max-width: 300px;*/
      min-width: 250px;
    }
    .pagination{
      margin: 0;
    }
    @media only screen and (max-width: 768px) {
      .mr{
       top: -30px;
      }
    }
</style>
