import AppForm from '../app-components/Form/AppForm';
import {Italian} from "flatpickr/dist/l10n/it.js"

Vue.component('user-timelog-form', {
    mixins: [AppForm],
    props: {
        searchUserRoute: String
    },
    data: function() {
        return {
            form: {
                ore:  '' ,
                minuti:  '' ,
                user:  '' ,
                campagna:  '' ,
                period:  '' ,
            },
            userList: [],
            searchUserIsLoading : false,
            datePickerConfig: {
                enableTime: false,
                time_24hr: true,
                enableSeconds: false,
                dateFormat: 'Y-m-d H:i:S',
                altInput: true,
                altFormat: 'd/m/Y',
                locale: Italian,
                disableMobile: true,
                inline: false
            },
        }
    },
    methods: {
        resetUserList(){
            this.userList = [];
        },
        asyncUserFind(query) {

            if (query.length < 3) return;

            var _this = this;
            var dataToSend = {search: query};

            if (typeof window.LIT !== 'undefined') {
                clearTimeout(window.LIT);
            }

            window.LIT = setTimeout(() => {
                if (_this.form.campagna?.id) {
                    dataToSend["campagna"] = this.form.campagna.id;
                }
                if (_this.form.partner?.id) {
                    dataToSend["partner"] = this.form.partner.id;
                }

                _this.searchUserIsLoading = true;
                axios.post(this.searchUserRoute, dataToSend)
                    .then(function (response) {
                        _this.userList = response.data;
                        _this.searchUserIsLoading = false;
                    })
                    .catch(function (errors) {
                        console.log(errors.response.data);
                        _this.searchUserIsLoading = false;
                    });
            }, 300);
        },
    }

});
