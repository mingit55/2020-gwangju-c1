<!-- 비주얼 영역 -->
<div class="visual--sub">
    <div class="visual__image">
        <img src="/resources/images/visual/1.jpg" alt="비주얼 이미지">
    </div>
    <div class="visual__text">
        <div class="text text-center mt-5">
            <span class="fx-n2">
                <a href="#">축제 일정</a>
            </span>
            <div class="fx-7 mb-3">FESTIVAL <strong>SCHEDULE</strong></div>
            <div class="text-white-muted">한 눈에 전북 축제 일정을 확인하세요</div>
        </div>
    </div>
</div>
<!-- /비주얼 영역 -->
<div class="container padding">
    <div id="schedule">
        <div class="schedule-header">
            <button class="btn--bordered" onclick="location.href='/schedules?year=<?=date('Y')?>&month=<?=date('m')?>'">이번 달</button>
            <div class="schedule-center">
                <a class="schedule-header__a" href="/schedules?year=<?=date("Y", $prev_month)?>&month=<?=date("m", $prev_month)?>">
                    이전달
                </a>
                <strong class="schedule-title"><?=$year?>년 <?=$month?>월</strong>
                <a class="schedule-header__a" href="/schedules?year=<?=date("Y", $next_month)?>&month=<?=date("m", $next_month)?>">
                    다음달
                </a>
            </div>
            <button class="btn--filled" onclick="location.href='/festivals'">축제관리</button>
        </div>  
        <div class="schedule-body"></div>
    </div>
</div>

<script src="/resources/js/schedules.js"></script>