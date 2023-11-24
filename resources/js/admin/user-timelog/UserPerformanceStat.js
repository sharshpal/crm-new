import AppListing from '../app-components/Listing/AppListing';
import {Italian} from "flatpickr/dist/l10n/it.js"

var _lodash = require('lodash');

Vue.component('user-performance-stat', {
    mixins: [AppListing],
    props: {
        exportUrl: String,
        partnersInput: String,
    },
    computed: {

        partnersList: {
            get: function () {
                return JSON.parse(this.partnersInput);
            }
        },

    },
    data: function(){
        return {
            useCookieFilters: false,
            momentDateTimeFormat: "YYYY-MM-DD HH:mm:ss",
            momentDateFormat: "YYYY-MM-DD",
            cookieFilterName: "Filter_User_Performance",
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
                partner: [],
            },
        }
    },
    methods:{
        roundNum(n,dec){
            return Math.round(n*(Math.pow(10,dec)))/Math.pow(10,dec);
        },
        getFiltersOut() {
            this.refreshFilters();
            return this.filters;
        },
        exportData: function () {

            var params = Object.assign({}, this.getFiltersOut());
            var url = this.exportUrl + '?' + $.param(params);

            var filename = "report.xlsx";

            axios.get(url, {
                responseType: 'blob',
            }).then(
                response => {
                    filename = response.headers["content-disposition"].replace('attachment; filename=\"',"").replace('\"',"");
                    return new Blob([response.data]);
                }
            )
                //.then(response => response.blob())
                .then(blob => {
                    var url = window.URL.createObjectURL(blob)
                    var a = document.createElement('a')
                    a.href = url
                    a.download = filename
                    a.click()
                    a.remove()
                    setTimeout(() => window.URL.revokeObjectURL(url), 100)
                })
                .catch(errors => {
                        console.log("Have error",errors);
                        if(errors.response && errors.response.data && errors.response.data.message) {
                            this.$notify({ type: 'error', title: 'Error!', text: errors.response.data.message})
                        }
                    }
                );
        },

        clearStartFilter() {
            this.active.fromDate = '';
            this.updateListCbk();
        },
        clearEndFilter() {
            this.active.toDate = '';
            this.updateListCbk();
        },
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
