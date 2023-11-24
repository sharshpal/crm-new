import AppListing from '../app-components/Listing/AppListing';
import {Italian} from "flatpickr/dist/l10n/it.js"

var _lodash = require('lodash');

Vue.component('user-timelog-listing', {
    mixins: [AppListing],
    data: function(){
        return {
            useCookieFilters: false,
            momentDateTimeFormat: "YYYY-MM-DD HH:mm:ss",
            momentDateFormat: "YYYY-MM-DD",
            cookieFilterName: "Filter_User_Timelog",
            refreshInProgress: false,
            fromDatePickerConfig: {
                enableTime: false,
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'd/m/Y',
                locale: Italian,
                inline: false,
                onChange: this.fromDatePickerChanged,
                disableMobile: true,
            },
            toDatePickerConfig: {
                enableTime: false,
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'd/m/Y',
                locale: Italian,
                inline: false,
                onChange: this.toDatePickerChanged,
                disableMobile: true,
            },
            active: {
                search: '',
                fromDate: null,
                toDate: null,
            },
        }
    },
    methods:{
        fromDatePickerChanged(selectedDates, dateStr, target) {

            //changed still not executed
            if (this.active.fromDate != dateStr) return;

            if (dateStr != "" && this.active.toDate != "" && this.active.toDate < dateStr) {
                //this.$refs.fromDateInput.$data.fp.setDate(this.active.toDate,false);
                //this.$refs.toDateInput.$data.fp.setDate(dateStr,false);
                this.active.fromDate = this.active.toDate;
                this.active.toDate = dateStr;
            }

            this.updateListCbk();
        },
        toDatePickerChanged(selectedDates, dateStr, target) {

            if (dateStr != this.active.toDate) return;

            if (dateStr != "" && this.active.fromDate != "" && this.active.fromDate > dateStr) {
                //this.$refs.toDateInput.$data.fp.setDate(this.active.fromDate,false);
                //this.$refs.fromDateInput.$data.fp.setDate(dateStr,false);
                this.active.toDate = this.active.fromDate;
                this.active.fromDate = dateStr;
            }

            this.updateListCbk();
        },

        clearStartFilter() {
            this.active.fromDate = '';
            this.updateListCbk();
        },
        clearEndFilter() {
            this.active.toDate = '';
            this.updateListCbk();
        },

        updateListCbk(skipReload) {

            skipReload = typeof skipReload === "boolean" ? skipReload : false;
            if (this.isCalling()) { console.log("retuurrrn"); return;}
            this.refreshInProgress = true;
            var _this = this;
            var fallback = function () {
                _this.refreshInProgress = false
            };
            var fun = skipReload ? fallback : this.reloadData();

            this.updateList(fun);
        },

        isCalling() {
            return this.refreshInProgress || this.$parent.loading;
        },

        reloadData() {
            var _this = this;

            return function refreshData(response) {
                //_this.campaignsList = response.data.campaigns;
                _this.refreshInProgress = false;
            };
        },

        setToday() {
            var today = moment().format(this.momentDateFormat);
            //this.$refs.fromDateInput.$data.fp.setDate(start,false);
            //this.$refs.toDateInput.$data.fp.setDate(end,true);
            this.active.fromDate = today + " 00:00:00";
            this.active.toDate = today + " 23:59:59";
            this.updateListCbk();
            console.log(today);
        },
        setWeek() {
            var start = moment().startOf('week').format(this.momentDateFormat);
            var end = moment().endOf('week').format(this.momentDateFormat);
            //this.$refs.fromDateInput.$data.fp.setDate(start,false);
            //this.$refs.toDateInput.$data.fp.setDate(end,false);
            this.active.fromDate = start + " 00:00:00";
            this.active.toDate = end + " 23:59:59";

            this.updateListCbk();
            console.log(start,end);
        },
        setMonth() {
            var start = moment().startOf('month').format(this.momentDateFormat);
            var end = moment().endOf('month').format(this.momentDateFormat);
            //this.$refs.fromDateInput.$data.fp.setDate(start,false);
            //this.$refs.toDateInput.$data.fp.setDate(end,true);
            this.active.fromDate = start + " 00:00:00";
            this.active.toDate = end + " 23:59:59";
            this.updateListCbk();
            console.log(start,end);
        },
        setYear() {
            var start = moment().startOf('year').format(this.momentDateFormat);
            var end = moment().endOf('year').format(this.momentDateFormat);
            //this.$refs.fromDateInput.$data.fp.setDate(start,false);
            //this.$refs.toDateInput.$data.fp.setDate(end,true);
            this.active.fromDate = start + " 00:00:00";
            this.active.toDate = end + " 23:59:59";
            this.updateListCbk();
            console.log(start,end);
        },
    }
});
