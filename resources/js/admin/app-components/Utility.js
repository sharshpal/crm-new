import axios from "axios";

function _interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {default: obj};
}

var _moment = require('moment');
var _moment2 = _interopRequireDefault(_moment);
require('moment-timezone');

export default {
    data() {
        return {
            ignoreReload: false,
            useCookieFilters: true,
            cookieFilterName: "Filter_Active",
            lastFiltersHash: '',
            lastFilterTs: 0,
            pagination: {
                state: {
                    per_page: this.$cookie.get('per_page') || 10, // required
                    current_page: 1, // required
                    last_page: 1, // required
                    from: 1,
                    to: 10 // required
                },
                options: {
                    alwaysShowPrevNext: true
                }
            },
        }
    },
    mounted() {
        if (!this.useCookieFilters) {
            this.clearList();
        }
    },

    methods: {
        loadDataErrorHandler: function(error){

        },
        getDefaultFilters: function () {
            return JSON.parse(JSON.stringify(this.defaultActive ? this.defaultActive : {}));
        },
        setCookie: function (name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        },
        getCookie: function (name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        },
        eraseCookie: function (name) {
            document.cookie = name + '= ; expires = Thu, 01 Jan 1970 00:00:00 GMT; path=/';
        },
        clearList: function () {
            this.eraseCookie(this.cookieFilterName);
            this.active = this.getDefaultFilters();
        },
        clearAllLists(){
            var t = document.cookie.split(';').reduce((cookies, cookie) => {
                const [ name, value ] = cookie.split('=').map(c => c.trim());
                if(name.startsWith("Filter_")) cookies[name] = value;
                return cookies;
            }, {});
            for(let ckey in t){
                this.eraseCookie(ckey);
            }
        },
        preloadFilters: function (preloadFun) {
            var active = JSON.parse(this.getCookie(this.cookieFilterName));
            this.active = active == null ? this.getDefaultFilters() : active;
        },
        hashString(str) {
            var hash = 0;
            for (var i = 0; i < str.length; i++) {
                var character = str.charCodeAt(i);
                hash = ((hash << 5) - hash) + character;
                hash = hash & hash; // Convert to 32bit integer
            }
            return hash;
        },

        refreshFilters() {
            var _this = this;
            for (var name in _this.active) {
                if (_this.active[name] == null || (Array.isArray(_this.active[name]) && _this.active[name].length==0)) {
                     delete _this.filters[name];
                     continue;
                }

                if (Array.isArray(_this.active[name]) && _this.active[name].length) {
                    var ids = [];
                    for (var i in _this.active[name]) {
                        if (_this.active[name][i].id != null) {
                            ids.push(_this.active[name][i].id);
                        } else if (_this.active[name][i].name != null) {
                            ids.push(_this.active[name][i][name]);
                        } else {
                            ids.push(_this.active[name][i]);
                        }
                    }
                    _this.filters[name] = ids;
                } else if ((typeof _this.active[name]["id"]) !== "undefined") {
                    _this.filters[name] = _this.active[name]["id"];
                } else if ( ["boolean", "string"].indexOf(typeof _this.active[name])>=0) {
                    _this.filters[name] = _this.active[name];
                }
            }
            this.lastFiltersHash = this.hashString(JSON.stringify(this.filters));
            this.lastFilterTs = Date.now() / 1000;
        },

        updateList: function (afterSuccessCallback, forceRefresh) {
            var _this = this;
            var prev_hash = _this.lastFiltersHash;
            var prev_ts = _this.lastFilterTs;
            forceRefresh = typeof forceRefresh === "boolean" ? forceRefresh : true;
            this.$nextTick(() => {
                _this.refreshFilters();
                var newHash = _this.lastFiltersHash;
                var newTs = _this.lastFilterTs;
                if ((newTs - prev_ts) > 0.500) {
                    prev_hash = 0;
                }
                var doR = (!forceRefresh) || (forceRefresh && newHash != prev_hash);
                if (doR && !_this.ignoreReload) {
                    this.setCookie(this.cookieFilterName, JSON.stringify(_this.active), 7);
                    _this.loadData(true, afterSuccessCallback);
                }
            });
        },
        filter: function filter(column, value, afterSuccessCallback) {
            if (value == '') {
                delete this.filters[column];
            } else {
                this.filters[column] = value;
            }
            // when we change filter, we must reset pagination, because the total items count may has changed
            this.loadData(true, afterSuccessCallback);
        },
        loadData: function loadData(resetCurrentPage, afterSuccessCallback) {
            var _this6 = this;

            var options = {
                params: {
                    per_page: this.pagination.state.per_page,
                    page: this.pagination.state.current_page,
                    orderBy: this.orderBy.column,
                    orderDirection: this.orderBy.direction
                }
            };

            if (resetCurrentPage === true) {
                options.params.page = 1;
            }

            Object.assign(options.params, this.filters);

            axios.get(this.url, options).then(function (response) {
                return _this6.populateCurrentStateAndData(response.data.data, afterSuccessCallback, response);
            }, function (error) {
                _this6.loadDataErrorHandler(error);
            });
        },

        populateCurrentStateAndData: function populateCurrentStateAndData(object, afterSuccessCallback, response) {

            if (object.current_page > object.last_page && object.total > 0) {
                this.pagination.state.current_page = object.last_page;
                this.loadData(true, afterSuccessCallback);
                return;
            }

            this.collection = object.data;
            this.pagination.state.current_page = object.current_page;
            this.pagination.state.last_page = object.last_page;
            this.pagination.state.total = object.total;
            this.pagination.state.per_page = object.per_page;
            this.pagination.state.to = object.to;
            this.pagination.state.from = object.from;

            if (typeof afterSuccessCallback === "function") {
                afterSuccessCallback(response);
            }
        },

        showWarning: function (message) {
            var _this = this;
            this.$modal.show('dialog', {
                title: '<span class="text-warning d-block w-100 text-center"><i class="fa fa-exclamation-triangle"></i> Attenzione</span>',
                text: '<span class="w-100 d-block text-center">' + message + '</span>',
                buttons: [{title: '<span class="btn-dialog btn-warning">Chiudi<span>'}]
            });
        },
        showConfirm: function (message, callback, params) {
            var _this = this;
            this.$modal.show('dialog', {
                title: 'Attenzione',
                text: message,
                buttons: [{title: 'No, annulla'}, {
                    title: '<span class="btn-dialog btn-success">Si<span>',
                    handler: function handler() {
                        _this.$modal.hide('dialog');
                        callback(params);
                    }
                }]
            });
        },
        showDangerConfirm: function (message, callback, params) {
            var _this = this;
            this.$modal.show('dialog', {
                title: 'Attenzione',
                text: message,
                buttons: [{title: 'No, annulla'}, {
                    title: '<span class="btn-dialog btn-danger">Si<span>',
                    handler: function handler() {
                        _this.$modal.hide('dialog');
                        callback(params);
                    }
                }]
            });
        }
    }
};
