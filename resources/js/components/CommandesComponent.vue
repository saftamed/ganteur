<template>
    <div>
        <h1 class="cu">Commandes <i class="fas fa-parachute-box"></i></h1>
        <div class="card-body">
            <div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="re">
                            <input
                                class="form-control"
                                type="text"
                                v-model="q"
                                @keyup="search"
                                placeholder="Recherche des commandes"
                            />
                            <i class="fas fa-search"></i>
                        </div>
                    </div>

                    <div class="form-group col-md-2">
                        <select
                            id="inputState"
                            class="form-control"
                            v-model="etat"
                            @change="getResults()"
                        >
                            <option selected value="all">All</option>
                            <option value="en cours">En cours</option>
                            <option value="valider">Valider</option>
                            <option value="par site">par site</option>
                            <option value="retour">Retour</option>
                        </select>
                    </div>
                </div>

                <button type="button" class="btn btn-primary mr" @click="add">
                    Nouveau Commande <i class="far fa-plus-square"></i>
                </button>
            </div>
            <div class="table-responsive">
                <table
                    class="table table-bordered"
                    id="dataTable"
                    width="100%"
                    cellspacing="0"
                >
                    <thead>
                        <tr>
                            <th>reference</th>
                            <th>Client</th>
                            <th>Prix Total</th>
                            <th>Etat</th>
                            <th>commandes Noms</th>
                            <th>Creer Par</th>
                            <th>Creer en</th>
                            <th>Modifier</th>
                            <th>Suprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="produit in commandes.data" :key="produit.id">
                            <td>{{ produit.ref }}</td>
                            <td>{{ produit.client.name }}</td>
                            <td>{{ produit.prixT + " DT" }}</td>
                            <td>{{ produit.etat }}</td>
                            <td>
                                <span
                                    v-for="(pro, i) in produit.produits"
                                    :key="pro.id + i"
                                >
                                    {{ pro.name }},
                                </span>
                            </td>
                            <td>{{ produit.user }}</td>
                            <td>{{ date(produit.created_at) }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-success"
                                    @click="edit(produit)"
                                >
                                    Modifier
                                </button>
                            </td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-danger"
                                    @click="delate(produit.id, produit.etat)"
                                >
                                    Suprimer
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <pagination
                :data="commandes"
                :limit="limit"
                @pagination-change-page="getResults"
                class=""
            ></pagination>
        </div>

        <div
            class="modal fade "
            id="imgModal"
            data-backdrop="static"
            data-keyboard="false"
            tabindex="-1"
            aria-labelledby="staticBackdropLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            Image
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <img
                                :src="image"
                                class="produitimag"
                                alt="loading..."
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="exampleModal"
            tabindex="-2"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            {{ name }}
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="save">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Reference</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="commande.ref"
                                        required
                                        minlength="2"
                                    />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="validationCustom04"
                                        >Client</label
                                    >
                                    <select
                                        class="custom-select"
                                        v-model="commande.client_id"
                                        required
                                    >
                                        <option
                                            v-for="cl in clients"
                                            :key="cl.id"
                                            :value="cl.id"
                                        >
                                            {{ cl.name }}</option
                                        >
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress"
                                    >Nombre des commandes</label
                                >
                                <input
                                    type="number"
                                    min="1"
                                    class="form-control"
                                    v-model="nProduit"
                                    @change="setTaille"
                                    @blur="setTaille"
                                />
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <select
                                        id="inputState"
                                        class="form-control"
                                        v-model="commande.etat"
                                        required
                                    >
                                        <option selected value="en cours"
                                            >En cours</option
                                        >
                                        <option value="valider">Valider</option>
                                        <option value="par site"
                                            >par site</option
                                        >

                                        <option value="retour">Retour</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <div class="form-check mb-2">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            id="autoSizingCheck"
                                            v-model="commande.gro"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="autoSizingCheck"
                                        >
                                            Gro ?
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="form-row"
                                v-for="n in parseInt(nP2)"
                                :key="n"
                            >
                                <div class="col form-group">
                                    <label for="validationCustom04"
                                        >Produit{{ n }}</label
                                    >
                                    <select
                                        class="custom-select"
                                        v-model="commande.produits[n - 1].id"
                                        @change="setproduit(n - 1)"
                                        required
                                    >
                                        <option
                                            v-for="pi in produits"
                                            :key="pi.id + n"
                                            :value="pi.id"
                                        >
                                            {{ pi.name }}</option
                                        >
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a Produit
                                    </div>
                                </div>

                                <div class="col form-group">
                                    <label for="validationCustom04"
                                        >Color</label
                                    >
                                    <input
                                        type="color"
                                        class="form-control"
                                        list="presetColors"
                                        v-model="commande.produits[n - 1].color"
                                        @change="setmt(n - 1)"
                                        required
                                    />
                                    <datalist id="presetColors">
                                        <option
                                            v-for="(c, i) in colors[n - 1]"
                                            :key="i"
                                            :value="i"
                                            :style="'background:' + i"
                                        >
                                        </option>
                                    </datalist>

                                    <div class="invalid-feedback">
                                        Please select a Produit
                                    </div>
                                </div>

                                <div class="col form-group">
                                    <label for="validationCustom04"
                                        >Taille</label
                                    >
                                    <select
                                        class="custom-select"
                                        v-model="commande.produits[n - 1].size"
                                        @change="setQ(n - 1)"
                                        required
                                    >
                                        <option
                                            v-for="s in sizes[n - 1]"
                                            :key="s.id"
                                            :value="s.size"
                                        >
                                            {{
                                                s.size +
                                                    "  ( En Stock : " +
                                                    s.qte +
                                                    ")"
                                            }}</option
                                        >
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a Produit
                                    </div>
                                </div>

                                <div class="col form-group">
                                    <label for="validationCustom05"
                                        >Quantité</label
                                    >

                                    <input
                                        type="number"
                                        :max="qte[n - 1]"
                                        class="form-control"
                                        required
                                        min="1"
                                        v-model="commande.produits[n - 1].qte"
                                    />
                                    <div class="invalid-feedback">
                                        Min 0
                                    </div>
                                </div>
                                <div class="col form-group">
                                    <label for="validationCustom05"
                                        >Image</label
                                    >
                                    <button
                                        type="button"
                                        class="btn btn-warning form-control"
                                        @click="showI(n - 1)"
                                    >
                                        <i class="far fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div
                                class="alert alert-danger"
                                role="alert"
                                v-if="error"
                            >
                                {{ error }}
                            </div>
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-dismiss="modal"
                                >
                                    Close
                                </button>
                                <input
                                    type="submit"
                                    class="btn btn-primary"
                                    value="Enregistrer"
                                />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="modal fade "
            id="imgModal"
            data-backdrop="static"
            data-keyboard="false"
            tabindex="-1"
            aria-labelledby="staticBackdropLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            Image
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <img
                                :src="image"
                                class="produitimag"
                                alt="loading..."
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {},
    data: function() {
        return {
            url: "/api/commandes",
            commandes: {},
            commande: {
                produits: [{ id: 0, qte: 0, color: "#ffffff", size: "m" }],
                id: -1,
                ref: "",
                prixT: 0,
                client_id: 0,
                gro: 0,
                etat: "en cours",
                lPorduit: [{ id: -1, qte: 0 }]
            },
            clients: [],
            produits: [],
            nProduit: 1,
            nP2: 1,
            etat: "all",
            name: "Nouveau Commande",
            q: "",
            qte: [],
            error: "",
            images: [],
            image: "",
            limit: 1,
            colors: [],
            sizes: []
        };
    },
    methods: {
        setproduit(n) {
            const groupBy = key => array =>
                array.reduce((objectsByKeyValue, obj) => {
                    const value = obj[key];
                    objectsByKeyValue[value] = (
                        objectsByKeyValue[value] || []
                    ).concat(obj);
                    return objectsByKeyValue;
                }, {});
            var pp = this.produits.find(
                e => e.id == this.commande.produits[n].id
            );
            this.colors[n] = groupBy("color")(pp.provar);
            this.commande.produits[n].color = Object.keys(this.colors[n])[0];
            this.sizes[n] = this.colors[n][this.commande.produits[n].color];
            this.commande.produits[n].size = "m";

            this.qte[n] = this.colors[n][this.commande.produits[n].color].find(
                e => e.size == this.commande.produits[n].size
            ).qte;

            this.images[n] = pp.img;
            this.$forceUpdate();
        },
        setproduitauto(n) {
            const groupBy = key => array =>
                array.reduce((objectsByKeyValue, obj) => {
                    const value = obj[key];
                    objectsByKeyValue[value] = (
                        objectsByKeyValue[value] || []
                    ).concat(obj);
                    return objectsByKeyValue;
                }, {});
            this.colors[n] = groupBy("color")(
                this.produits.find(e => e.id == this.commande.produits[n].id)
                    .provar
            );
            this.sizes[n] = this.colors[n][this.commande.produits[n].color];

            this.qte[n] = this.colors[n][this.commande.produits[n].color].find(
                e => e.size == this.commande.produits[n].size
            ).qte;

            this.$forceUpdate();
        },
        setmt(n) {
            this.sizes[n] = this.colors[n][this.commande.produits[n].color];
            this.qte[n] = this.colors[n][this.commande.produits[n].color].find(
                e => e.size == this.commande.produits[n].size
            ).qte;
            this.$forceUpdate();
        },
        showI(nn) {
            console.log("rr");
            this.image = "/storage/" + this.images[nn];
            $("#exampleModal").modal("hide");
            $("#imgModal").modal("show");
        },
        setQ(n) {
            this.qte[n] = this.colors[n][this.commande.produits[n].color].find(
                e => e.size == this.commande.produits[n].size
            ).qte;
            console.log(this.qte);
        },
        date(d) {
            var h = new Date(d);
            return (
                h.getDate() +
                "/" +
                h.getMonth() +
                "/" +
                h.getFullYear() +
                " (" +
                h.getHours() +
                ":" +
                h.getMinutes() +
                ")"
            );
        },
        getResults(page = 1) {
            axios
                .get(this.url + "/" + this.etat + "?page=" + page, {})
                .then(response => {
                    console.log(response);
                    if (response.data != "f") {
                        this.commandes = response.data;
                    } else {
                    }
                });
        },
        delate(id, etat) {
            if (confirm("tu veut le suprimer??")) {
                axios
                    .get(this.url + "/delate/" + id + "/" + etat, {})
                    .then(response => {
                        console.log(response);
                        if (response.data != "f") {
                            this.commandes = response.data;
                        } else {
                        }
                    });
            }
        },
        add() {
            this.error = "";
            //this.getAllproduits();
            this.commande = {
                produits: [{ id: 0, qte: 0, color: "#ffffff", size: "m" }],
                id: -1,
                ref: "",
                prixT: 0,
                client_id: this.$route.params.id,
                gro: 0,
                etat: "en cours"
            };
            this.nP2 = this.nProduit = 1;
            this.name = "Nouveau Commande";
            $("#exampleModal").modal("show");
        },
        edit(p) {
            // this.getAllproduits();
            this.error = "";
            this.commande = {
                produits: [{ id: 0, qte: 0, color: "#ffffff", size: "m" }],
                id: -1,
                ref: "",
                prixT: 0,
                client_id: 0,
                gro: 0,
                etat: "en cours",
                lPorduit: [{ id: -1, qte: 0 }]
            };
            this.commande.id = p.id;
            this.commande.ref = p.ref;
            this.commande.client_id = p.client_id;
            this.commande.gro = p.gro;
            this.commande.etat = p.etat;

            p.produits.forEach((element, index) => {
                this.commande.produits[index] = {
                    id: element.id,
                    qte: element.pivot.qte,
                    color: element.pivot.color,
                    size: element.pivot.size
                };

                this.setproduitauto(index);
                this.commande.lPorduit[index] = {
                    id: element.id,
                    qte: element.pivot.qte,
                    color: element.pivot.color,
                    size: element.pivot.size
                };
                this.images[index] = element.img;

                //this.setproduit(0);
                //  this.setproduit(1);
            });
            this.nProduit = this.nP2 = p.produits.length;
            this.name = "Edit => " + this.commande.ref;
            $("#exampleModal").modal("show");
        },
        save() {
            this.error = "";
            if (this.checkForm()) {
                return;
            }

            axios.post(this.url + "/add", this.commande).then(response => {
                if (response.data != "f") {
                    this.commandes = response.data;
                    $("#exampleModal").modal("hide");
                    this.getAllproduits();
                } else {
                    this.error = "erreur valider vos chois SVP";
                }
            });
        },
        search() {
            if (this.q.length > 1) {
                axios
                    .get(this.url + "/search/" + this.q + "/" + this.etat, {})
                    .then(response => {
                        console.log(response);
                        if (response.data != "f") {
                            this.commandes = response.data;
                        } else {
                        }
                    });
            } else {
                this.getResults();
            }
        },
        getAllClients() {
            axios.get(this.url + "/api/clients/all", {}).then(response => {
                console.log(response);
                if (response.data != "f") {
                    this.clients = response.data;
                } else {
                }
            });
        },
        getAllproduits() {
            axios.get("/api/produits/all", {}).then(response => {
                console.log(response);
                if (response.data != "f") {
                    this.produits = response.data.produits;
                    this.clients = response.data.clients;
                } else {
                }
            });
        },
        setTaille() {
            if (this.nProduit == "") this.nProduit = 1;
            if (this.nProduit > this.nP2) {
                for (
                    let i = this.commande.produits.length;
                    i < this.nProduit;
                    i++
                ) {
                    this.commande.produits[i] = { id: 0, qte: 0 };
                }
            } else if (this.nProduit < this.nP2) {
                for (
                    let i = this.commande.produits.length;
                    i >= this.nProduit;
                    i--
                ) {
                    this.commande.produits[i] = null;
                    console.log(".");
                }
            }
            this.nP2 = this.nProduit;
        },
        checkForm() {
            this.commande.produits.forEach((element, i) => {
                if (element != null) {
                    if (element.qte > this.qte[i] || element.qte < 1) {
                        this.error =
                            "Pas en stock pour produit n" +
                            i +
                            " ou quantité est null";
                        return true;
                    }
                }
            });

            return false;
        }
    },
    mounted() {
        this.getAllproduits();
    },
    created() {
        this.getResults();
    }
};
</script>

<style scoped>
.mr {
    position: absolute;
    right: 20px;
    top: 25px;
}
.card-body {
    position: relative;
}
h1.cu {
    margin: 35px 20px;
}
.fa-search {
    position: absolute;
    top: 9px;
    right: 12px;
    font-size: 20px;
    color: #6cb2eb;
}
.re {
    position: relative;
    /*max-width: 300px;*/
    min-width: 250px;
}
.pagination {
    margin: 0;
}
.col-auto {
    margin-top: 9px;
}
.produitimag {
    width: 80%;
    margin: auto;
    display: block;
}
.modal-dialog {
    max-width: 1000px;
}
@media only screen and (max-width: 768px) {
    .mr {
        top: -30px;
    }
}
</style>
