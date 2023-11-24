<div class="sidebar" data-color="orange">
      <div class="logo">
        <a href="{{ url('dashboard') }}" class="simple-text logo-mini">
          CRM
        </a>
        <a href="javascript:void(0);" class="simple-text logo-normal">
        {{Auth::user()->roles()->first()->label}}
        </a>
        <div class="navbar-minimize">
          <button id="minimizeSidebar" class="btn btn-outline-white btn-icon btn-round">
            <i class="now-ui-icons text_align-center visible-on-sidebar-regular"></i>
            <i class="now-ui-icons design_bullet-list-67 visible-on-sidebar-mini"></i>
          </button>
        </div>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="../../assets/img/james.jpg" />
          </div>
          <div class="info">
            <a data-toggle="collapse" href="#collapseExample" class="collapsed">
              <span>
                {{ Auth::user()->first_name}}  {{ Auth::user()->last_name}}
                <b class="caret"></b>
              </span>
            </a>
            <div class="clearfix"></div>
            <div class="collapse" id="collapseExample">
              <ul class="nav">
                <li>
                  <a href="{{ url('profile/edit') }}">
                    <span class="sidebar-mini-icon"><i class="fa fa-user"></i></span>
                    <span class="sidebar-normal">{{ trans('admin.profile_dropdown.profile') }}</span>
                  </a>
                </li>
                <li>
                  <a href="{{ url('profile/password') }}">
                    <span class="sidebar-mini-icon"><i class="fa fa-key"></i></span>
                    <span class="sidebar-normal">{{ trans('admin.profile_dropdown.password') }}</span>
                  </a>
                </li>
                <li>
                  <a href="{{ url('admin/logout') }}">
                    <span class="sidebar-mini-icon"><i class="fa fa-lock"></i></span>
                    <span class="sidebar-normal">{{ trans('admin.profile_dropdown.logout') }}</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <ul class="nav">
          <li>
            <a href="{{ url('dashboard') }}">
              <i class="now-ui-icons design_app"></i>
              <p>{{trans('admin.headermenu.dashboard')}}</p>
            </a>
          </li>
          
          
          @if(Auth::user()->hasPermissionTo('dati-contratto.create') || Auth::user()->hasPermissionTo('dati-contratto.index') || Auth::user()->hasPermissionTo('dati-contratto.personal-ko') || Auth::user()->hasPermissionTo('admin.user-timelog.index'))
          <li>
          

            <a data-toggle="collapse" href="#componentsExamples">
              <i class="now-ui-icons ui-1_email-85"></i>
              <p>
              Contratti <b class="caret"></b>
              </p>
            </a>
            <div class="collapse " id="componentsExamples">
              <ul class="nav">
              @if(Auth::user()->hasPermissionTo('dati-contratto.create'))
                <li>
                  <a href="{{ url('dati-contratto/create') }}">
                    <span class="sidebar-mini-icon"> <i class="fa fa-envelope" aria-hidden="true"></i></span>
                    <span class="sidebar-normal"> {{trans('admin.dati-contratto.actions.create')}} </span>
                  </a>
                </li>
                @endif
                @if(Auth::user()->hasPermissionTo('dati-contratto.index'))
                <li>
                  <a href="{{ url('dati-contratto/') }}">
                    <span class="sidebar-mini-icon"><i class="fa-solid fa-layer-group"></i></span>
                    <span class="sidebar-normal">{{trans('admin.dati-contratto.title')}}</span>
                  </a>
                </li>
                @endif
                @if(Auth::user()->hasPermissionTo('dati-contratto.personal-ko'))
                <li>
                  <a href="{{ url('dati-contratto/') }}">
                    <span class="sidebar-mini-icon"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                    <span class="sidebar-normal"> {{trans('admin.headermenu.personal_ko')}} </span>
                  </a>
                </li>
                @endif
                @if (Auth::user()->hasPermissionTo('admin.user-timelog.index'))
                <li>
                  <a href="{{ url('user-timelog') }}">
                    <span class="sidebar-mini-icon"><i class="fa-regular fa-clock"></i></span>
                    <span class="sidebar-normal"> {{trans('admin.user-timelog.actions.manage')}} </span>
                  </a>
                </li>
                @endif
                
              </ul>
            </div>
          </li>
          @endif

          @if (Auth::user()->hasPermissionTo('admin.vicidial-agent-log.index') || Auth::user()->hasPermissionTo('recording-log.index'))<li>
            <a data-toggle="collapse" href="#assignement">
              <i class="now-ui-icons shopping_tag-content"></i>
              <p>
              {{ trans('admin.headermenu.assegnazioni') }} <b class="caret"></b>
              </p>
            </a>
            <div class="collapse " id="assignement">
              <ul class="nav">
              @if(Auth::user()->hasPermissionTo('recording-log.index'))
                <li>
                  <a href="{{ url('campagna/') }}">
                    <span class="sidebar-mini-icon"><i class="fa-solid fa-tag"></i></span>
                    <span class="sidebar-normal"> {{trans('admin.campagna.assigned')}} </span>
                  </a>
                </li>
                @endif
                @if(Auth::user()->hasPermissionTo('partner.index'))
                <li>
                  <a href="{{ url('partner/') }}">
                    <span class="sidebar-mini-icon"><i class="fa-regular fa-handshake""></i></span>
                    <span class="sidebar-normal">{{trans('admin.vicidial-agent-log.actions.index')}} </span>
                  </a>
                </li>
                @endif
              </ul>
            </div>
          </li>
          @endif





          @if (Auth::user()->hasPermissionTo('admin.vicidial-agent-log.index') || Auth::user()->hasPermissionTo('recording-log.index'))<li>
            <a data-toggle="collapse" href="#formsExamples">
              <i class="now-ui-icons tech_headphones"></i>
              <p>
              {{ trans('admin.headermenu.stats_rec_server') }} <b class="caret"></b>
              </p>
            </a>
            <div class="collapse " id="formsExamples">
              <ul class="nav">
              @if(Auth::user()->hasPermissionTo('recording-log.index'))
                <li>
                  <a href="{{ url('recording-log') }}">
                    <span class="sidebar-mini-icon"><i class="fa-solid fa-microphone"></i></span>
                    <span class="sidebar-normal"> {{trans('admin.recording-log.title')}} </span>
                  </a>
                </li>
                @endif
                @if(Auth::user()->hasPermissionTo('recording-log.index'))
                <li>
                  <a href="{{ url('agent-log') }}">
                    <span class="sidebar-mini-icon"><i class="fa-solid fa-phone"></i></span>
                    <span class="sidebar-normal">{{trans('admin.vicidial-agent-log.actions.index')}} </span>
                  </a>
                </li>
                @endif
                @if(Auth::user()->hasPermissionTo('recording-log.index'))
                <li>
                  <a href="{{ url('agent-stat-log') }}">
                    <span class="sidebar-mini-icon"><i class="fa-regular fa-circle-dot"></i></span>
                    <span class="sidebar-normal">{{trans('admin.vicidial-agent-log.actions.stat_log')}}</span>
                  </a>
                </li>
                @endif
              </ul>
            </div>
          </li>
          @endif





          @if (Auth::user()->hasPermissionTo('admin.user-performance.index') || Auth::user()->hasPermissionTo('dati-contratto.statistiche-esiti.index'))
          <li>
            <a data-toggle="collapse" href="#statics_crm">
              <i class="now-ui-icons business_chart-bar-32"></i>
              <p>
              {{ trans('admin.headermenu.stats_crm') }} <b class="caret"></b>
              </p>
            </a>
            <div class="collapse " id="statics_crm">
              <ul class="nav">
              @if(Auth::user()->hasPermissionTo('admin.user-performance.index'))
                <li>
                  <a href="{{ url('user-performance') }}">
                    <span class="sidebar-mini-icon"><i class="fa-solid fa-arrow-up-right-dots"></i></span>
                    <span class="sidebar-normal"> {{trans('admin.user-performance.actions.index')}} </span>
                  </a>
                </li>
                @endif
                @if(Auth::user()->hasPermissionTo('dati-contratto.statistiche-esiti.index'))
                <li>
                  <a href="{{ url('dati-contratto/statistiche-esiti') }}">
                    <span class="sidebar-mini-icon"><i class="fa-solid fa-chart-column"></i></span>
                    <span class="sidebar-normal"> {{trans('admin.statistiche-esiti.actions.index')}} </span>
                  </a>
                </li>
                @endif
              </ul>
            </div>
          </li>
          @endif

          @if(Auth::user()->hasRole("Admin"))
          <li>
            <a data-toggle="collapse" href="#mapsExamples">
              <i class="now-ui-icons loader_gear"></i>
              <p>
              Amministrazione <b class="caret"></b>
              </p>
            </a>
            
            <div class="collapse " id="mapsExamples">
              <ul class="nav">
              @if (Auth::user()->hasPermissionTo('admin.esito.index'))
                <li>
                  <a href="{{ url('admin/esito') }}">
                    <span class="sidebar-mini-icon"><i class="fa-solid fa-users"></i></span>
                    <span class="sidebar-normal"> {{trans('admin.esito.actions.manage')}} </span>
                  </a>
                </li>
                @endif
                @if (Auth::user()->hasPermissionTo('admin.campaign.index'))
                <li>
                  <a href="{{ url('admin/campaign') }}">
                    <span class="sidebar-mini-icon"><i class="fa-solid fa-tag"></i></span>
                    <span class="sidebar-normal">{{trans('admin.campagna.actions.manage')}}</span>
                  </a>
                </li>
                @endif
                @if (Auth::user()->hasPermissionTo('admin.partner.index'))
                <li>
                  <a href="{{ url('admin/partners') }}">
                    <span class="sidebar-mini-icon"><i class="fa-regular fa-handshake"></i></span>
                    <span class="sidebar-normal"> {{trans('admin.partner.actions.manage')}} </span>
                  </a>
                </li>
                @endif
                @if (Auth::user()->hasPermissionTo('admin.rec-server.index'))
                <li>
                  <a href="{{ url('admin/rec-server') }}">
                    <span class="sidebar-mini-icon"><i class="fa-solid fa-microphone"></i></span>
                    <span class="sidebar-normal"> {{trans('admin.rec-server.actions.manage')}} </span>
                  </a>
                </li>
                @endif


                @if (Auth::user()->hasPermissionTo('admin.admin-user.index'))
                <li>
                  <a href="{{ url('admin/users') }}">
                    <span class="sidebar-mini-icon"><i class="now-ui-icons users_single-02"></i></span>
                    <span class="sidebar-normal"> {{trans('admin.admin-user.actions.manage')}} </span>
                  </a>
                </li>
                @endif
                @if (Auth::user()->hasPermissionTo('admin.translation.index') && false)
                <li>
                  <a href="{{ url('admin/translations') }}">
                    <span class="sidebar-mini-icon"><i class="now-ui-icons users_single-02"></i></span>
                    <span class="sidebar-normal"> {{trans('admin.translation.actions.manage')}} </span>
                  </a>
                </li>
                @endif
              </ul>
            </div>
          </li>
          @endif
          <li>
            <a href="{{ url('admin/logout') }}">
              <i class="fa fa-lock"></i>
              <p>{{ trans('admin.profile_dropdown.logout') }}</p>
            </a>
          </li>
        </ul>
      </div>
    </div>