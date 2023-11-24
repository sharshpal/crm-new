import AppListing from '../app-components/Listing/AppListing';
import {Italian} from "flatpickr/dist/l10n/it.js"

var _lodash = require('lodash');

Vue.component('statistiche-esiti', {
    mixins: [AppListing],
    props: {
        campaignsInput: String,
        partnersInput: String,
        searchUserRoute: String,
        esitiInput: String,
        exportUrl: String
    },
    mounted() {

    },
    computed: {
        campaignsList: {
            get: function () {
                return JSON.parse(this.campaignsInput);
            }
        },
        partnersList: {
            get: function () {
                return JSON.parse(this.partnersInput);
            }
        },
        esitiList:{
            get: function () {
                return JSON.parse(this.esitiInput);
            }
        }
    },
    data: function () {
        return {
            userList: [],
            momentDateTimeFormat: "YYYY-MM-DD HH:mm:ss",
            momentDateFormat: "YYYY-MM-DD",
            cookieFilterName: "Filter_StatEsiti",
            useCookieFilters: false,
            datetimePickerConfig: {
                enableTime: true,
                time_24hr: true,
                enableSeconds: false,
                dateFormat: 'Y-m-d H:i:S',
                altInput: true,
                altFormat: 'd/m/Y H:i',
                locale: Italian,
                disableMobile: true,
                inline: false
            },

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
                crm_user: [],
                fromDate: "",
                toDate: "",
                campagna: [],
                partner: [],
                tipo_inserimento: [],
                tipo_offerta: [],
                tipo_contratto: [],
                search: "",
                groupByLabel : false,
                groupByCampagna : false,
                groupByPartner : false,
                groupByUser : false
            },
            defaultActive: {
                crm_user: [],
                fromDate: "",
                toDate: "",
                campagna: [],
                partner: [],
                tipo_inserimento: [],
                tipo_offerta: [],
                tipo_contratto: [],
                search: "",
                groupByLabel : false,
                groupByCampagna : false,
                groupByPartner : false,
                groupByUser : false
            },
            orderBy: {
                column: 'id',
                direction: 'desc'
            },
            searchUserIsLoading: false,

        }
    },
    methods: {
        isSameGroup(index){

            if(index==0) return true;

            let t = this.collection.esiti[index-1];
            let ct = this.collection.esiti[index];

            let sameGroup = true;
            if(this.collection.groupByPartner && ct.pid){
                if (!t.pid || ct.pid != t.pid) sameGroup=false;
            }
            if(this.collection.groupByCampagna && ct.cid){
                if(!t.cid || ct.cid != t.cid) sameGroup=false;
            }
            if(this.collection.groupByUser && ct.cuid) {
                if (!t.cuid || ct.cuid != t.cuid) sameGroup=false;
            }

            return sameGroup;
        },
        getGroupTotalSchede: function(item){
            for(let tg of this.collection.totalGroup){

                let found = true;
                if(tg.pid) {
                    if (!(item.pid && tg.pid == item.pid)) found=false;
                }
                if(tg.cid){
                    if(!(item.cid && tg.cid == item.cid)) found=false;
                }
                if(tg.cuid) {
                    if (!(item.cuid && tg.cuid == item.cuid)) found=false;
                }

                if (found) return tg.totalGroup;
            }

            return item.partialCount;
        },
        getGroupTotalSchedePercent: function(item){
            return Math.round( (item.partialCount*100/this.getGroupTotalSchede(item))*100 )/100;
        },
        getGroupTotalPz: function(item){
            for(let tg of this.collection.totalGroup){
                let found = true;
                if(tg.pid) {
                    if (!(item.pid && tg.pid == item.pid)) found=false;
                }
                if(tg.cid){
                    if(!(item.cid && tg.cid == item.cid)) found=false;
                }
                if(tg.cuid) {
                    if (!(item.cuid && tg.cuid == item.cuid)) found=false;
                }

                if (found) return tg.totalGroupPz;
            }

            return item.partialCountPz;
        },
        getGroupTotalPzPercent: function(item){
            return Math.round( (item.partialCountPz*100/this.getGroupTotalPz(item))*100 )/100;
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

        toggleGroupByPartner(){
            this.collection.groupByPartner = !this.collection.groupByPartner;
            this.active.groupByPartner = this.collection.groupByPartner;
            this.updateListCbk();
        },

        toggleGroupByCampagna(){
            this.collection.groupByCampagna = !this.collection.groupByCampagna;
            this.active.groupByCampagna = this.collection.groupByCampagna;
            this.updateListCbk();
        },

        toggleGroupByUser(){
            this.collection.groupByUser = !this.collection.groupByUser;
            this.active.groupByUser = this.collection.groupByUser;
            this.updateListCbk();
        },

        toggleGroupByLabel(){
            this.collection.groupByLabel = !this.collection.groupByLabel;
            this.active.groupByLabel = this.collection.groupByLabel;
            this.updateListCbk();
        },

        getPezziPercent(item){
          return Math.round((item.partialCountPz * 100 / this.collection.totalPz)*100)/100;
        },

        getSchedePercent(item){
            return Math.round((item.partialCount * 100 / this.collection.total)*100)/100;
        },

        getCountLabel(item){
          return item.partialCount + " / " + this.collection.total;
        },

        resetUserList() {
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


        isEsitoNegativo(item) {
            return (item.esito.is_final) && (!item.esito.is_ok);
        },
        isEsitoPositivo(item) {
            return item.esito.is_final && item.esito.is_ok;
        },

        clearAllFilters() {
            this.collection.groupByLabel = false;
            this.collection.groupByCampagna = false;
            this.collection.groupByPartner = false;
            this.collection.groupByUser = false;
            this.clearList();
            this.updateListCbk();
        },
        getFiltersOut() {
            this.refreshFilters();
            return this.filters;
        },


        isCalling() {
            return this.refreshInProgress;
        },


        updateListCbk(skipReload) {

            skipReload = typeof skipReload === "boolean" ? skipReload : false;
            if (this.isCalling()) return;
            this.refreshInProgress = true;
            var _this = this;
            var fallback = function () {
                _this.refreshInProgress = false
            };
            var fun = skipReload ? fallback : this.reloadData();

            this.updateList(fun);
        },
        clearStartFilter() {
            this.active.fromDate = "";
        },
        clearEndFilter() {
            this.active.toDate = "";
        },
        clearRecallStartFilter() {
            this.active.recall_fromDate = "";
        },
        clearRecallEndFilter() {
            this.active.recall_toDate = "";
        },
        fromDatePickerChanged(selectedDates, dateStr, target) {
            //changed still not executed
            if (this.active.fromDate != dateStr) return;

            if (dateStr != "" && this.active.toDate != "" && this.active.toDate < dateStr) {
                this.active.fromDate = this.active.toDate;
                this.active.toDate = dateStr;
            } else {
                this.updateListCbk();
            }
        },
        toDatePickerChanged(selectedDates, dateStr, target) {

            if (dateStr != this.active.toDate) return;

            if (dateStr != "" && this.active.fromDate != "" && this.active.fromDate > dateStr) {
                //this.$refs.toDateInput.$data.fp.setDate(this.active.fromDate,false);
                //this.$refs.fromDateInput.$data.fp.setDate(dateStr,false);
                this.active.toDate = this.active.fromDate;
                this.active.fromDate = dateStr;
            } else {
                this.updateListCbk();
            }
        },

        reloadData() {
            var _this = this;

            return function refreshData(response) {
                _this.collection = response.data.data.data;
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
