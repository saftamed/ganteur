require("./bootstrap");

import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

Vue.component("pagination", require("laravel-vue-pagination"));

import Bar from "./components/ExampleComponent.vue";
import Foo from "./components/Bar.vue";
import navcomponent from "./components/global/NavComponent.vue";
import logincomponent from "./components/global/loginComponent.vue";
import produits from "./components/ProduitsComponent.vue";
import clients from "./components/ClientsComponent.vue";
import commandes from "./components/CommandesComponent.vue";
import chart from "./components/ChartComponent.vue";
import commandesParSite from "./components/CommandesComponentParSite.vue";
const r = [
    { path: "/produits", component: produits },
    { path: "/clients", component: clients },
    { path: "/commandes/:id?", component: commandes },
    { path: "/", component: chart },
    { path: "/foo", component: Foo }
];

Vue.component("CommandesComponent", commandesParSite);
const ro = new VueRouter({
    routes: r
});

const app = new Vue({
    el: "#app",
    router: ro,
    data: {
        c: false
    },
    components: {
        navcomponent,
        logincomponent,
        produits,
        clients,
        commandes,
        chart,
        Foo,
        commandesParSite
    },
    methods: {
        setc: function() {
            this.c = !this.c;
        },
        setc2: function() {
            localStorage.removeItem("token");
            this.c = !this.c;
        }
    }
});
