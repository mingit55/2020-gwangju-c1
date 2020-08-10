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
    <!-- 로그인 폼 -->
    <form id="sign-in" class="modal fade" action="/sign-in" method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body py-4 px-3">
                    <div class="title text-center">
                        <h1>SIGN <strong>IN</strong></h1>
                        <p>전북 축제 On! 다양한 서비스를 이용해 보세요!</p>
                    </div>
                    <div class="form-group mt-4">
                        <input type="text" class="form-control" name="user_id" placeholder="아이디를 입력하세요">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="비밀번호를 입력하세요">
                    </div>
                    <div class="form-group d-between fx-n2 text-muted px-1">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" id="remember_id" name="remember_id">
                            <label for="remember_id" class="ml-2 mb-1">아이디 저장 </label>
                        </div>
                        <a href="#">비밀번호 찾기</a>
                    </div>
                    <div class="form-group mt-3 d-flex">
                        <div class="w-50 pr-1">
                            <button class="btn--filled w-100 py-2">로그인</button>
                        </div>
                        <div class="w-50 pl-1">
                            <button class="btn--bordered w-100 py-2">회원가입</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- /로그인 폼 -->
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
                        <?php if(isLogin()): ?>
                            <a href="/logout">로그아웃</a>
                        <?php else:?>
                            <a href="#" data-toggle="modal" data-target="#sign-in">로그인</a>
                        <?php endif;?>
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
                    <div class="menu__item"><a href="/festivals">축제 정보</a></div>
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
            <?php if(isLogin()):?>
                <a href="/logout" class="btn--filled mr-1">로그아웃</a>
            <?php else:?>
                <a href="#" class="btn--filled mr-1" data-toggle="modal" data-target="#sign-in">로그인</a>
            <?php endif;?>
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
            <a href="/festivals">축제 정보</a>
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
