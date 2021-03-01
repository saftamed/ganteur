<template>
    <div>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div
                                    class="card shadow-lg border-0 rounded-lg mt-5"
                                >
                                    <div class="card-header">
                                        <h3
                                            class="text-center font-weight-light my-4"
                                        >
                                            Login
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="form-group">
                                                <label
                                                    class="small mb-1"
                                                    for="inputEmailAddress"
                                                    >Email</label
                                                >
                                                <input
                                                    v-model="email"
                                                    class="form-control py-4"
                                                    v-on:keyup.enter="login"
                                                    type="email"
                                                    placeholder="Enter email address"
                                                />
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="small mb-1"
                                                    for="inputPassword"
                                                    >Password</label
                                                >
                                                <input
                                                    v-model="password"
                                                    class="form-control py-4"
                                                    v-on:keyup.enter="login"
                                                    type="password"
                                                    placeholder="Enter password"
                                                />
                                            </div>

                                            <div
                                                class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"
                                            >
                                                <a class="small error">{{
                                                    error
                                                }}</a>
                                                <div
                                                    @click="login"
                                                    v-on:keyup.enter="login"
                                                    class="btn btn-primary"
                                                >
                                                    Login
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            email: "",
            password: "",
            error: ""
        };
    },
    methods: {
        login() {
            axios
                .post("/api/login", {
                    email: this.email,
                    password: this.password
                })
                .then(response => {
                    if (response.data.token) {
                        console.log(response.data.token);
                        axios.defaults.headers.common["Authorization"] =
                            "Bearer " + response.data.token;
                        localStorage.setItem("token", response.data.token);
                        localStorage.setItem("name", response.data.name);
                        this.$emit("update");
                    } else {
                        this.error = "Failed to connect try again";
                    }
                });
            // console.log('hello');
        }
    },
    mounted() {
        if (typeof Storage !== "undefined") {
            if (localStorage.getItem("token")) {
                axios.defaults.headers.common["Authorization"] =
                    "Bearer " + localStorage.getItem("token");
                this.$emit("update");
            }
        }
    }
};
</script>

<style scoped>
.error {
    color: red;
}
.sb-topnav .navbar-brand {
    width: 275px;
}
</style>
