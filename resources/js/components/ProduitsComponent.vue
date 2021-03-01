<template>
    <div>
        <h1 class="cu">Produits <i class="fas fa-box-open"></i></h1>
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
                                placeholder="Recherche des produits"
                            />
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

                <button type="button" class="btn btn-primary mr" @click="add">
                    Nouveau Produit <i class="far fa-plus-square"></i>
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
                            <th>Reference</th>
                            <th>Nom</th>
                            <th>Prix</th>
                            <th>Prix Gro</th>
                            <th>Quantité</th>
                            <th>Image</th>
                            <th>Fournisseur</th>
                            <th>Creer en</th>
                            <th>Modifier</th>
                            <th>Suprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="produit in produits.data" :key="produit.id">
                            <td>{{ produit.ref }}</td>
                            <td>{{ produit.name }}</td>
                            <td>{{ produit.prix + " DT" }}</td>
                            <td>{{ produit.prixG + " DT" }}</td>
                            <td>{{ produit.qte }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-warning"
                                    @click="show(produit.img)"
                                >
                                    Voir <i class="far fa-eye"></i>
                                </button>
                            </td>
                            <td>{{ produit.four }}</td>
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
                                    @click="delate(produit.id)"
                                >
                                    Suprimer
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <pagination
                :data="produits"
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
            id="modalPro"
            tabindex="-1"
            role="dialog"
            aria-labelledby="modalProLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalProLabel">
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
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="produit.name"
                                    />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4"
                                        >Reference</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="produit.ref"
                                    />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Fournisseur</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="produit.four"
                                />
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputCity">Prix</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        v-model="produit.prix"
                                    />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputZip">Prix en Gro</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        v-model="produit.prixG"
                                    />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Color n°= </label>
                                <input
                                    type="number"
                                    class="form-control"
                                    v-model="colorsi"
                                />
                            </div>
                            <div
                                v-for="c in parseInt(colors)"
                                :key="c"
                                class="gg"
                            >
                                <div class="form-group">
                                    <label for="inputAddress">Color </label>
                                    <input
                                        type="color"
                                        class="form-control"
                                        list="presetColors"
                                        v-model="produit.colors[c - 1].color"
                                    />
                                    <datalist id="presetColors">
                                        <option>#006600</option>
                                        <option>#00e600</option>
                                        <option>#0000cc</option>
                                        <option>#0066ff</option>
                                        <option>#ff0000</option>
                                        <option>#ff3333</option>
                                        <option>#ffff00</option>
                                        <option>#4d4d33</option>
                                        <option>#000000</option>
                                        <option>#ff6600</option>
                                        <option>#ff0066</option>
                                        <option>#cc00cc</option>
                                        <option>#ffffff</option>
                                        <option>#734d26</option>
                                        <option>#00ffff</option>
                                    </datalist>
                                </div>
                                <div class="form-row ">
                                    <div class="col form-group">
                                        <label for="inputAddress">L </label>
                                        <input
                                            type="number"
                                            min="1"
                                            class="form-control"
                                            placeholder="l size Qte"
                                            v-model="produit.colors[c - 1].l"
                                        />
                                    </div>
                                    <div class="col form-group">
                                        <label for="inputAddress">M </label>
                                        <input
                                            type="number"
                                            min="1"
                                            class="form-control"
                                            placeholder="m size Qte"
                                            v-model="produit.colors[c - 1].m"
                                        />
                                    </div>
                                    <div class="col form-group">
                                        <label for="inputAddress">XL </label>
                                        <input
                                            type="number"
                                            min="1"
                                            class="form-control"
                                            placeholder="xl size Qte"
                                            v-model="produit.colors[c - 1].xl"
                                        />
                                    </div>
                                </div>
                                <div class="form-row ">
                                    <div class="col form-group">
                                        <label for="inputAddress">2XL </label>
                                        <input
                                            type="number"
                                            min="1"
                                            class="form-control"
                                            placeholder="2xl size Qte"
                                            v-model="produit.colors[c - 1].xxl"
                                        />
                                    </div>
                                    <div class="col form-group">
                                        <label for="inputAddress">3XL </label>
                                        <input
                                            type="number"
                                            min="1"
                                            class="form-control"
                                            placeholder="3xl size Qte"
                                            v-model="produit.colors[c - 1].xxxl"
                                        />
                                    </div>
                                    <div class="col form-group">
                                        <label for="inputAddress">4XL </label>
                                        <input
                                            type="number"
                                            min="1"
                                            class="form-control"
                                            placeholder="4xl size Qte"
                                            v-model="
                                                produit.colors[c - 1].xxxxl
                                            "
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="custom-file">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    id="customFile"
                                    accept="image/*"
                                    @change="uploadImage($event)"
                                />
                                <label
                                    class="custom-file-label"
                                    for="customFile"
                                    >{{ nameI }}</label
                                >
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="save"
                        >
                            Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    watch: {
        colorsi: function(val) {
            var g = val;
            if (this.val == "") g = 1;
            if (this.colorsi > this.colors) {
                for (
                    let i = this.produit.colors.length;
                    i < this.colorsi;
                    i++
                ) {
                    this.produit.colors[i] = {
                        name: "",
                        l: 0,
                        m: 0,
                        xl: 0,
                        xxl: 0,
                        xxxl: 0,
                        xxxxl: 0
                    };
                }
            } else if (this.colorsi < this.colors) {
                console.log(this.produit.colors.length - 1);

                this.produit.colors.length = this.colorsi;
            }
            this.colors = this.colorsi;
        }
    },
    data: function() {
        return {
            url: "/api/produits",
            produits: {},
            produit: {
                name: "safta",
                four: "",
                id: -1,
                ref: "",
                prix: 0,
                prixG: 0,
                img: "",
                colors: [
                    {
                        color: "#ffffff",
                        l: 0,
                        m: 0,
                        xl: 0,
                        xxl: 0,
                        xxxl: 0,
                        xxxxl: 0
                    }
                ]
            },
            name: "Nouveau Produit",
            q: "",
            nameI: "Choisi une image",
            image: "",
            limit: 1,
            colors: 1,
            colorsi: 1
        };
    },
    methods: {
        setTaille() {},
        show(ii) {
            this.image = "/admin/public/storage/" + ii;
            $("#imgModal").modal("show");
        },
        uploadImage(event) {
            this.produit.img = event.target.files[0];
            this.nameI = this.produit.img.name;
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
            axios.get(this.url + "?page=" + page, {}).then(response => {
                console.log(response);
                if (response.data != "f") {
                    this.produits = response.data;
                } else {
                }
            });
        },
        delate(id) {
            if (confirm("tu veut le suprimer??")) {
                axios.get(this.url + "/delate/" + id, {}).then(response => {
                    console.log(response);
                    if (response.data != "f") {
                        this.produits = response.data;
                    } else {
                    }
                });
            }
        },
        add() {
            console.log(this.produit);
            this.colors = this.colorsi = 1;
            this.nameI = "Choisi une image";
            this.produit = {
                name: "",
                four: "",
                id: -1,
                ref: "",
                prix: 0,
                prixG: 0,
                img: "",
                colors: [
                    {
                        color: "#ffffff",
                        l: 0,
                        m: 0,
                        xl: 0,
                        xxl: 0,
                        xxxl: 0,
                        xxxxl: 0
                    }
                ]
            };
            this.name = "Nouveau Produit";
            $("#modalPro").modal("show");
        },
        edit(p) {
            this.nameI = "Choisi une image";
            const groupBy = key => array =>
                array.reduce((objectsByKeyValue, obj) => {
                    const value = obj[key];
                    objectsByKeyValue[value] = (
                        objectsByKeyValue[value] || []
                    ).concat(obj);
                    return objectsByKeyValue;
                }, {});
            var fg = groupBy("color")(p.provar);
            var c = [],
                i = 0;

            for (const [key, value] of Object.entries(fg)) {
                c[i] = { color: key };
                for (const [k, v] of Object.entries(value)) {
                    c[i][v.size] = v.qte;
                }
                i++;
            }
            //  delete p.provar;
            this.colorsi = this.colors = c.length;
            this.produit = { ...p, colors: c };
            this.name = "Edit => " + this.produit.name;
            $("#modalPro").modal("show");
        },
        save() {
            let data = new FormData();
            data.append("file", this.produit.img);
            data.append("name", this.produit.name);
            data.append("id", this.produit.id);
            data.append("ref", this.produit.ref);
            data.append("four", this.produit.four);
            data.append("prix", this.produit.prix);
            data.append("prixG", this.produit.prixG);
            data.append("colors", JSON.stringify(this.produit.colors));
            axios.post(this.url + "/add", data).then(response => {
                console.log(response);
                if (response.data != "f") {
                    this.produits = response.data;
                    $("#modalPro").modal("hide");
                } else {
                }
            });
        },
        search() {
            if (this.q.length > 1) {
                axios.get(this.url + "/search/" + this.q, {}).then(response => {
                    console.log(response);
                    if (response.data != "f") {
                        this.produits = response.data;
                    } else {
                    }
                });
            } else {
                this.getResults();
            }
        }
    },
    mounted() {},
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
.produitimag {
    width: 80%;
    margin: auto;
    display: block;
}
.gg {
    border: solid black 1px;
    padding: 15px;
    margin-bottom: 10px;
}
@media only screen and (max-width: 768px) {
    .mr {
        top: -30px;
    }
}
</style>
