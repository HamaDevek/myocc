@php
$account = '';
if(session()->exists('user')){
$account = \App\AccountTable::where('a_ID',session()->get('user'))->where('a_state',1)->firstOrFail();
}
@endphp
<ul id="dropdown1" class="dropdown-content">
    <li><a href="{{route('about.index')}}" class="waves-effect"> <i
                class="material-icons pink-text text-lighten-4">info</i>دەربارەی ئێمە</a>
        <div class="divider"></div>
    </li>
    <li><a href="{{route('contact.index')}}" class="waves-effect"> <i
                class="material-icons pink-text text-lighten-4">call</i>پەیوەندیمان
            پێوەبکە</a>
        <div class="divider"></div>
    </li>
    <li><a href="{{route('qanda.index')}}" class="waves-effect"> <i class="material-icons pink-text text-lighten-4">question_answer</i>پرسیارە
            باوەکان </a>
        <div class="divider"></div>
    </li>
    <li><a href="{{route('term.index')}}" class="waves-effect"> <i
                class="material-icons pink-text text-lighten-4">import_contacts</i>مەرجەکانی بەکارهێنان</a>
        <div class="divider"></div>
    </li>
    @if (session()->exists('user'))
    <li><a href="{{route('login.logout')}}" class="waves-effect"> <i
                class="material-icons pink-text text-lighten-4">exit_to_app</i>دەرچوون</a></li>
    @endif
</ul>
<nav>
    <div class="nav-wrapper white ">
        <a href="{{route('index')}}" class="brand-logo">
            <img src="{{secure_asset('storage/image/logo.png')}}">

        </a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger black-text"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down black-text">

            <li><a href="{{route('index')}}" class="black-text"> <i
                        class="material-icons nav-icon pink-text text-lighten-4">home</i>سەرەتا </a></li>

            <li><a href="{{route('search.index')}}" class="black-text"> <i
                        class="material-icons nav-icon pink-text text-lighten-4">search</i>گەڕان </a></li>
            <li><a href="{{route('order.carts')}}" class="black-text"> <i
                        class="material-icons nav-icon pink-text text-lighten-4">shopping_basket </i>سەبەتە </a></li>
            <li><a href="{{route('profile.index')}}" class="black-text">
                    <i
                        class="material-icons nav-icon pink-text text-lighten-4">person</i>{{$account->a_name ?? 'هەژمار'}}</a>
            </li>
            <li><a class="dropdown-trigger" href="#!" data-target="dropdown1"><i
                        class="material-icons black-text text-lighten-4">more_vert</i></a></li>

        </ul>

    </div>

</nav>

<ul class="sidenav black-text" id="mobile-demo">
    @if (session()->exists('user'))

    <li>
        <div class="user-view">
            <div class="background"
                style="background-image: url({{secure_asset('storage/image/profile_banner.png')}});background-size: cover;">

            </div>
            <div class="row right-align">

                <div class="col s9"><span class="black-text name">{{$account->a_name}}</span>

                    <span class="black-text email">{{$account->a_phone}}</span>
                </div>
                <div class="col s3">
                    <a href="{{route('profile.index')}}">
                        <div class="circle profile-image"
                            style="background-image: url({{secure_asset('storage/'.$account->a_image)}});">
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </li>
    @endif

    <li><a href="{{route('index')}}" class="waves-effect right-align"> سەرەتا <i
                class="material-icons pink-text text-lighten-4">home</i></a></li>
    <li><a href="{{route('about.index')}}" class="waves-effect"> <i
                class="material-icons pink-text text-lighten-4">info</i>دەربارەی ئێمە</a>
    </li>
    <li><a href="{{route('contact.index')}}" class="waves-effect"> <i
                class="material-icons pink-text text-lighten-4">call</i>پەیوەندیمان پێوە
            بکە</a></li>
    <li><a href="{{route('qanda.index')}}" class="waves-effect"> <i class="material-icons pink-text text-lighten-4">question_answer
            </i>پرسیارە باوەکان </a></li>
    <li><a href="{{route('term.index')}}" class="waves-effect"> <i class="material-icons pink-text text-lighten-4">import_contacts
            </i>مەرجەکانی بەکارهێنان</a></li>

    <li><a href="{{route('order.carts')}} " class="waves-effect"> <i
                class="material-icons pink-text text-lighten-4">shopping_basket
            </i>داواکارییەکانم </a></li>
    @if (session()->exists('user'))
    <li><a href="{{route('login.logout')}}" class="waves-effect"> <i
                class="material-icons pink-text text-lighten-4">exit_to_app</i>دەرچوون</a></li>
    @else
    <li><a href="{{route('profile.index')}}" class="waves-effect"> <i
                class="material-icons pink-text text-lighten-4">person</i>چوونەژورەوە</a></li>
    @endif
</ul>