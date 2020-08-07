<!-- 비주얼 영역 -->
<div class="visual--sub">
    <div class="visual__image">
        <img src="/resources/images/visual/1.jpg" alt="비주얼 이미지">
    </div>
    <div class="visual__text">
        <div class="text text-center mt-5">
            <span class="fx-n2">
                <a href="#">전북 대표 축제</a></a>
            </span>
            <div class="fx-7 mb-3">MAJOR <strong>FESTIVAL</strong></div>
            <div class="text-white-muted">전북을 대표하는 각 지방의 축제들을 확인해 보세요</div>
        </div>
    </div>
</div>
<!-- /비주얼 영역 -->

<div class="container py-5">
    <!-- 형식 선택 영역 -->
    <div class="d-between mb-2">
        <div></div>
        <div class="d-flex text-muted">
            <a class="render__icon icon__album mr-1" data-type="album">
                <i class="fa fa-table"></i>
            </a>
            <a class="render__icon icon__list" data-type="list">
                <div class="fa fa-list"></div>
            </a>
        </div>
    </div>
    <!-- /형식 선택 영역 -->
    <!-- 공지사항 리스트 -->
    <div id="viewer"></div>
    <!-- /공지사항 리스트 -->
    <!-- 페이지네이션 -->
    <div class="pagination mt-5">
    </div>
    <!-- /페이지네이션 -->
</div>

<div id="view-modal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-between">
                <div>
                    <div class="fx-3 font-weight-bold">축제 상세 정보</div>
                </div>
                <div>
                    <a class="icon__close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="modal-body px-5 pb-4">
                <div class="album__top">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="image h-100">
                                <img src="/resources/xml/festivalImages/001_10001/10001_1.jpg" title="축제 이미지" alt="축제 이미지">
                            </div>
                        </div>
                        <div class="col-lg-7 p-3">
                            <div class="nm fx-2 font-weight-bold">남원지리산바래봉철축제</div>
                            <div class="cn fx-n2 text-muted mt-2 keep-all">남원시 운봉읍 가축유전자 시험장 뒷편 바래봉 자락에는 해마다 4월말에서 5월 중순경까지 철쭉이 장관을 이루는데 마치 진홍물감을 풀어 놓은 듯 착각에 빠질 정도로 환상적이다.</div>
                            <div class="mt-4">
                                <div class="mb-2">
                                    <span class="mr-2 fx-n2 text-muted">지역</span>
                                    <span class="area fx-n1">남원</span>
                                </div>
                                <div class="mb-2">
                                    <span class="mr-2 fx-n2 text-muted">장소</span>
                                    <span class="location fx-n1">전라북도 남원시 운봉읍 바래봉실214</span>
                                </div>
                                <div class="mb-2">
                                    <span class="mr-2 fx-n2 text-muted">기간</span>
                                    <span class="dt fx-n1">2020.04.30~05.05</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slide__area mt-4" data-cno="0">
                    <div class="slide__image"></div>
                    <div class="slide__control my-4"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/resources/js/major-festival.js"></script>