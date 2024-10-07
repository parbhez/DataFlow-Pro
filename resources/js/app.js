import "./bootstrap"; //import bootstrap

import "https://cdn.jsdelivr.net/npm/apexcharts";

// import "../../public/assets/vendor/libs/jquery/jquery.js";

import "../../public/assets/vendor/fonts/boxicons.css";
import "../../public/assets/vendor/fonts/fontawesome.css";
import "../../public/assets/vendor/fonts/flag-icons.css";
import "../../public/assets/css/demo.css";
import "../../public/assets/css/custom.css";
import "../../public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css";
import "../../public/assets/vendor/libs/typeahead-js/typeahead.css";

import "../../public/assets/vendor/libs/popper/popper.js";
import "../../public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js";
import "../../public/assets/vendor/libs/hammer/hammer.js";
import "../../public/assets/vendor/libs/i18n/i18n.js";
import "../../public/assets/vendor/libs/typeahead-js/typeahead.js";
import "../../public/assets/js/main.js";

import { createApp } from "vue";

//import MainApp
import Home from "./components/Home.vue";

const app = createApp({}); //vue instance

// Disable Vue warnings
app.config.warnHandler = function (msg, vm, trace) {
    // You can log it or ignore it
    // console.warn(`[Vue warn]: ${msg}${trace}`);
};

app.component("home", Home);

app.mount("#app");
