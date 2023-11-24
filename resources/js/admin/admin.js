import './bootstrap';

import 'vue-multiselect/dist/vue-multiselect.min.css';
import flatPickr from 'vue-flatpickr-component';
import VueQuillEditor from 'vue-quill-editor';
import Notifications from 'vue-notification';
import Multiselect from 'vue-multiselect';
import VeeValidate from 'vee-validate';
import 'flatpickr/dist/flatpickr.css';
import VueCookie from 'vue-cookie';
import {Admin} from 'craftable';
import VModal from 'vue-js-modal'
import Vue from 'vue';

import Verte from 'verte';
import 'verte/dist/verte.css';

import moment from 'moment';

import VueCal from 'vue-cal';
import 'vue-cal/dist/i18n/it.js'
import 'vue-cal/dist/vuecal.css';
//import 'vue-cal/dist/drag-and-drop.js'

import it_validation_messages from '../lang/it_validator_messages.js';

import './app-components/bootstrap';
import './index';

import 'craftable/dist/ui';


// register component globally
Vue.component(Verte.name, Verte);

Vue.component('multiselect', Multiselect);

Vue.use(VeeValidate, {
    strict: true,
    locale: 'it',
    dictionary: {
        it: {messages: it_validation_messages}
    }
});
Vue.component('datetime', flatPickr);
Vue.component("vue-cal",VueCal);
Vue.use(VModal, {dialog: true, dynamic: true, injectModalsContainer: true});
Vue.use(VueQuillEditor);
Vue.use(Notifications);
Vue.use(VueCookie);


Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY')
    }
});

Vue.filter('formatDateTime', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY HH:mm')
    }
});

new Vue({
    mixins: [Admin],
});
