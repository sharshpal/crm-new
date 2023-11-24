import AppForm from '../app-components/Form/AppForm';
import {Italian} from "flatpickr/dist/l10n/it.js"

const dailyHours = { from: 9 * 60, to: 21 * 60, class: 'business-hours' };
const saturdayHours = { from: 9 * 60, to: 21 * 60, class: 'business-hours' };

Vue.component('dati-contratto-form', {
    mixins: [AppForm],
    props: {
        campaignsInput: String,
        esitiInput: String,
        partnersInput: String,
        isEdit: Boolean,
        isNew: Boolean,
        isApi: Boolean,
        showCp: Boolean,
        searchUserRoute: String,
        fetchRecallUrl: String,
        timeSlot: {
            type: Number,
            default: 15
        },
        setCreatedAt: {
            type: Boolean,
            default: false
        }
    },
    mounted: function () {

        this.campaignsList = JSON.parse(this.campaignsInput);
        this.partnersList = JSON.parse(this.partnersInput);

        /*
        if (this.isApi) {
            this.onSetCampaign();
            return;
        }
        */

        if(this.form.recall_at){
            this.createEvent(new Date(this.form.recall_at));
        }

        if (!this.isNew) {
            this.form.partner = this.data.partner;
            this.form.campagna = this.data.campagna;
            this.form.tipo_offerta = this.data.tipo_offerta;
            this.form.tipo_inserimento = this.data.tipo_inserimento;
            return;
        } else {
            if (this.partnersList.length == 1) {
                this.form.partner = this.partnersList[0];
                this.onSetPartner(null, true);
            } else if (this.partnersList.length == 0) {
                if (this.campaignsList.length == 1) {
                    this.form.campagna = this.campaignsList[0];
                    this.onSetCampaign();
                }
            }
        }

        if(this.setCreatedAt){
            if( (null === this.form.created_at) || (undefined === this.form.created_at)) {
                var dt = moment();
                dt.tz("Europe/Rome");
                this.form.created_at = dt.format("YYYY-MM-DD HH:mm:ss");
            }
        }
        else{
            this.form.created_at = null;
        }

    },
    computed: {
        esitiList: {
            get: function () {
                return JSON.parse(this.esitiInput);
            }
        },
        minDate () {
            return new Date()
        }
    },
    data: function () {
        return {
            events: [],
            specialHours: {
                1: dailyHours,
                2: dailyHours,
                3: dailyHours,
                4: dailyHours,
                5: dailyHours,
                6: [saturdayHours],
            },
            mediaCollections: ['rec','doc'],
            campaignsList: [],
            partnersList: [],
            userList: [],
            use_fatt_residenza: false,
            use_forn_residenza: false,
            searchUserIsLoading : false,
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
            form: {
                campagna: '',
                crm_user: '',
                partner: '',
                codice_pratica: '',
                tipo_inserimento: '',
                tipo_offerta: '',
                tipo_contratto: '',
                owner_nome: '',
                owner_cognome: '',
                owner_dob: '',
                owner_pob: '',
                owner_cf: '',
                owner_tipo_doc: '',
                owner_nr_doc: '',
                owner_ente_doc: '',
                owner_doc_data: '',
                owner_doc_scadenza: '',
                owner_piva: '',
                owner_rag_soc: '',
                telefono: '',
                cellulare: '',
                owner_indirizzo: '',
                owner_civico: '',
                owner_comune: '',
                owner_prov: '',
                owner_cap: '',
                owner_az_nome_societa: '',
                owner_az_codice_business: '',
                owner_az_comune: '',
                owner_az_prov: '',
                owner_az_cap: '',
                forn_indirizzo: '',
                forn_civico: '',
                forn_comune: '',
                forn_prov: '',
                forn_cap: '',
                fatt_indirizzo: '',
                fatt_civico: '',
                fatt_comune: '',
                fatt_prov: '',
                fatt_cap: '',
                mod_pagamento: '',
                sdd_iban: '',
                sdd_ente: '',
                sdd_intestatario: '',
                sdd_cf: '',
                delega: '',
                delega_nome: '',
                delega_cognome: '',
                delega_dob: '',
                delega_pob: '',
                delega_cf: '',
                delega_tipo_doc: '',
                delega_nr_doc: '',
                delega_ente_doc: '',
                delega_doc_data: '',
                delega_doc_scadenza: '',
                delega_tipo_rapporto: '',
                titolarita_immobile: '',
                luce_polizza: false,
                luce_pod: '',
                luce_kw: '',
                luce_tensione: '',
                luce_consumo: '',
                luce_fornitore: '',
                luce_mercato: '',
                gas_polizza: false,
                gas_polizza_caldaia: false,
                gas_pdr: '',
                gas_consumo: '',
                gas_fornitore: '',
                gas_matricola: '',
                gas_remi: '',
                gas_mercato: '',
                tel_offerta: '',
                tel_cod_mig_voce: '',
                tel_cod_mig_adsl: '',
                tel_cellulare_assoc: '',
                tel_fornitore: '',
                note_ope: '',
                note_bo: '',
                note_sv: '',
                esito: '',
                id_rec: '',
                tipo_fatturazione: '',
                tipo_fatturazione_email: '',
                tipo_fatturazione_cartaceo: '',
                recall_at: ''
            }
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
        validateMultiSelect(fName, modelField) {
            this.$validator.validate(fName, modelField);
        },
        onToggleUseFattRes() {
            if (this.use_fatt_residenza) {
                this.onChangeIndResidenza();
            }
        },
        onToggleUseFornRes() {
            if (this.use_forn_residenza) {
                this.onChangeIndResidenza();
            }
        },
        onChangeIndResidenza() {
            if (this.use_fatt_residenza) {
                this.form.fatt_indirizzo = this.form.owner_indirizzo;
                this.form.fatt_civico = this.form.owner_civico;
                this.form.fatt_comune = this.form.owner_comune;
                this.form.fatt_prov = this.form.owner_prov;
                this.form.fatt_cap = this.form.owner_cap;
            }

            if (this.use_forn_residenza) {
                this.form.forn_indirizzo = this.form.owner_indirizzo;
                this.form.forn_civico = this.form.owner_civico;
                this.form.forn_comune = this.form.owner_comune;
                this.form.forn_prov = this.form.owner_prov;
                this.form.forn_cap = this.form.owner_cap;
            }

        },
        isFamily() {
            return (this.checkHasTipoContratto() ? this.form.tipo_contratto.id == 'family' : false);
        },
        isBusiness() {
            return (this.checkHasTipoContratto() ? this.form.tipo_contratto.id == 'business' : false);
        },
        hasGas() {
            return (this.checkHasTipoOfferta() ? (this.form.tipo_offerta.id == 'gas' || this.form.tipo_offerta.id == 'lucegas') : false);
        },
        hasLuce() {
            return (this.checkHasTipoOfferta() ? (this.form.tipo_offerta.id == 'luce' || this.form.tipo_offerta.id == 'lucegas') : false);
        },
        hasTelefonia() {
            return (this.checkHasTipoOfferta() ? this.form.tipo_offerta.id == 'telefonia' : false);
        },
        isTelefoniaMnp() {
            return this.hasTelefonia() && this.checkHasTipoPassaggio() ? this.form.tel_tipo_passaggio.id == "1" : false;
        },
        hasDelega() {
            return (this.form.delega && (this.form.delega === true || this.form.delega.id == "1"));
        },

        checkHasCampaign(){
            return ( (this.form.campagna && typeof this.form.campagna === "object") ? ("id" in this.form.campagna && "tipo" in this.form.campagna) : false );
        },

        checkHasTipoOfferta(){
            if(this.form.tipo_offerta && (typeof this.form.tipo_offerta === "object")){
                if(typeof this.form.tipo_offerta.id !== "undefined"){
                    return true;
                }
            }

            return false;
        },

        checkHasTipoPassaggio(){
            return ( (this.form.tel_tipo_passaggio && typeof this.form.tel_tipo_passaggio === "object") ? "id" in this.form.tel_tipo_passaggio : false );
        },

        checkHasTipoContratto(){
            return ( (this.form.tipo_contratto && typeof this.form.tipo_contratto === "object") ? "id" in this.form.tipo_contratto : false );
        },

        checkHasPartner(){
            return ( (this.form.partner && typeof this.form.partner === "object") ? "id" in this.form.partner : false );
        },

        onSetPartner(partner, isInit) {
            this.form.tipo_inserimento = '';
            this.form.tipo_offerta = '';
            isInit = isInit == undefined ? false : isInit;

            if (this.checkHasPartner()) {
                this.campaignsList = this.form.partner.campaigns;
                if (this.campaignsList.length == 1) {
                    this.form.campagna = JSON.parse(JSON.stringify(this.campaignsList[0]));
                    this.onSetCampaign();
                    return;
                }
                if (isInit) return;
            }

            this.form.campagna = '';
            this.onSetCampaign();
        },



        onSetCampaign() {
            this.form.tipo_inserimento = null;
            this.form.tipo_offerta = null;

            if (this.checkHasCampaign()) {
                var obj = {};
                if (this.form.campagna.tipo == "lucegas") {
                    obj = {id: 'lucegas', label: 'Luce + Gas'};

                } else if (this.form.campagna.tipo == "telefonia") {
                    obj = {id: 'telefonia', label: 'Telefonia'};
                }

                if ( typeof(obj)==="object" && "id" in obj) {
                    this.form.tipo_inserimento = obj;
                    this.form.tipo_offerta = obj;
                }
            }

            this.validateMultiSelect("tipo_offerta", this.form.tipo_offerta);
            this.validateMultiSelect("campagna", this.form.campagna);
            this.validateMultiSelect("tipo_contratto", this.form.tipo_contratto);
        },

        tipoOffertaList() {
            if (this.checkHasCampaign()) {
                if (this.form.campagna.tipo == "lucegas") {
                    return [
                        {id: 'lucegas', label: 'Luce + Gas'},
                        {id: 'luce', label: 'Luce'},
                        {id: 'gas', label: 'Gas'}
                    ];

                } else if (this.form.campagna.tipo == "telefonia") {
                    return [{id: 'telefonia', label: 'Telefonia'}]
                }
            }

            return [];
        },

        fetchEvents ({ view, startDate, endDate, week }) {

            var _this = this;
            let params = {fromDate: startDate.format("YYYY-MM-DD"), toDate: endDate.format("YYYY-MM-DD")};
            if(typeof this.form.id !== "undefined"){
                params["id"] = this.form.id;
            }

            axios.get(this.fetchRecallUrl, {params: params})
                .then(function (response) {
                  _this.events = [];
                  for(let ls of response.data.data){
                      let et = ls.day + " " + ls.hour + ":00:00";
                      let d = new Date(et);
                      _this.createEvent(d,true,60);
                      //for(let x = 0; x<(60/_this.timeSlot); x++){
                      //    _this.createEvent((new Date(et)).addMinutes(_this.timeSlot*x),true);
                      //}
                  }
                  if(_this.form.recall_at){
                      _this.createEvent(new Date(_this.form.recall_at));
                  }
                })
                .catch(function (errors) {
                    console.log(errors);
                    console.log(errors.response);
                });
        },

        hasRecallSet(){

          for(let e of this.events){
              if(e.background == false)
                return this.events.indexOf(e);
          }

          return -1;
        },
        hasSlotOccupied($evt){
            for(let e of this.events){
                if(e.start.getTime() === $evt.getTime()) return true;
            }

            return false;
        },

        createEvent($evt,bg,size){

            bg = typeof bg !== "boolean" ? false : bg;
            size = typeof size !== "number" ? this.timeSlot : size;


            if($evt.getHours()<9 || $evt.getHours()>20) return false;
            if(typeof this.$refs.vuecal === "undefined") return false;


            let rc = this.hasRecallSet();

            if(typeof this.events!=="undefined" && rc!=-1){
                if(!bg)
                    this.events.splice(rc,1);
            }

            this.$refs.vuecal.createEvent(
                $evt,
                size,
                { title: bg ? 'Non Disponibile' : 'RICHIAMO', class: bg ? 'not-available' : 'recall', background: bg}
            )
        },

        onEventCreate($evt){
            if(typeof this.events==="undefined")
                this.events = [];

            let d =  $evt.background ? 0 : $evt.startTimeMinutes%this.timeSlot;
            $evt.startTimeMinutes = $evt.startTimeMinutes-d;
            $evt.endTimeMinutes = $evt.endTimeMinutes-d;
            $evt.start = $evt.start.subtractMinutes(d);
            $evt.end = $evt.end.subtractMinutes(d);

            this.events.push($evt);
            if(!$evt.background){
               this.form.recall_at = $evt.start.format("YYYY-MM-DD HH:mm");
            }
        },

        getVueCalSlot(){

          if(!this.$refs.vuecal) return 60;

          if(this.$refs.vuecal.activeView=='week') return 60;
          if(this.$refs.vuecal.activeView=='day') return 5;
          return 120;
        },

        onEventDblclick($evt,e){
            console.log("Evt Dbl Click: ",$evt,e);
            e.stopPropagation();
        },

        getRecallAt(){
            if(!this.form.recall_at) return '';
            return (new Date(this.form.recall_at)).format("DD/MM/YYYY HH:mm");
        },

        clearRecallAt(){
            if(!this.form.recall_at) return;
            let rc = this.hasRecallSet();
            if(rc!=-1){
                this.events.splice(rc,1);
                this.form.recall_at = '';
            }
        }
    }


});
