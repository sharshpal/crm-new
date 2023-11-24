import { BaseListing } from 'craftable';
import Utility from '../Utility';
import {Italian} from "flatpickr/dist/l10n/it.js"

function _interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {default: obj};
}

var _moment = require('moment');
var _moment2 = _interopRequireDefault(_moment);
require('moment-timezone');

export default {
	mixins: [BaseListing,Utility],
    data: function () {
        return {
            datePickerConfig: {
                enableTime: false,
                time_24hr: true,
                enableSeconds: true,
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'd/m/Y',
                locale: Italian,
                inline: false,
                onChange: this.onDateChanged
            },
            active:{}
        }
    },
    methods:{
	    onDateChanged(){},

    }
};
