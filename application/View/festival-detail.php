<?php
$dirname = "/festivalImages/".$festival->dirname;
$images = $festival->images == "[]" ? [] :  json_decode($festival->images);
$visual = count($images) == 0 ? "/resources/images/visual/1.jpg" : $dirname."/".json_decode($festival->images)[0];
?>
<!-- 비주얼 영역 -->
<div class="visual--sub">
    <div class="visual__image">
        <img src="<?=$visual?>" alt="비주얼 이미지">
    </div>
    <div class="visual__text">
        <div class="text text-center mt-5">
            <span class="fx-n2">
                <a href="#">축제 정보 > 상세 정보</a>
            </span>
            <div class="fx-7 mb-3">FESTIVAL <strong>DETAIL</strong></div>
            <div class="text-white-muted"><?=$festival->nm?></div>
        </div>
    </div>
</div>
<!-- /비주얼 영역 -->

<div class="container padding">
    <!-- 상세 정보 영역 -->
    <div class="mb-5">
        <div class="row">
            <div class="col-lg-5">
                <?php if(count($images) == 0):?>
                    <img class="fit-cover" src="/resources/images/no-image.png" alt="이미지가 없습니다.">
                <?php else:?>
                    <img class="fit-cover" src="<?=$dirname."/".$images[0]?>" alt="$">
                <?php endif;?>
            </div>
            <div class="col-lg-7">
                <div class="fx-5"><?=$festival->nm?></div>
                <p class="fx-n1 text-muted mt-2"><?=$festival->cn ? $festival->cn : "축제 정보가 없습니다."?></p>
                <div class="mt-4">
                    <span class="fx-n2 mr-3 text-muted">지역</span>
                    <span><?=$festival->area?></span>
                </div>
                <div class="mt-1">
                    <span class="fx-n2 mr-3 text-muted">장소</span>
                    <span><?=$festival->location?></span>
                </div>
                <div class="mt-1">
                    <span class="fx-n2 mr-3 text-muted">기간</span>
                    <span><?=$festival->dt?></span>
                </div>
            </div>
        </div>
    </div>
    <!-- /상세 정보 영역 -->
    <div class="row">
        <!-- 축제 사진 영역 -->
        <div class="col-lg-5">
            <hr class="my-3 ml-0">
            <div>
                <div class="fx-3 font-weight-bold text-red">축제 사진</div>
                <div class="row mt-4">
                    <?php foreach($images as $image):?>
                    <div class="col-lg-4 my-2">
                        <img class="fit-cover" src="<?=$dirname."/".$image?>" alt="축제 이미지">
                    </div>
                    <?php endforeach;?>
                    <?php if(count($images) === 0):?>
                    <div class="col-lg-4 my-2">
                        <img class="fit-cover" src="/resources/images/no-image.png" alt="축제 이미지">
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <!-- 축제 사진 영역 -->
        <!-- 축제 후기 영역 -->
        <div class="col-lg-6 offset-lg-1">
            <div class="d-between align-items-end">
                <div>
                    <hr class="my-3 ml-0">
                    <div class="fx-3 font-weight-bold text-red">축제 후기</div>
                </div>
                <button class="btn--bordered" data-target="#review-modal" data-toggle="modal">작성하기</button>
            </div>
            <div id="reviews" class="mt-4">
                <?php foreach($reviews as $review):?>
                <div class="border-bottom py-3">
                    <div class="d-between">
                        <div class="d-flex">
                            <b class="fx-2"><?=$review->name?></b>
                            <div class="ml-3 text-red"><i class="fa fa-star"></i> <?=$review->score?></div>
                        </div>
                        <?php if(isLogin()):?>
                            <button class="btn--filled btn-remove" data-id="<?=$review->id?>">삭제</button>
                        <?php endif;?>
                    </div>
                    <p class="fx-n2 text-muted">
                        <?=$review->comment?>
                    </p>
                </div>
                <?php endforeach;?>
            </div>
        </div>
        <!-- /축제 후기 영역 -->
    </div>
</div>
<script>
    $(function(){
        $("#reviews").on("click", ".btn-remove", function(){
            $.ajax({
                url: "/festivals/reviews",
                method: "delete",
                data: this.dataset.id,
                success: res => {
                    alert(res.message);
                    if(res.result) location.reload();
                }
            })
        });
    });
</script>

<!-- 후기 작성 모달 -->
<form id="review-modal" class="modal fade" method="post" action="/festivals/reviews">
    <input type="hidden" name="fid" value="<?=$festival->sn?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body px-3 pt-4 pb-2">
                <div class="text-center title">
                    <h1>FESTIVAL <strong>REVIEW</strong></h1>
                    <p>축제에 대한 당신의 평가를 남겨주세요</p>
                </div>
                <div class="form-group mt-4">
                    <input type="text" name="name" placeholder="이름을 입력해 주세요" class="form-control">
                </div>
                <div class="form-group">
                    <select name="score" class="form-control">
                        <option value="">별점을 선택해 주세요</option>
                        <option value="1">1점</option>
                        <option value="2">2점</option>
                        <option value="3">3점</option>
                        <option value="4">4점</option>
                        <option value="5">5점</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="comment" placeholder="후기를 입력해 주세요" class="form-control">
                </div>
                <div class="form-group text-right">
                    <button class="btn--filled">저장</button>
                    <button class="btn--bordered" type="button" data-dismiss="modal">닫기</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- /후기 작성 모달 -->