import AppListing from '../app-components/Listing/AppListing';
import FileParserModal from '../components/FileParserModal';
import ExportExcelModal from "../components/ExportExcelModal";
import {Italian} from "flatpickr/dist/l10n/it.js"

var _lodash = require('lodash');

Vue.component('dati-contratto-listing', {
    mixins: [AppListing, FileParserModal, ExportExcelModal],
    props: {
        campaignsInput: String,
        esitiInput: String,
        selectableEsitiInput: String,
        partnersInput: String,
        exportUrl: String,
        exportableColumns: String,
        recallInput: String,
        searchUserRoute: String,
        bulkEditEsitoRoute: String
    },
    mounted() {

        var esitiData = JSON.parse(this.esitiInput);
        this.assignRefreshEsitiList(esitiData);

        this.cookieFilterName = "Filter_DatiContratto_List",
        this.recallCounters = JSON.parse(this.recallInput);
        this.useCookieFilters = true;
        this.preloadFilters();
        this.useCookieFilters = this.active.useCookieFilters;
        if(!this.useCookieFilters)
            this.clearList();

        //Remove status that no longer exists
        var tmpEsiti = [];
        for (let eIndex in this.active.esito) {
            let ae = this.active.esito[eIndex];
            for (let e of this.esitiList) {
                if (ae == e.id) {
                    tmpEsiti.push(e.id);
                    break;
                }
            }
        }

        this.active.esito = tmpEsiti;

        this.updateListCbk();
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
        selectableEsitiList: {
            get: function () {
                return JSON.parse(this.selectableEsitiInput);
            }
        },
    },
    data: function () {
        return {
            userList: [],
            momentDateTimeFormat: "YYYY-MM-DD HH:mm:ss",
            momentDateFormat: "YYYY-MM-DD",
            recallCounters: {
                "partial_min15": 0,
                "partial_min30": 0,
                "partial_min60": 0,
                "partial_today": 0,
                "partial_expired_today": 0,
                "partial_all_expired": 0,
                "tot_min15": 0,
                "tot_min30": 0,
                "tot_min60": 0,
                "tot_today": 0,
                "tot_expired_today": 0,
                "tot_all_expired": 0
            },
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
            file: null,
            selectedSheet: 1,
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

            recall_fromDatePickerConfig: {
                enableTime: true,
                time_24hr: true,
                enableSeconds: false,
                dateFormat: 'Y-m-d H:i:S',
                altInput: true,
                altFormat: 'd/m/Y H:i',
                locale: Italian,
                inline: false,
                onChange: this.recall_fromDatePickerChanged,
                disableMobile: true,
            },
            recall_toDatePickerConfig: {
                enableTime: true,
                time_24hr: true,
                enableSeconds: false,
                dateFormat: 'Y-m-d H:i:S',
                altInput: true,
                altFormat: 'd/m/Y H:i',
                locale: Italian,
                inline: false,
                onChange: this.recall_toDatePickerChanged,
                disableMobile: true,
            },
            liveEsiti: [],
            esitiList: [],
            active: {
                crm_user: "",
                fromDate: "",
                toDate: "",
                recall_fromDate: "",
                recall_toDate: "",
                campagna: [],
                partner: [],
                esito: [],
                tipo_inserimento: [],
                tipo_offerta: [],
                tipo_contratto: [],
                search: "",
                useCookieFilters: false
            },
            defaultActive: {
                fromDate: "",
                toDate: "",
                recall_fromDate: "",
                recall_toDate: "",
                campagna: [],
                partner: [],
                esito: [],
                tipo_inserimento: [],
                tipo_offerta: [],
                tipo_contratto: [],
                search: "",
                useCookieFilters: false
            },
            orderBy: {
                column: 'id',
                direction: 'desc'
            },
            currentNoteItem: null,
            currentEsitoItem: null,
            currentRecoverItem: null,
            selectedNewEsito: null,
            selectedNewBulkEsito: null,
            selectedRecovery_RecallAt: null,
            selectedRecovery_Note: null,
            selectedNote_NoteBo: null,
            searchUserIsLoading: false
        }
    },
    methods: {
        toggleSaveFilters(){
            this.useCookieFilters = !this.useCookieFilters;
            this.active.useCookieFilters = this.useCookieFilters;
            this.updateListCbk();
        },
        assignRefreshEsitiList(esitiData) {
            this.esitiList = esitiData.esiti;
            for (let e of this.esitiList) {
                e["mainTotal"] = e.partialCount;
                e["total"] = esitiData.total;
            }
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
        getRecallCounterLabel(partial, total) {
            return partial + (total > 0 && total != partial ? " / " + total : "");
        },
        saveRecoveryContract() {
            if (!this.currentRecoverItem) return;
            var _this = this;
            var route = this.currentRecoverItem.resource_url + '/recover';

            var dataToSend = {};
            if (this.selectedRecovery_RecallAt) {
                dataToSend["recall_at"] = this.selectedRecovery_RecallAt;
            }

            if (this.selectedRecovery_Note) {
                dataToSend["note_sv"] = this.selectedRecovery_Note;
            }

            axios.post(route, dataToSend)
                .then(function (response) {
                    _this.closeRecoverContrattoModal();
                    _this.updateListCbk();
                })
                .catch(function (errors) {
                    console.log(errors.response.data);
                });
        },

        closeRecoverContrattoModal() {
            this.currentRecoverItem = null;
            this.selectedRecovery_RecallAt = null;
            this.selectedRecovery_Note = null;
            this.$modal.hide('recover-contract-modal');
        },

        openRecoverContrattoModal(item) {
            this.currentRecoverItem = item;
            this.selectedRecovery_RecallAt = null;
            this.selectedRecovery_Note = null;
            this.$modal.show('recover-contract-modal');
        },
        saveNewEsito() {
            if (!this.currentEsitoItem || !this.selectedNewEsito) return;

            var _this = this;
            var route = this.currentEsitoItem.resource_url + '/edit-esito';

            //this.clearList();

            axios.post(route, {esito: this.selectedNewEsito.id})
                .then(function (response) {
                    _this.closeEsitoModal();
                    _this.updateListCbk();
                })
                .catch(function (errors) {
                    console.log(errors.response.data);
                });
        },
        bulkEditEsito() {
            var itemsToDelete = (0, _lodash.keys)((0, _lodash.pickBy)(this.bulkItems));
            if (itemsToDelete.length == 0) return;

            var _this = this;
            var route = this.bulkEditEsitoRoute;

            var dataToSend = {
                esito: this.selectedNewBulkEsito.id,
                ids: itemsToDelete
            };

            //this.clearList();

            axios.post(route, dataToSend)
                .then(function (response) {
                    _this.closeBulkEsitoModal();
                    _this.updateListCbk();
                })
                .catch(function (errors) {
                    console.log(errors.response.data);
                });
        },

        itemHasNotes(item) {
            return item.note_sv?.length || item.note_ope?.length || item.note_bo?.length || item.note_verifica?.length;
        },

        openNoteModal(item) {
            this.currentNoteItem = item;
            this.selectedNote_NoteBo = item.note_bo;
            this.$modal.show('note-modal');
        },

        closeNoteModal(item) {
            this.currentNoteItem = null;
            this.selectedNote_NoteBo = null;
            this.$modal.hide('note-modal');
        },

        saveNoteContract() {

            //if (!this.form || !this.form.note_bo || !this.currentNoteItem) return;

            var _this = this;
            var route = this.currentNoteItem.resource_url + '/edit-note';

            var dataToSend = {};

            if (this.selectedNote_NoteBo) {
                dataToSend["note_bo"] = this.selectedNote_NoteBo;
            }

            axios.post(route, dataToSend)
                .then(function (response) {
                    _this.closeNoteModal();
                    _this.updateListCbk();
                })
                .catch(function (errors) {
                    console.log(errors.response.data);
                });
        },



        openEsitoModal(item) {
            this.currentEsitoItem = item;
            this.selectedNewEsito = this.currentEsitoItem.esito;
            this.$modal.show('edit-esito-modal');
        },
        closeEsitoModal() {
            this.currentEsitoItem = null;
            this.selectedNewEsito = null;
            this.$modal.hide('edit-esito-modal');
        },

        openBulkEsitoModal() {
            this.selectedNewBulkEsito = this.selectableEsitiList.length ? this.selectableEsitiList[0] : {};
            this.$modal.show('bulk-edit-esito-modal');
        },
        closeBulkEsitoModal() {
            this.selectedNewBulkEsito = null;
            this.$modal.hide('bulk-edit-esito-modal');
        },

        isEsitoNegativo(item) {
            return (item.esito.is_final) && (!item.esito.is_ok);
        },
        isEsitoPositivo(item) {
            return item.esito.is_final && item.esito.is_ok;
        },
        isEsitoRecover(item) {
            return item.esito.is_recover;
        },
        clearAllFilters() {
            this.clearList();
            this.updateListCbk();
        },
        getFiltersOut() {
            this.refreshFilters();
            return this.filters;
        },
        importFileSelected(event) {
            this.file = event.target.files ? event.target.files[0] : null;
        },

        isCalling() {
            return this.refreshInProgress;
        },

        selectionHasElements() {
            return this.$data.collection.length > 0;
        },

        updateListCbk(skipReload) {
            this.onBulkItemsClickedAllUncheck();
            skipReload = typeof skipReload === "boolean" ? skipReload : false;
            if (this.isCalling()) return;
            this.refreshInProgress = true;
            var _this = this;
            var fallback = function () {
                _this.refreshInProgress = false
            };
            var fun = skipReload ? fallback : this.reloadEsiti();

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

        recall_fromDatePickerChanged(selectedDates, dateStr, target) {
            //changed still not executed
            if (this.active.recall_fromDate != dateStr) return;

            if (dateStr != "" && this.active.recall_toDate != "" && this.active.recall_toDate < dateStr) {
                this.active.recall_fromDate = this.active.recall_toDate;
                this.active.recall_toDate = dateStr;
            } else {
                this.updateListCbk();
            }
        },

        recall_toDatePickerChanged(selectedDates, dateStr, target) {
            if (dateStr != this.active.recall_toDate) return;

            if (dateStr != "" && this.active.recall_fromDate != "" && this.active.recall_fromDate > dateStr) {
                this.active.recall_toDate = this.active.recall_fromDate;
                this.active.recall_fromDate = dateStr;
            } else {
                this.updateListCbk();
            }
        },

        setRecallInterval(min) {
            var start = moment().format(this.momentDateTimeFormat);
            var end = moment().add(min, 'minutes').format(this.momentDateTimeFormat);
            this.active.recall_fromDate = start;
            this.active.recall_toDate = end;
        },
        setRecallToday() {
            var today = moment().format(this.momentDateFormat);
            this.active.recall_fromDate = today + " 00:00:00";
            this.active.recall_toDate = today + " 23:59:59";
        },
        setRecallExpiredToday() {
            var start = moment().format(this.momentDateFormat);
            var end = moment().subtract(1, 'minutes').format(this.momentDateTimeFormat);
            this.active.recall_fromDate = start + " 00:00:00";
            this.active.recall_toDate = end;
        },
        setRecallAllExpired() {
            var end = moment().subtract(1, 'minutes').format(this.momentDateTimeFormat);
            this.active.recall_fromDate = "";
            this.active.recall_toDate = end;
        },

        reloadEsiti(updateDataCount) {
            updateDataCount = typeof updateDataCount === "boolean" ? updateDataCount : true;
            var _this = this;

            return function refreshEsiti(response) {
                var esitiData = response.data.esiti;
                _this.assignRefreshEsitiList(esitiData);
                _this.liveEsiti = esitiData.esiti;
                for (let e of _this.esitiList) {
                    let found = false;
                    for (let le of _this.liveEsiti) {
                        if (le.id == e.id) {
                            found = true;
                            e.partialCount = le.partialCount;
                            break;
                        }
                    }

                    if (!found) {
                        e.partialCount = 0;
                    }

                    e.total = esitiData.total;
                }

                _this.recallCounters = response.data.recallCounters;

                _this.refreshInProgress = false;
            };
        },
        toggleEsitoFilter(id) {

            if (this.isEsitoFilterSelected(id)) {
                var t = this.active.esito.indexOf(id);
                this.active.esito.splice(t, 1);
            } else {
                this.active.esito.push(id);
                this.active.esito.sort();
            }

            this.updateListCbk();
        },
        isEsitoFilterSelected(id) {
            return (this.active.esito.indexOf(id) > -1);
        },
        hasGas(index) {
            let item = this.collection[index];
            return item.tipo_offerta && (item.tipo_offerta == 'gas' || item.tipo_offerta == 'lucegas');
        },
        hasLuce(index) {
            let item = this.collection[index];
            return item.tipo_offerta && (item.tipo_offerta == 'luce' || item.tipo_offerta == 'lucegas');
        },
        hasTelefonia(index) {
            let item = this.collection[index];
            return item.tipo_offerta && item.tipo_offerta == 'telefonia';
        },
    }
});
