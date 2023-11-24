<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('admin.sidebar.content') }}</li>
            {{-- Do not delete me :) I'm used for auto-generation menu items --}}


            @if(Auth::user()->hasPermissionTo('dati-contratto.create') || Auth::user()->hasPermissionTo('dati-contratto.index') || Auth::user()->hasPermissionTo('dati-contratto.personal-ko') || Auth::user()->hasPermissionTo('admin.user-timelog.index'))
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon fa fa-envelope-o"></i> Contratti
                    </a>
                    <ul class="nav-dropdown-items">

                        @if(Auth::user()->hasPermissionTo('dati-contratto.create'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('dati-contratto/create') }}"><i
                                        class="nav-icon cui-envelope-open"></i> {{trans('admin.dati-contratto.actions.create')}}</a>
                            </li>
                        @endif

                        @if(Auth::user()->hasPermissionTo('dati-contratto.index'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('dati-contratto/') }}"><i
                                        class="nav-icon cui-layers"></i> {{trans('admin.dati-contratto.title')}}</a>
                            </li>
                        @endif

                        @if(Auth::user()->hasPermissionTo('dati-contratto.personal-ko'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('dati-contratto/') }}"><i
                                        class="nav-icon cui-layers"></i> {{trans('admin.headermenu.personal_ko')}}</a>
                            </li>
                        @endif

                        @if (Auth::user()->hasPermissionTo('admin.user-timelog.index'))
                            <li class="nav-item"><a class="nav-link" href="{{ url('user-timelog') }}"><i
                                        class="nav-icon icon-clock"></i> {{trans('admin.user-timelog.actions.manage')}}</a></li>
                        @endif
                    </ul>
                </li>
            @endif


            @if(Auth::user()->hasPermissionTo('campagna.index') || Auth::user()->hasPermissionTo('partner.index'))
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon cui-tags"></i> Assegnazioni
                    </a>
                    <ul class="nav-dropdown-items">

                        @if(Auth::user()->hasPermissionTo('campagna.index'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('campagna/') }}"><i
                                    class="nav-icon cui-tags"></i> {{trans('admin.campagna.assigned')}}</a>
                        </li>
                        @endif

                        @if(Auth::user()->hasPermissionTo('partner.index'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('partner/') }}"><i
                                    class="nav-icon fa fa-handshake-o"></i> {{trans('admin.partner.assigned')}}</a>
                        </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (Auth::user()->hasPermissionTo('admin.vicidial-agent-log.index') || Auth::user()->hasPermissionTo('recording-log.index'))
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-earphones"></i> {{ trans('admin.headermenu.stats_rec_server') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        @if(Auth::user()->hasPermissionTo('recording-log.index'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('recording-log') }}"><i
                                        class="nav-icon fa fa-microphone"></i> {{trans('admin.recording-log.title')}}</a>
                            </li>
                        @endif

                        @if(Auth::user()->hasPermissionTo('recording-log.index'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('agent-log') }}"><i
                                    class="nav-icon icon-phone"></i> {{trans('admin.vicidial-agent-log.actions.index')}}</a>
                        </li>
                        @endif

                        @if(Auth::user()->hasPermissionTo('recording-log.index'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('agent-stat-log') }}"><i
                                    class="nav-icon fa icon-target"></i> {{trans('admin.vicidial-agent-log.actions.stat_log')}}</a>
                        </li>
                        @endif
                    </ul>
                </li>
            @endif


            @if (Auth::user()->hasPermissionTo('admin.user-performance.index') || Auth::user()->hasPermissionTo('dati-contratto.statistiche-esiti.index'))
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon icon-chart"></i> {{ trans('admin.headermenu.stats_crm') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        @if(Auth::user()->hasPermissionTo('admin.user-performance.index'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('user-performance') }}"><i
                                    class="nav-icon fa fa-user-circle"></i> {{trans('admin.user-performance.actions.index')}}</a>
                        </li>
                        @endif

                        @if(Auth::user()->hasPermissionTo('dati-contratto.statistiche-esiti.index'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('dati-contratto/statistiche-esiti') }}"><i
                                        class="nav-icon fa fa-bar-chart"></i> {{trans('admin.statistiche-esiti.actions.index')}}</a>
                            </li>
                        @endif

                    </ul>
                </li>
            @endif






            @if(Auth::user()->hasRole("Admin"))
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#">
                        <i class="nav-icon fa fa-cogs"></i> Amministrazione
                    </a>
                    <ul class="nav-dropdown-items">
                        @if (Auth::user()->hasPermissionTo('admin.esito.index'))
                            <li class="nav-item"><a class="nav-link" href="{{ url('admin/esito') }}"><i
                                        class="nav-icon cui-people"></i> {{trans('admin.esito.actions.manage')}}</a></li>
                        @endif

                            @if (Auth::user()->hasPermissionTo('admin.campaign.index'))
                                <li class="nav-item"><a class="nav-link" href="{{ url('admin/campaign') }}"><i
                                            class="nav-icon cui-tags"></i> {{trans('admin.campagna.actions.manage')}}</a></li>
                            @endif


                            @if (Auth::user()->hasPermissionTo('admin.partner.index'))
                                <li class="nav-item"><a class="nav-link" href="{{ url('admin/partners') }}"><i
                                            class="nav-icon  fa fa-handshake-o"></i> {{trans('admin.partner.actions.manage')}}</a></li>
                            @endif

                            @if (Auth::user()->hasPermissionTo('admin.rec-server.index'))
                                <li class="nav-item"><a class="nav-link" href="{{ url('admin/rec-server') }}"><i
                                            class="nav-icon  icon-microphone"></i> {{trans('admin.rec-server.actions.manage')}}</a></li>
                            @endif


                            @if (Auth::user()->hasPermissionTo('admin.admin-user.index'))
                                <li class="nav-item"><a class="nav-link" href="{{ url('admin/users') }}"><i
                                            class="nav-icon icon-user"></i> {{trans('admin.admin-user.actions.manage')}}</a></li>
                            @endif





                            @if (Auth::user()->hasPermissionTo('admin.translation.index') && false)
                                <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i
                                            class="nav-icon icon-location-pin"></i> {{trans('admin.translation.actions.manage')}}</a></li>
                            @endif
                    </ul>
                </li>
            @endif


            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
