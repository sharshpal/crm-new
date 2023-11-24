import AppForm from '../app-components/Form/AppForm';

Vue.component('admin-user-form', {
    mixins: [AppForm],
    props:{
        campaignsInput: String,
        partnersInput: String,
        activation: Boolean,
        isCreate: Boolean
    },
    mounted(){
      if(this.form.roles && this.form.roles.length==1){
          this.form.roles = this.form.roles[0];
        }
    },
    computed: {
        campaignsList: {
            get: function () {
                return JSON.parse(this.campaignsInput);
            }
        },
        partnersList:{
            get: function () {
                return JSON.parse(this.partnersInput);
            }
        }
    },
    data: function() {
        return {
            form: {
                first_name:  '' ,
                last_name:  '' ,
                email:  '' ,
                password:  '' ,
                activated:  false ,
                forbidden:  false ,
                language:  '' ,
                campaigns: [],
                partners: []
            }
        }
    },
    methods:{
        assignAllPartners(){
            this.form.partners = this.partnersList;
        },
        clearAllPartners(){
            this.form.partners = [];
        },

        assignAllCampaigns(){
            this.form.campaigns = this.campaignsList;
        },
        clearAllCampaigns(){
            this.form.campaigns = [];
        },

        isSimpleOperator(){
          return this.form.roles && (this.form.roles.name=='Partner' || this.form.roles.name=='Operatore' );
        }
    }
});
