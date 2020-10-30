import Vue from "vue";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";

Vue.use(Vuetify);

const opts = {
	theme: {
		dark: true,
		themes: {
			dark: {
				primary: "#B537F2",
				secondary: "#3Cb9fc",
				success: "#94DDBC",
				error: "#9C3848",
				warning: "#F5E663"
			}
		}
	}
};

export default new Vuetify(opts);
