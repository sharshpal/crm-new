import AppListing from '../app-components/Listing/AppListing';

var _lodash = require('lodash');

Vue.component('partner-listing', {
    mixins: [AppListing],
    props:{
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
