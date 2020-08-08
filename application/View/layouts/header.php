<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>전북 축제 On!</title>
    <script src="/resources/js/jquery-3.5.0.min.js"></script>
    <link rel="stylesheet" href="/resources/bootstrap-4.4.1-dist/bootstrap-4.4.1-dist/css/bootstrap.min.css">
    <script src="/resources/bootstrap-4.4.1-dist/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/resources/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/resources/css/style.css">
    <script src="/resources/js/common.js"></script>
</head>
<body>
    <!-- 헤더 영역 -->
    <input type="checkbox" id="open__search" hidden>
    <input type="checkbox" id="open__nav" hidden>
    <header class="header__container">
        <div class="header__top d-lg-block d-none">
            <div class="container d-between h-100">
                <!-- 검색 -->
                <div class="search d-lg-flex d-none">
                    <label for="search__input" class="icon">
                        <i class="fa fa-search"></i>
                    </label>
                    <input type="text" id="search__input" placeholder="Search">
                </div>
                <div class="header__other d-lg-flex d-none">
                    <!-- 유틸리티 -->
                    <nav class="header__utility">
                        <a href="#">로그인</a>
                        <a href="#">회원가입</a>
                        <a href="#">전라북도청</a>
                    </nav>
                    <!-- 언어 설정 -->
                    <select class="lang__select ml-3">
                        <option value="ko">한국어</option>
                        <option value="en">English</option>
                        <option value="ch">中文(简体)</option>
                    </select>
                </div>
            </div>  
        </div>
        <div class="header__bottom">
            <div class="container d-between h-100">
                <!-- 모바일 검색 -->
                <label for="open__search" class="icon__search--mobile text-white pb-2">
                    <i class="fa fa-search"></i>
                </label>
                <!-- 로고 -->
                <a href="/">
                    <img src="/resources/images/logo.svg" title="전북 축제 On!" alt="전북 축제 On!" height="48">
                </a>   
                <!-- 메뉴 네비게이션 -->
                <nav class="nav__menu d-lg-flex d-none">
                    <div class="menu__item"><a href="/">HOME</a></div>
                    <div class="menu__item"><a href="/major-festival">전북 대표 축제</a></div>
                    <div class="menu__item"><a href="#">축제 정보</a></div>
                    <div class="menu__item"><a href="#">축제 일정</a></div>
                    <div class="menu__item"><a href="/exchange-guide">환율안내</a></div>
                    <div class="menu__item">
                        <a href="#">종합지원센터</a>
                        <div class="menu__list">
                            <a href="/notice">공지사항</a>
                            <a href="#">센터 소개</a>
                            <a href="#">관광정보 문의</a>
                            <a href="#">공공 데이터 개방</a>
                            <a href="#" class="open-location">찾아오시는 길</a>
                        </div>
                    </div>
                </nav>
                <!-- 모바일 메뉴 -->
                <label for="open__nav" class="icon__search--mobile text-white">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
            </div>
        </div>
        <div class="header__search d-lg-none">
            <div class="container d-flex h-100">
                <span class="icon__search">
                    <i class="fa fa-search"></i>
                </span>
                <input type="text" placeholder="Search">
                <label for="open__search">
                    <span></span>
                    <span></span>
                </label>
            </div>
        </div>
    </header>
    <aside class="aside--mobile">
        <div class="aside__other">
            <a href="#" class="btn--filled mr-1">로그인</a>
            <a href="#" class="btn--bordered mr-3">회원가입</a>
            <a href="#" class="mr-1">전라북도청</a>
            <select>
                <option value="ko">한국어</option>
                <option value="en">English</option>
                <option value="ch">中文(简体)</option>
            </select>
        </div>
        <nav class="aside__nav">
            <a href="/">HOME</a>
            <a href="/major-festival">전북 대표 축제</a>
            <a href="#">축제 정보</a>
            <a href="#">축제 일정</a>
            <a href="/exchange-guide">환율안내</a>
            <a href="#">종합지원센터</a>
            <div class="aside__subnav">
                <a href="/notice">공지사항</a>
                <a href="#">센터 소개</a>
                <a href="#">관광정보 문의</a>
                <a href="#">공공 데이터 개방</a>
                <a href="#" class="open-location">찾아오시는 길</a>
            </div>
        </nav>
    </aside>
    <!-- /헤더 영역 -->
