import AppForm from '../app-components/Form/AppForm';

Vue.component('esito-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                nome:  '' ,
                is_final: 0,
                is_ok: 0,
            }
        }
    }

});
