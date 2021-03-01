<template>
    <div>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html">Ganteur STE</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">{{name}}</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" @click="logout">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading"></div>
                            <router-link class="nav-link" to="/">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Statistique 
                            </router-link>
                           
                     
                            <div class="sb-sidenav-menu-heading">Pages</div>
                                <router-link class="nav-link" to="/commandes">
                                    <div class="sb-nav-link-icon"> <i class="fas fa-parachute-box"></i></div>
                                    Commandes
                                </router-link>
                                 <router-link class="nav-link" to="/produits">
                                    <div class="sb-nav-link-icon"> <i class="fas fa-box-open"></i></div>
                                    Produits
                                </router-link>
                           
                                <router-link class="nav-link" to="/clients">
                                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                    Clients
                                </router-link>
                                
                               
                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small"></div>
                        <div class="sm">
                            <img src="l.png" class="ii" alt="">
                        </div>
                        
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                         <router-view></router-view>
                    </div>
                </main>
                <footer class="bg-light  paddinggh">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Ganteur STE 2020</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
         this.name=  localStorage.getItem("name");
        }, data: function () {
            return {
            name: ''
            }
        },methods:{
            logout(){
                this.$emit('update');
            }
        }
    }
</script>

<style scoped>
   footer.bg-light{
      padding: 10px !important;
    }
    span#fav{
        margin-left: 15px;
    }
    .sm{
        width: 80%;
        margin: auto;
    }
    .ii{
        width: 145px;
    }
</style>
