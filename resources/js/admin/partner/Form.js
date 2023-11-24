import AppForm from '../app-components/Form/AppForm';

Vue.component('partner-form', {
    mixins: [AppForm],
    props:{
        campaignsInput: String,
    },
    computed: {
        campaignsList: {
            get: function () {
                return JSON.parse(this.campaignsInput);
            }
        }
    },
    data: function() {
        return {
            form: {
                nome:  '' ,
                partner: '',
                campaigns: []
            },
            mediaCollections: ['logo']
        }
    }

});
