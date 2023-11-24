import AppListing from '../app-components/Listing/AppListing';

Vue.component('recording-log-listing', {
    mixins: [AppListing],
    props: {
        recServerInput: String,
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
            useCookieFilters: false,
            cookieFilterName: "Filter_Active_RecSrv",
            orderBy: {
                column: 'recording_id',
                direction: 'asc'

            },
            active: {
                server: '',
                search: '',
            }
        }
    },
    mounted() {
        window.addEventListener("play", function (evt) {
            if (window.$_currentlyPlaying) {
                window.$_currentlyPlaying.pause();
            }
            window.$_currentlyPlaying = evt.target;
        }, true);
    },
    methods:{
        loadDataErrorHandler: function(error){
            let msg = "Errore durante l'esecuzione della query";
            if(error && error.response && error.response.data && error.response.data.message){
                msg = error.response.data.message;
            }
            this.$notify({ type: 'error', title: 'Errore!', text: msg, duration: 4000 });
        }
    }
});
