<header class="app-header navbar navbar-expand-lg">
    @if(env("TEMPLATE_LAYOUT_MENU","sidebar")=="sidebar")
        <button class="navbar-toggler sidebar-toggler d-lg-none" type="button" data-toggle="sidebar-show">
            <span class="navbar-toggler-icon"></span>
        </button>
    @endif

    @if(env("TEMPLATE_LAYOUT_MENU","sidebar")=="headerbar")
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    @endif

    @if(View::exists('ui.partials.logo'))
        @include('ui.partials.logo')
    @endif


    @if(env("TEMPLATE_LAYOUT_MENU","sidebar")=="headerbar")
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">


                <li class="nav-item">
                    <a class="nav-link" href="{{ url('dashboard') }}">
                        <i class="nav-icon fa fa-home"></i> {{trans('admin.headermenu.dashboard')}}
                    </a>
                </li>


                @if(Auth::user()->hasPermissionTo('dati-contratto.create') || Auth::user()->hasPermissionTo('dati-contratto.index'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-envelope-o"></i> Contratti
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <div class="dropdown-header text-center">
                                <strong>{{ trans('admin.headermenu.contratti') }}</strong></div>

                            @if(Auth::user()->hasPermissionTo('dati-contratto.create'))
                                <a class="dropdown-item" href="{{ url('dati-contratto/create') }}">
                                    <i class="nav-icon cui-envelope-open"></i> {{trans('admin.dati-contratto.actions.create')}}
                                </a>
                            @endif

                            @if(Auth::user()->hasPermissionTo('dati-contratto.index'))
                                <a class="dropdown-item" href="{{ url('dati-contratto/') }}">
                                    <i class="nav-icon cui-layers"></i> {{trans('admin.dati-contratto.title')}}
                                </a>
                            @endif

                            @if(Auth::user()->hasPermissionTo('dati-contratto.personal-ko'))
                                <a class="dropdown-item" href="{{ url('dati-contratto/') }}">
                                    <i class="nav-icon cui-layers"></i> {{trans('admin.headermenu.personal_ko')}}
                                </a>
                            @endif

                             @if (Auth::user()->hasPermissionTo('admin.user-timelog.index'))
                                <a class="dropdown-item" href="{{ url('user-timelog') }}">
                                    <i class="nav-icon icon-clock font-weight-bold"></i> {{trans('admin.user-timelog.actions.manage')}}
                                </a>
                            @endif

                        </div>
                    </li>
                @endif

                @if(Auth::user()->hasPermissionTo('campagna.index') || Auth::user()->hasPermissionTo('partner.index'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="cui-tags"></i> Assegnazioni
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <div class="dropdown-header text-center">
                                <strong>{{ trans('admin.headermenu.assegnazioni') }}</strong></div>

                            @if(Auth::user()->hasPermissionTo('campagna.index'))
                                <a class="dropdown-item" href="{{ url('campagna/') }}">
                                    <i class="nav-icon cui-tags"></i> {{trans('admin.campagna.assigned')}}
                                </a>
                            @endif

                            @if(Auth::user()->hasPermissionTo('partner.index'))
                                <a class="dropdown-item" href="{{ url('partner/') }}">
                                    <i class="nav-icon fa fa-handshake-o"></i> {{trans('admin.partner.assigned')}}
                                </a>
                            @endif

                        </div>
                    </li>
                @endif






                @if (Auth::user()->hasPermissionTo('admin.vicidial-agent-log.index') || Auth::user()->hasPermissionTo('recording-log.index') )
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="nav-icon icon-earphones"></i> {{ trans('admin.headermenu.stats_rec_server') }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="dropdown-header text-center">
                            <strong>{{ trans('admin.headermenu.stats_rec_server') }}</strong></div>

                        @if(Auth::user()->hasPermissionTo('recording-log.index'))
                            <a class="dropdown-item" href="{{ url('recording-log') }}">
                                <i class="nav-icon fa fa-microphone"></i> {{trans('admin.recording-log.title')}}
                            </a>
                        @endif


                        @if (Auth::user()->hasPermissionTo('admin.vicidial-agent-log.index'))
                            <a class="dropdown-item" href="{{ url('agent-log') }}">
                                <i class="nav-icon icon-phone"></i> {{trans('admin.vicidial-agent-log.actions.index')}}
                            </a>
                        @endif

                        @if (Auth::user()->hasPermissionTo('admin.vicidial-agent-log.index'))
                            <a class="dropdown-item" href="{{ url('agent-stat-log') }}">
                                <i class="nav-icon icon-target"></i> {{trans('admin.vicidial-agent-log.actions.stat_log')}}
                            </a>
                        @endif

                    </div>
                </li>
                @endif

                @if ( Auth::user()->hasPermissionTo('admin.user-performance.index') || Auth::user()->hasPermissionTo('dati-contratto.statistiche-esiti.index') )
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="nav-icon icon-chart"></i> {{ trans('admin.headermenu.stats_crm') }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <div class="dropdown-header text-center">
                                <strong>{{ trans('admin.headermenu.stats_crm') }}</strong></div>

                            @if (Auth::user()->hasPermissionTo('admin.user-performance.index'))
                                <a class="dropdown-item" href="{{ url('user-performance') }}">
                                    <i class="nav-icon fa fa-user-circle"></i> {{trans('admin.user-performance.actions.index')}}
                                </a>
                            @endif

                            @if (Auth::user()->hasPermissionTo('dati-contratto.statistiche-esiti.index'))
                                <a class="dropdown-item" href="{{ url('dati-contratto/statistiche-esiti') }}">
                                    <i class="nav-icon fa fa-bar-chart"></i> {{trans('admin.statistiche-esiti.actions.index')}}
                                </a>
                            @endif
                        </div>
                    </li>
                @endif





                @if(Auth::user()->hasRole("Admin"))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cogs"></i> Amministrazione
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <div class="dropdown-header text-center">
                                <strong>{{ trans('admin.headermenu.admin') }}</strong></div>

                            @if (Auth::user()->hasPermissionTo('admin.esito.index'))
                                <a class="dropdown-item" href="{{ url('admin/esito') }}">
                                    <i class="nav-icon cui-people"></i> {{trans('admin.esito.actions.manage')}}
                                </a>
                            @endif

                            @if (Auth::user()->hasPermissionTo('admin.campaign.index'))
                                <a class="dropdown-item" href="{{ url('admin/campaign') }}">
                                    <i class="nav-icon cui-tags"></i> {{trans('admin.campagna.actions.manage')}}
                                </a>
                            @endif

                            @if (Auth::user()->hasPermissionTo('admin.partner.index'))
                                <a class="dropdown-item" href="{{ url('admin/partners') }}">
                                    <i class="nav-icon  fa fa-handshake-o"></i> {{trans('admin.partner.actions.manage')}}
                                </a>
                            @endif

                            @if (Auth::user()->hasPermissionTo('admin.rec-server.index'))
                                <a class="dropdown-item" href="{{ url('admin/rec-server') }}">
                                    <i class="nav-icon  icon-microphone"></i> {{trans('admin.rec-server.actions.manage')}}
                                </a>
                            @endif

                            @if (Auth::user()->hasPermissionTo('admin.admin-user.index'))
                                <a class="dropdown-item" href="{{ url('admin/users') }}">
                                    <i class="nav-icon icon-user"></i> {{trans('admin.admin-user.actions.manage')}}
                                </a>
                            @endif

                            @if (Auth::user()->hasPermissionTo('admin.translation.index') && false)
                                <a class="dropdown-item" href="{{ url('admin/translations') }}">
                                    <i class="nav-icon icon-location-pin"></i> {{trans('admin.translation.actions.manage')}}
                                </a>
                            @endif

                        </div>
                    </li>
                @endif
            </ul>
        </div>
    @endif


    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a role="button" class="dropdown-toggle nav-link">
                <span>
                    @if(Auth::check() && Auth::user()->avatar_thumb_url)
                        <img src="{{ Auth::user()->avatar_thumb_url }}" class="avatar-photo">
                    @elseif(Auth::check() && Auth::user()->first_name && Auth::user()->last_name)
                        <span
                            class="avatar-initials">{{ mb_substr(Auth::user()->first_name, 0, 1) }}{{ mb_substr(Auth::user()->last_name, 0, 1) }}</span>
                    @elseif(Auth::check() && Auth::user()->name)
                        <span class="avatar-initials">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                    @elseif(Auth::guard(config('admin-auth.defaults.guard'))->check() && Auth::guard(config('admin-auth.defaults.guard'))->user()->first_name && Auth::guard(config('admin-auth.defaults.guard'))->user()->last_name)
                        <span
                            class="avatar-initials">{{ mb_substr(Auth::guard(config('admin-auth.defaults.guard'))->user()->first_name, 0, 1) }}{{ mb_substr(Auth::guard(config('admin-auth.defaults.guard'))->user()->last_name, 0, 1) }}</span>
                    @else
                        <span class="avatar-initials"><i class="fa fa-user"></i></span>
                    @endif

                    @if(!is_null(config('admin-auth.defaults.guard')))
                        <span
                            class="hidden-md-down">{{ Auth::guard(config('admin-auth.defaults.guard'))->check() ? Auth::guard(config('admin-auth.defaults.guard'))->user()->full_name : 'Anonymous' }}</span>
                    @else
                        <span class="hidden-md-down">{{ Auth::check() ? Auth::user()->full_name : 'Anonymous' }}</span>
                    @endif

                </span>
                <span class="caret"></span>
            </a>
            @if(View::exists('ui.partials.profile-dropdown'))
                @include('ui.partials.profile-dropdown')
            @endif
        </li>
    </ul>
</header>
