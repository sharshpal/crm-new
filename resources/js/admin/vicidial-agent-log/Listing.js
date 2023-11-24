import AppListing from '../app-components/Listing/AppListing';
import {Italian} from "flatpickr/dist/l10n/it.js"

var _lodash = require('lodash');

export default {
    mixins: [AppListing],
    props: {
        recServerInput: String,
        exportUrl: String
    },
    computed: {
        recServerList: {
            get: function () {
                return JSON.parse(this.recServerInput);
            }
        },
    },
    data: function data() {
        return {
            showSeconds: false,
            showHours: true,
            useCookieFilters: false,
            momentDateTimeFormat: "YYYY-MM-DD HH:mm:ss",
            momentDateFormat: "YYYY-MM-DD",
            cookieFilterName: "Filter_Active_TimeStat",
            refreshInProgress: false,
            orderBy: {
                column: 'user',
                direction: 'asc'
            },
            active: {
                server: null,
                search: '',
                fromDate: null,
                toDate: null,
                campaign_id: null,
            },
            fromDatePickerConfig: {
                enableTime: false,
                dateFormat: 'Y-m-d H:i:S',
                altInput: true,
                altFormat: 'd/m/Y',
                locale: Italian,
                inline: false,
                onChange: this.fromDatePickerChanged,
                disableMobile: true,
            },
            toDatePickerConfig: {
                enableTime: false,
                dateFormat: 'Y-m-d H:i:S',
                altInput: true,
                altFormat: 'd/m/Y',
                locale: Italian,
                inline: false,
                onChange: this.toDatePickerChanged,
                disableMobile: true,
            },
            campaignsList: []
        }
    },
    methods:{
        getPercent(a,b){
            return Math.round((a*100/b)*100)/100;
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
        reloadServer(srv){
            this.active.server = srv;
            this.active.campaign_id = null;
            this.active.search='';
            this.setWeek();
            //this.updateListCbk();
            //
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
        loadDataErrorHandler: function(error){
            let msg = "Errore durante l'esecuzione della query";
            if(error && error.response && error.response.data && error.response.data.message){
                msg = error.response.data.message;
            }
            this.$notify({ type: 'error', title: 'Errore!', text: msg, duration: 4000 });
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
            if (this.active.fromDate == dateStr) return;

            if (dateStr != "" && this.active.toDate != "" && this.active.toDate < dateStr) {
                //this.$refs.fromDateInput.$data.fp.setDate(this.active.toDate,false);
                //this.$refs.toDateInput.$data.fp.setDate(dateStr,false);
                this.active.fromDate = this.active.toDate;
                this.active.toDate = dateStr;

            }
            else{
                this.active.fromDate = dateStr;
            }

            this.updateListCbk();
        },

        toDatePickerChanged(selectedDates, dateStr, target) {
            if (dateStr == this.active.toDate) return;

            if (dateStr != "" && this.active.fromDate != "" && this.active.fromDate > dateStr) {
                //this.$refs.toDateInput.$data.fp.setDate(this.active.fromDate,false);
                //this.$refs.fromDateInput.$data.fp.setDate(dateStr,false);
                this.active.toDate = this.active.fromDate;
                this.active.fromDate = dateStr;

            }
            else{
                this.active.toDate = dateStr;
            }

            this.updateListCbk();
        },

        reloadData() {
            var _this = this;

            return function refreshData(response) {
                _this.campaignsList = response.data.campaigns;
                _this.refreshInProgress = false;
            };
        },
        isCalling() {
            return this.refreshInProgress || this.$parent.loading;
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
};
