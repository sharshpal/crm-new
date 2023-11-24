import AppForm from '../app-components/Form/AppForm';

Vue.component('campagna-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                nome:  '' ,

            },
            mediaCollections: ['logo']
        }
    }

});
