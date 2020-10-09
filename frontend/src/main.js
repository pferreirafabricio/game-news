import Vue from 'vue';
import Vuesax from 'vuesax';
import App from './App.vue';

import 'vuesax/dist/vuesax.css';
import 'material-icons/iconfont/material-icons.css';

Vue.config.productionTip = false;
Vue.use(Vuesax, {});

new Vue({
  render: (h) => h(App),
}).$mount('#app');
