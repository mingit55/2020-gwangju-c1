const $locationModal = $(`<div id="locaiton-modal" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body px-3 py-4">
                                        
                                    </div>
                                </div>
                            </div>
                            </div>`);
$locationModal.body = $locationModal.find(".modal-content");

window.addEventListener("load", () => {
    $(document.body).append($locationModal);

    $(".open-location").on("click", e => {
        e.preventDefault();
        let visible = true;
        let timeout = setTimeout(() => {
            $locationModal.body.html(`<p class="py-5 text-danger text-center">찾아오는 길을 표시할 수 없습니다.</p>`);
            $locationModal.modal("show");
            visible = false;
        }, 1000);

        fetch("/location")     
        .then(res => res.text())
        .then(text => {
            if(visible){
                $locationModal.body.html(text);
                $locationModal.modal("show");
                clearTimeout(timeout);
            }
        });
    });

    $(".custom-file-input").on("change", e => {
        let files = e.target.files;
        if(files.length > 0) {
            let text = files[0].name;
            if(files.length > 1) text += " 외 " + (files.length - 1) + "개";
            $(e.target).siblings(".custom-file-label").text(text);
        } else {
            $(e.target).siblings(".custom-file-label").text("파일을 업로드 하세요");
        }
    });
});