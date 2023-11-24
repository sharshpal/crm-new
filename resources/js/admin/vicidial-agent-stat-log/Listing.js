import VicidialAgentLogListing from '../vicidial-agent-log/Listing.js'
import {Italian} from "flatpickr/dist/l10n/it.js"

var _lodash = require('lodash');

export default {
    mixins: [VicidialAgentLogListing],
    props: {

    },
    computed: {

    },
    data: function data() {
        return {
            useCookieFilters: false,
            cookieFilterName: "Filter_Active_StatusesStat",
        }
    },
    methods:{


    }
};
