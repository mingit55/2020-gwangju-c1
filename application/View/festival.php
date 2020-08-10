<!-- 비주얼 영역 -->
<div class="visual--sub">
    <div class="visual__image">
        <img src="/resources/images/visual/1.jpg" alt="비주얼 이미지">
    </div>
    <div class="visual__text">
        <div class="text text-center mt-5">
            <span class="fx-n2">
                <a href="#">축제 정보</a>
            </span>
            <div class="fx-7 mb-3">FESTIVAL <strong>INFO</strong></div>
            <div class="text-white-muted">전북의 다양한 축제를 한 눈에 살펴보세요</div>
        </div>
    </div>
</div>
<!-- /비주얼 영역 -->

<!-- 축제 리스트 -->
<div class="container padding">
    <div class="title text-center">
        <h1>JEONBUK <strong>FESTIVAL</strong></h1>
        <p>전북 축제</p>
    </div>
    <?php if(isLogin()):?>
    <div class="text-right">
        <button class="btn--filled" data-toggle="modal" data-target="#add-modal">축제 등록</button>
    </div>
    <?php endif;?>
    <div class="table-head mt-5">
        <div class="cell-10">번호</div>
        <div class="cell-30">축제명(사진)</div>
        <div class="cell-25">사진 다운로드</div>
        <div class="cell-20">기간</div>
        <div class="cell-15">장소</div>
    </div>
    <div class="table-list">
        <?php foreach($festivals->data as $festival):?>
            <?php $festival->images = filter_realfile(json_decode($festival->images), FIMAGE.DS.$festival->dirname);?>
            <div class="table-row">
                <div class="cell-10" <?= isLogin() ? " data-toggle='modal' data-target='#update-modal' data-id='{$festival->sn}' " : "" ?>><?=$festival->sn?></div>
                <div class="cell-30" onclick="location.href='/festivals/details?id=<?=$festival->sn?>'">
                    <?=$festival->nm?>
                    <span class="badge text-white bg-red"><?=count($festival->images)?></span>
                </div>
                <div class="cell-25">
                    <button class="btn--bordered" onclick="location.href='/festivals/images-tar?id=<?=$festival->sn?>'">tar</button>
                    <button class="btn--bordered" onclick="location.href='/festivals/images-zip?id=<?=$festival->sn?>'">zip</button>
                </div>
                <div class="cell-20">
                    <?=$festival->dt?>
                </div>
                <div class="cell-15">
                    <?=$festival->area?>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <div class="pagination mt-5">
        <a href="/festivals?page=<?=$festivals->prevNo?>">
            <i class="fa fa-angle-left"></i>
        </a>
        <?php for($i = $festivals->start; $i <= $festivals->end; $i++):?>
            <a href="/festivals?page=<?=$i?>" class="<?=$festivals->page == $i ? "active" : ""?>"><?=$i?></a>
        <?php endfor;?>
        <a href="/festivals?page=<?=$festivals->nextNo?>">
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div>
<!-- /축제 리스트 -->


<!-- 축제 추가 -->
<form id="add-modal" class="modal fade" method="post" enctype="multipart/form-data">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body pt-4 px-3">
                <div class="title text-center">
                    <h1>ADD <strong>FESTIVAL</strong></h1>
                    <p>새로운 축제를 등록하세요</p>
                </div>
                <div class="form-group mt-4">
                    <input type="text" name="nm" placeholder="축제명을 입력하세요" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" name="dt" placeholder="축제 기간을 입력하세요 (ex 2020-01-01 ~ 2020-01-20)" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" name="location" placeholder="장소를 입력하세요" class="form-control">
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <label for="images" class="custom-file-label">파일을 업로드 하세요</label>
                        <input type="file" id="images" name="images[]" class="custom-file-input" accept="image/*" multiple>
                    </div>
                </div>
                <div class="form-group mt-3 text-right">
                    <button class="btn--filled">저장</button>
                    <button type="button" class="btn--bordered" data-dismiss="modal">닫기</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- /축제 추가 -->

<!-- 축제 수정 -->
<form id="update-modal" class="modal fade">
    <input type="hidden" id="fid" name="id">
    <input type="hidden" id="left_images" name="left_images">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body pt-4 px-3">
                <div class="title text-center">
                    <h1>UPDATE <strong>FESTIVAL</strong></h1>
                    <p>축제의 수정 및 삭제가 가능합니다</p>
                </div>
                <div class="form-group mt-5">
                    <input type="text" name="nm" placeholder="축제명을 입력하세요" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" name="dt" placeholder="축제 기간을 입력하세요 (ex 2020-01-01 ~ 2020-01-20)" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" name="location" placeholder="장소를 입력하세요" class="form-control">
                </div>
                <div class="form-group">
                    <small class="text-muted">※ 파일명을 클릭하면 파일을 삭제할 수 있습니다.</small>
                    <div class="py-2">
                        <label>기존 파일</label>
                        <div id="left_viewer" class="border rounded d-flex flex-wrap px-3 py-2"></div>
                    </div>
                    <div class="py-2">
                        <label>추가 파일</label>
                        <div id="add_viewer" class="border rounded d-flex flex-wrap px-3 py-2"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <label for="add_images" class="custom-file-label">파일을 업로드 하세요</label>
                        <input type="file" id="add_images" name="add_images[]" class="custom-file-input" accept="image/*" multiple>
                    </div>
                </div>
                <div class="form-group mt-3 text-right">
                    <button class="btn--filled">저장</button>
                    <button type="button" class="btn-remove btn--filled">삭제</button>
                    <button type="button" class="btn--bordered" data-dismiss="modal">닫기</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(function(){
        let $form = $("#update-modal");
        let $left_images = $("#left_images");
        let $add_images = $("#add_images");
        let $left_viewer = $("#left_viewer");
        let $add_viewer = $("#add_viewer");
        let add_image_files = [];

        function update(){
            $left_viewer.html("");
            $add_viewer.html("");

            let left_images = JSON.parse($left_images.val());

            left_images.forEach(item => {
                let $span = $(`<span class="fx-n2 badge bg-red text-white m-1" data-type="left">${item}<i class="fa fa-times"></i></span>`);
                $left_viewer.append($span);
            });
            add_image_files.forEach(item => {
                let $span = $(`<span class="fx-n2 badge bg-red text-white m-1" data-type="add">(추가)${item.name}<i class="fa fa-times"></i></span>`);
                $add_viewer.append($span);
            });
        }

        // 업로드
        $form.on("submit", async e => {
            e.preventDefault();

            let id = $form.find("[name='id']").val();
            let nm = $form.find("[name='nm']").val();
            let dt = $form.find("[name='dt']").val();
            let location = $form.find("[name='location']").val();
            let left_images = JSON.parse($left_images.val());

            let add_images = [];
            await Promise.all(add_image_files.map(file => new Promise(resolve => {
                let reader = new FileReader();
                reader.onload = () => {
                    add_images.push(reader.result);
                    resolve();
                }
                reader.readAsDataURL(file);
            })));
            
            $.ajax({
                url: "/festivals",
                method: "PUT",
                data: JSON.stringify({ id, nm, dt, location, left_images, add_images }),
                success: res => {
                    alert(res.message);
                    if(res.result){
                        window.location.reload();
                    }
                }
            })
        });

        // 축제 정보 삭제
        $form.find(".btn-remove").on("click", e => {
            $.ajax({
                url: "/festivals",
                method: "DELETE",
                data: $form.find("#fid").val(),
                success : res => {
                    alert(res.message);
                    if(res.result){
                        window.location.reload();
                    }
                }
            })
        });

        // 파일 삭제
        let remove_file = function(){
            let text = this.innerText;
            let type = this.dataset.type;
            if(type == "left") {
                let left_images = JSON.parse($left_images.val());
                let idx = left_images.findIndex(iname => iname == text);
                left_images.splice(idx, 1);
                $left_images.val(JSON.stringify(left_images));
            }
            else if(type == "add"){
                let idx = add_image_files.findIndex(iname => iname == text);
                add_image_files.splice(idx, 1);
            }
            update();
        }
        $add_viewer.on("click", "span", remove_file);
        $left_viewer.on("click", "span", remove_file);

        // 파일이 업로드 될 때마다 배열로 변경해서 저장
        $add_images.on("change", e => {
            add_image_files.push(...Array.from(e.target.files));
            update();
        });

        // 수정 모달이 보여질 때 AJAX로 알맞은 축제정보 불러오기
        $("[data-target='#update-modal']").on("click", function(){
            $("#fid").val(this.dataset.id);

            $.getJSON("/api/festival?id=" + this.dataset.id, function(res){
                let festival = res.festival;
                $form.find("[name='nm']").val(festival.nm);
                $form.find("[name='dt']").val(festival.dt);
                $form.find("[name='location']").val(festival.location);
                $form.find("[name='left_images']").val(festival.images);
                $form.find("[name='add_images']").val("");
                update();
            });
        });
    });
</script>
<!-- /축제 수정 -->