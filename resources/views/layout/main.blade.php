<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="/favicon/favicon.ico" type="image/x-icon">
    <style>
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        a {
            background-color: transparent
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }

        *,
        :after,
        :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        svg,
        video {
            display: block;
            vertical-align: middle
        }

        video {
            max-width: 100%;
            height: auto
        }

        .bg-white {
            --bg-opacity: 1;
            background-color: #fff;
            background-color: rgba(255, 255, 255, var(--bg-opacity))
        }

        .bg-gray-100 {
            --bg-opacity: 1;
            background-color: #f7fafc;
            background-color: rgba(247, 250, 252, var(--bg-opacity))
        }

        .border-gray-200 {
            --border-opacity: 1;
            border-color: #edf2f7;
            border-color: rgba(237, 242, 247, var(--border-opacity))
        }

        .border-t {
            border-top-width: 1px
        }

        .flex {
            display: flex
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .font-semibold {
            font-weight: 600
        }

        .h-5 {
            height: 1.25rem
        }

        .h-8 {
            height: 2rem
        }

        .h-16 {
            height: 4rem
        }

        .text-sm {
            font-size: .875rem
        }

        .text-lg {
            font-size: 1.125rem
        }

        .leading-7 {
            line-height: 1.75rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .ml-1 {
            margin-left: .25rem
        }

        .mt-2 {
            margin-top: .5rem
        }

        .mr-2 {
            margin-right: .5rem
        }

        .ml-2 {
            margin-left: .5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .mt-8 {
            margin-top: 2rem
        }

        .ml-12 {
            margin-left: 3cadcoorem
        }

        .-mt-px {
            margin-top: -1px
        }

        .max-w-6xl {
            max-width: 72rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .overflow-hidden {
            overflow: hidden
        }

        .p-6 {
            padding: 1.5rem
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .pt-8 {
            padding-top: 2rem
        }

        .fixed {
            position: fixed
        }

        .relative {
            position: relative
        }

        .top-0 {
            top: 0
        }

        .right-0 {
            right: 0
        }

        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06)
        }

        .text-center {
            text-align: center
        }

        .text-gray-200 {
            --text-opacity: 1;
            color: #edf2f7;
            color: rgba(237, 242, 247, var(--text-opacity))
        }

        .text-gray-300 {
            --text-opacity: 1;
            color: #e2e8f0;
            color: rgba(226, 232, 240, var(--text-opacity))
        }

        .text-gray-400 {
            --text-opacity: 1;
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--text-opacity))
        }

        .text-gray-500 {
            --text-opacity: 1;
            color: #a0aec0;
            color: rgba(160, 174, 192, var(--text-opacity))
        }

        .text-gray-600 {
            --text-opacity: 1;
            color: #718096;
            color: rgba(113, 128, 150, var(--text-opacity))
        }

        .text-gray-700 {
            --text-opacity: 1;
            color: #4a5568;
            color: rgba(74, 85, 104, var(--text-opacity))
        }

        .text-gray-900 {
            --text-opacity: 1;
            color: #1a202c;
            color: rgba(26, 32, 44, var(--text-opacity))
        }

        .underline {
            text-decoration: underline
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .w-5 {
            width: 1.25rem
        }

        .w-8 {
            width: 2rem
        }

        .w-auto {
            width: auto
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        @media (min-width:640px) {
            .sm\:rounded-lg {
                border-radius: .5rem
            }

            .sm\:block {
                display: block
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-start {
                justify-content: flex-start
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:h-20 {
                height: 5rem
            }

            .sm\:ml-0 {
                margin-left: 0
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:pt-0 {
                padding-top: 0
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width:768px) {
            .md\:border-t-0 {
                border-top-width: 0
            }

            .md\:border-l {
                border-left-width: 1px
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }
        }

        @media (min-width:1024px) {
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }

        @media (prefers-color-scheme:dark) {
            .dark\:bg-gray-800 {
                --bg-opacity: 1;
                background-color: #2d3748;
                background-color: rgba(45, 55, 72, var(--bg-opacity))
            }

            .dark\:bg-gray-900 {
                --bg-opacity: 1;
                background-color: #1a202c;
                background-color: rgba(26, 32, 44, var(--bg-opacity))
            }

            .dark\:border-gray-700 {
                --border-opacity: 1;
                border-color: #4a5568;
                border-color: rgba(74, 85, 104, var(--border-opacity))
            }

            .dark\:text-white {
                --text-opacity: 1;
                color: #fff;
                color: rgba(255, 255, 255, var(--text-opacity))
            }

            .dark\:text-gray-400 {
                --text-opacity: 1;
                color: #cbd5e0;
                color: rgba(203, 213, 224, var(--text-opacity))
            }

            .dark\:text-gray-500 {
                --tw-text-opacity: 1;
                color: #6b7280;
                color: rgba(107, 114, 128, var(--tw-text-opacity))
            }
        }
    </style>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/estilo-layout.css">
    <link rel="stylesheet" href="/css/mediaquery-layout.css">
    <link rel="stylesheet" href="/css/buttons.css">
    <link rel="stylesheet" href="/css/dashboard-professores.css">
    <link rel="stylesheet" href="/css/modal.css">
    <style>
        a {
            color: #fff;
            text-decoration: none;
            transition: 0.3s;
        }

        a:hover {
            opacity: 0.7;
        }

        a.logo img {
            width: 150px;
        }

        .logo {
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 4px;
        }

        nav {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background: #fff;
            height: 9vh;
            margin-bottom: 25px;
            /* padding-top: 25px; */
        }

        /* main {
            background: url("bg.jpg") no-repeat center center;
            background-size: cover;
            height: 100vh;
        } */

        .nav-list {
            list-style: none;
            display: flex;
        }

        .nav-list li {
            letter-spacing: 3px;
            margin-left: 32px;
        }

        .nav-list li button.sair {
            background-color: #006d77;
            color: #fff;
            width: 150px;
            height: 50px;
            animation: none;
            font-family: var(--poppins);
            transition-duration: .7s
        }

        .nav-list li button.sair:hover {
            background-color: #fff;
            color: #a55f46;
            border: 1px solid #a55f46;
        }

        .mobile-menu {
            display: none;
            cursor: pointer;
        }

        .mobile-menu div {
            width: 32px;
            height: 2px;
            background: #fff;
            margin: 8px;
            transition: 0.3s;
        }

        @media (max-width: 999px) {
            body {
                overflow-x: hidden;
            }

            .nav-list {
                position: absolute;
                top: 8vh;
                right: 0;
                width: 50vw;
                height: 100vh;
                background: #fff;
                flex-direction: column;
                align-items: center;
                justify-content: space-around;
                transform: translateX(200%);
                transition: transform 0.3s ease-in;
            }

            .nav-list li {
                margin-left: 0;
                opacity: 0;
            }

            .mobile-menu {
                display: block;
            }
        }

        .nav-list.active {
            transform: translateX(0);
        }

        @keyframes navLinkFade {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }


        .mobile-menu div {
            background-color: #006d77;
        }

        .mobile-menu.active .line1 {
            transform: rotate(-45deg) translate(-8px, 8px);
        }

        .mobile-menu.active .line2 {
            opacity: 0;
        }

        .mobile-menu.active .line3 {
            transform: rotate(45deg) translate(-5px, -7px);
        }
    </style>
    <style>
        .li-container:hover .dropdown-submenu {
            display: block;
            transition: all 0.2s ease;
            transition-delay: 0.5s;
        }

        .li-container {
            position: relative;
            /* padding: 10px; */
        }

        .li-container>ul {
            position: absolute;
            top: 100%;
            left: 0;
            padding: 10px;
            margin: 0;
        }



        .dropdown-menu {
            display: flex;
            gap: 2px;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            border: none;
        }

        .dropdown-menu li {
            width: 150px;
            height: 50px;
            list-style: none;
        }

        .dropdown-menu a {
            display: block;
            width: 100%;
            height: 100%;
            color: black;
            text-decoration: none;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1rem;
            transition: all .2s linear;
            font-family: var(--poppins);
        }

        .dropdown-menu li:hover>a {
            color: #006D77;
        }

        .dropdown-menu li:hover>.dropdown-submenu {
            display: block;
        }

        .dropdown-submenu {
            margin-top: -10px;
            display: none;
        }

        .dropdown-submenu a {
            background-color: #fff;
            width: 150%;
            display: flex;
            justify-content: flex-start;
            padding-left: 20px;
            font-size: .8rem;
            border-left: 8px solid transparent;
        }

        .dropdown-submenu li:hover>a {
            border-left: 8px solid #83C5BE;
        }

        @media screen and (min-width: 850px) and (max-width: 999px) {
            .nav-list.active {
                transform: translateX(85%);
            }
        }

        @media screen and (min-width: 720px) and (max-width: 849px) {
            .nav-list.active {
                transform: translateX(75%);
            }
        }

        @media screen and (min-width: 570px) and (max-width: 719px) {
            .nav-list.active {
                transform: translateX(55%);
            }
        }

        @media screen and (min-width: 470px) and (max-width: 569px) {
            .nav-list.active {
                transform: translateX(45%);
            }
        }

        @media screen and (min-width: 430px) and (max-width: 469px) {
            .nav-list.active {
                transform: translateX(35%);
            }
        }

        @media screen and (min-width: 395px) and (max-width: 429px) {
            .nav-list.active {
                transform: translateX(25%);
            }
        }

        @media screen and (max-width: 394px) {
            .nav-list.active {
                transform: translateX(15%);
            }
        }
    </style>

    <style>
        @media screen and (min-width: 1000px) and (max-width: 1520px) {
            a.logo {
                display: none;
            }

            .dropdown-menu a {
                font-size: .8rem;
            }

            .dropdown-menu li {
                width: 100px;
            }
        }
    </style>
</head>

<body onload="loading()">
    <div class="preload">
        <div class="loader"></div>
    </div>
    <div class="content">
        {{-- <nav>
            @if ($tipoUser == 'ADM' || $tipoUser == 'COORDENADOR' || $tipoUser == 'PROFESSOR')
                <a href="/principal" class="link-box" hreflang="pt-BR" target="_self">
                    <div class="box">
                        <div class="header-box">
                            <div class="icon-box">
                                <ion-icon name="home-outline"></ion-icon>
                            </div>
                            <h1>Tela de<br><span>Início</span></h1>
                        </div>
                        <hr>
                        <p>Retorne à página principal</p>
                    </div>
                </a>
            @endif
            <a href="/turmas" class="link-box" hreflang="pt-BR" target="_self">
                <div class="box">
                    <div class="header-box">
                        <div class="icon-box">
                            <ion-icon name="school-outline"></ion-icon>
                        </div>
                        <h1>Relatório<br><span>Turmas</span></h1>
                    </div>
                    <hr>
                    <p>Veja os relatórios das turmas</p>
                </div>
            </a>

            <a href="/professores" class="link-box" hreflang="pt-BR" target="_self">
                <div class="box">
                    <div class="header-box">
                        <div class="icon-box">
                            <ion-icon name="people-outline"></ion-icon>
                        </div>
                        <h1>Corpo<br><span>Docente</span></h1>
                    </div>
                    <hr>
                    <p>Visualize o corpo docente da instituição</p>
                </div>
            </a>
            @if ($tipoUser == 'ADM' || $tipoUser == 'COORDENADOR')
                <a href="/cadcoordenadores" class="link-box" hreflang="pt-BR" target="_self">
                    <div class="box">
                        <div class="header-box">
                            <div class="icon-box">
                                <ion-icon name="people-circle-outline"></ion-icon>
                            </div>
                            <h1>Cadastro de<br><span>Coordenadores</span></h1>
                        </div>
                        <hr>
                        <p>Edite e veja quem compoe a coordenação escolar</p>
                    </div>
                </a>
            @endif
            @if ($tipoUser == 'ADM' || $tipoUser == 'COORDENADOR')
                <a href="/escola" class="link-box" hreflang="pt-BR" target="_self">
                    <div class="box">
                        <div class="header-box">
                            <div class="icon-box">
                                <ion-icon name="extension-puzzle-outline"></ion-icon>
                            </div>
                            <h1>Dados da<br><span>Instituição</span></h1>
                        </div>
                        <hr>
                        <p>Edite informações sobre a escola</p>
                    </div>
                </a>
            @endif
            <a href="/manual" class="link-box" hreflang="pt-BR" target="_self">
                <div class="box">
                    <div class="header-box">
                        <div class="icon-box">
                            <ion-icon name="book-outline"></ion-icon>
                        </div>
                        <h1>Manual de <br><span>Uso</span></h1>
                    </div>
                    <hr>
                    <p>Acesse o PDF de uso</p>
                </div>
            </a>
            @if ($tipoUser == 'ADM' || $tipoUser == 'COORDENADOR')
                <a href="/cadTurmas" class="link-box" hreflang="pt-BR" target="_self">
                    <div class="box">
                        <div class="header-box">
                            <div class="icon-box">
                                <ion-icon name="person-add-outline"></ion-icon>
                            </div>
                            <h1>Cadastro de <br><span>Turmas</span></h1>
                        </div>
                        <hr>
                        <p>Cadatro de turmas novas</p>
                    </div>
                </a>
            @endif
            @if ($tipoUser == 'ADM' || $tipoUser == 'COORDENADOR')
                <a href="/cadAlunos" class="link-box" hreflang="pt-BR" target="_self">
                    <div class="box">
                        <div class="header-box">
                            <div class="icon-box">
                                <ion-icon name="person-add-outline"></ion-icon>
                            </div>
                            <h1>Cadastro de <br><span>Alunos</span></h1>
                        </div>
                        <hr>
                        <p>Cadatro de alunos novatos</p>
                    </div>
                </a>
            @endif






        </nav> --}}
        <nav>
            <ul class="dropdown-menu">
                <a class="logo" href="#"><img src="/img/siscologonova.png" alt=""></a>
                <div class="mobile-menu">
                    <div class="line1"></div>
                    <div class="line2"></div>
                    <div class="line3"></div>
                </div>
                <ul class="nav-list">
                    @if ($tipoUser == 'ADM' || $tipoUser == 'COORDENADOR' || $tipoUser == 'PROFESSOR')
                        <li><a href="/principal">Tela de Início</a></li>
                    @endif
                    <li><a href="/turmas">Relatório de turmas</a></li>
                    <li><a href="/professores">Corpo Docente</a></li>
                    @if ($tipoUser == 'ADM' || $tipoUser == 'COORDENADOR')
                        <li><a href="/escola">Dados Da Instituição</a></li>
                    @endif
                    <li><a href="/manual">Manual de Uso</a></li>
                    @if ($tipoUser == 'ADM' || $tipoUser == 'COORDENADOR')
                        <div class="li-container">
                            <li id="dropdown">
                                <a href="#">Cadastro &#9660;</a>
                                <ul class="dropdown-submenu">
                                    <li><a href="/cadcoordenadores">COORDENADORES</a></li>
                                    <li><a href="/cadAlunos">ALUNOS</a></li>
                                    <li><a href="/cadTurmas">TURMAS</a></li>
                                </ul>
                            </li>
                        </div>
                    @endif
                    <li id="sair">
                        <form action="/logOut/" method="POST">
                            @csrf
                            <button type="submit" class="sair">Logout</button>
                        </form>
                        {{-- <a href="#" class="sair">Sair</a> --}}
                    </li>
                </ul>
        </nav>
        <main>
            @yield('content')
        </main>
        <aside>
            @yield('alerts')
        </aside>
        <footer>
            <p>2023 &copy; - Todos os direitos reservados a SisCO</p>
        </footer>
    </div>
</body>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="/js/loader.js"></script>
<script src="/js/jQuery/jquery.min.js"></script>
<script src="/js/jQuery/dist/jquery.validate.min.js"></script>
<script src="/js/jQuery/dist/additional-methods.min.js"></script>
<script src="/js/jQuery/dist/localization/messages_pt_BR.min.js"></script>
<script src="/js/jQuery/dist/jquery.mask.min.js"></script>
<script src="/js/jQuery/jquery-script.js"></script>
<script src="/js/app.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/script.js"></script>
<script src="/js/jQuery/btn-script.js"></script>
<script src="/js/main-js/app-mobile.js"></script>
<script src="/js/main-js/mobile-navbar.js"></script>

</html>
