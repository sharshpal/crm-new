import AppListing from '../app-components/Listing/AppListing';

var _lodash = require('lodash');

Vue.component('admin-user-listing', {
    mixins: [AppListing],
    props: {
        'activation': {
            type: Boolean,
            required: true
        },
        'u': String,
        'isAdmin': Boolean,
        bulkAssignCampaignRoute: String,
        campaignsInput: String,
    },
    computed: {
        campaignsList: {
            get: function () {
                return JSON.parse(this.campaignsInput);
            }
        }
    },
    data: function () {
        return {
            selectedNewBulkCampagna: null
        }
    },
    methods: {
        resendActivation(url) {
            axios.get(url).then(
                response => {
                    if(response.data.message) {
                        this.$notify({ type: 'success', title: 'Success', text: response.data.message});
                    } else if (response.data.redirect) {
                        window.location.replace(response.data.redirect);
                    }
                }
            ).catch(errors => {
                    if(errors.response.data.message) {
                        this.$notify({ type: 'error', title: 'Error!', text: errors.response.data.message})
                    }
                }
            );
        },
        impersonalLogin(url) {
            axios.get(url).then(
                response => {
                    if(response.data.message) {
                        this.$notify({ type: 'success', title: 'Success', text: response.data.message});
                    } else if (response.data.data.path) {
                        window.location.replace(response.data.data.path);
                    }
                }
            ).catch(errors => {
                    if(errors.response.data.message) {
                        this.$notify({ type: 'error', title: 'Error!', text: errors.response.data.message})
                    }
                }
            );
        },
        hasRole(index,role){
            if(this.collection[index]["roles"]){
                for(let r of this.collection[index]["roles"]){
                    if(r.name == role) return true;
                }
            }
            return false;
        },
        closeAssignBulkCampagnaModal() {
            this.selectedNewBulkCampagna = null;
            this.$modal.hide('bulk-assign-campagna-modal');
        },
        openAssignBulkCampagnaModal() {
            this.selectedNewBulkCampagna = null;
            this.$modal.show('bulk-assign-campagna-modal');
        },
        bulkAssignCampagna() {

            var itemsToAssign = (0, _lodash.keys)((0, _lodash.pickBy)(this.bulkItems));
            if (itemsToAssign.length == 0) return;

            var _this = this;
            var route = this.bulkAssignCampaignRoute;

            var dataToSend = {
                campagna: this.selectedNewBulkCampagna.id,
                ids: itemsToAssign
            };

            this.clearList();

            axios.post(route, dataToSend)
                .then(function (response) {
                    _this.onBulkItemsClickedAllUncheck();
                    _this.closeAssignBulkCampagnaModal();
                    _this.updateListCbk();
                })
                .catch(function (errors) {
                    console.log(errors.response.data);
                });
        },
        updateListCbk(){
            this.updateList();
        }
    },

});
