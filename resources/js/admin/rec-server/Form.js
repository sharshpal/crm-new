import AppForm from '../app-components/Form/AppForm';

Vue.component('rec-server-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                type:  '' ,
                db_driver:  '' ,
                db_host:  '' ,
                db_port:  '' ,
                db_name:  '' ,
                db_user:  '' ,
                db_password:  '' ,
                db_rewrite_host:  false ,
                db_rewrite_search:  '' ,
                db_rewrite_replace:  '' ,
            }
        }
    }

});
