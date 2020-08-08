const ALBUM = 1;
const LIST = 2;


class App {
    constructor(){ this.init(); }
    async init(){
        this.page = 1;
        this.renderType = ALBUM;
        this.viewer = document.querySelector("#viewer");
        this.pagination = document.querySelector(".pagination");
        this.viewModal = document.querySelector("#view-modal");
        this.viewModal.slideArea = this.viewModal.querySelector(".slide__area");
        this.viewModal.slideImage = this.viewModal.querySelector(".slide__image");
        this.viewModal.slideControl = this.viewModal.querySelector(".slide__control");
        
        this.getFestivals().then(() => {
            this.update();
            this.setEvents();
        });
    }

    // 이벤트 설정
    setEvents(){
        $(".render__icon").on("click", e => {
            let type = e.currentTarget.dataset.type;

            // 타입이 새롭게 변경되면 페이지네이션 초기화
            if(type !== this.renderType) this.page = 1;
            
            // 타입 변경
            if(type === "album") this.renderType = ALBUM;
            else this.renderType = LIST;
            this.update();
        });

        $(".pagination").on("click", "a", e => {
            this.page = e.currentTarget.dataset.no;
            this.update();
        });

        $(this.viewer).on("click", "[data-target='#view-modal']", e => {
            let id = e.currentTarget.dataset.id;
            let festival = this.festivals.find(fs => fs.sn == id);

            // 데이터 변경
            this.viewModal.querySelector(".image > img").src = festival.images.length > 0 ? `/festivalImages/${this.getFestivalId(festival)}/${festival.images[0]}` : `/images/no-image.png`;
            this.viewModal.querySelector(".nm").innerHTML = festival.nm;
            this.viewModal.querySelector(".cn").innerHTML = festival.cn;
            this.viewModal.querySelector(".area").innerHTML = festival.area;
            this.viewModal.querySelector(".location").innerHTML = festival.location;
            this.viewModal.querySelector(".dt").innerHTML = festival.dt;

            // 슬라이드 초기화
            this.viewModal.slideArea.dataset.cno = 0;
            this.viewModal.slideImage.innerHTML = "";
            this.viewModal.slideControl.innerHTML = `<button class="slide__arrow" data-no="-1"><i class="fa fa-angle-left"></i></button>`;
            if(festival.images.length > 0){
                festival.images.forEach((filename, i) => {
                    this.viewModal.slideControl.innerHTML += `<button class="slide__no" data-no="${i}"><i class="fa fa-circle"></i></button>`;
                    this.viewModal.slideImage.innerHTML += `<img src="/festivalImages/${this.getFestivalId(festival)}/${filename}" title="축제 정보 이미지" alt="축제 정보 이미지">`;
                });
            }
            else {
                this.viewModal.slideImage.innerHTML += `<img src="/images/no-image.png" title="축제 정보 이미지" alt="축제 정보 이미지">`;
                this.viewModal.slideControl.innerHTML += `<button class="slide__no" data-no="0"><i class="fa fa-circle"></i></button>`;
            }
            this.viewModal.slideControl.innerHTML += `<button class="slide__arrow" data-no="1"><i class="fa fa-angle-right"></i></button>`;

            // 이미지 설정
            $(".slide__image > img").eq(0).addClass("active");

            // 버튼 설정
            $(".slide__control > .slide__no").eq(0).addClass("active");
        });

        $(this.viewModal).on("click", ".slide__no", e => {
            let images = this.viewModal.querySelectorAll(".slide__image > img");
            let btns = this.viewModal.querySelectorAll(".slide__no");
            let no = e.currentTarget.dataset.no;

            $(images).removeClass("active");
            $(btns).removeClass("active");
            btns[no].classList.add("active");
            images[no].classList.add("active");
        });

        $(this.viewModal).on("click", ".slide__arrow", e => {
            let images = this.viewModal.querySelectorAll(".slide__image > img");
            let btns = this.viewModal.querySelectorAll(".slide__no");
            let dir = parseInt(e.currentTarget.dataset.no);
            let cno = parseInt(this.viewModal.slideArea.dataset.cno);
            let nno = cno + dir;
            if(nno >= images.length || nno < 0) nno = cno;

            this.viewModal.slideArea.dataset.cno = nno;
            $(images).removeClass("active");
            $(btns).removeClass("active");
            images[nno].classList.add("active");
            btns[nno].classList.add("active");
        });
    }

    // 화면 업데이트
    update(){
        this.viewer.innerHTML = "";

        const LEN = this.renderType === ALBUM ? 6 : 10;
        const BLOCK = 5;
        const PAGE_TOTAL = Math.ceil(this.festivals.length / LEN);

        let start = Math.ceil(this.page / BLOCK) * BLOCK - BLOCK + 1;
        start = start < 1 ? 1 : start;
        
        let end = start + BLOCK - 1;
        end = end > PAGE_TOTAL ? PAGE_TOTAL : end;


        let prev = start - 1 < 1 ? 1 : start - 1;
        let next = end + 1 > PAGE_TOTAL ? PAGE_TOTAL : end + 1;

        this.pagination.innerHTML = `<a data-no="${prev}"><i class="fa fa-angle-left"></i></a>`;
        for(let i = start; i <= end; i++){
            this.pagination.innerHTML += `<a class="${this.page == i ? 'active' : ''}" data-no="${i}">${i}</a>`;
        }
        this.pagination.innerHTML += `<a data-no="${next}"><i class="fa fa-angle-right"></i></a>`;

        let viewList = this.festivals.slice((this.page-1) * LEN, (this.page-1) * LEN + LEN);

        if(this.renderType === ALBUM) this.renderAlbum(viewList);
        else if(this.renderType === LIST) this.renderList(viewList);
    }

    // 생성하기 - 리스트 형식
    renderList(viewList){
        let wrap = $(`<div class="data__list"></div>`)[0];
        
        viewList.forEach(fs => {
            let elem = $(`<div class="list__row" data-toggle="modal" data-target="#view-modal" data-id="${fs.sn}">
                            <div class="list__no">${`${fs.sn}`.length < 2 ? '0' + fs.sn : fs.sn}</div>
                            <div class="list__content">
                                <h5 class="nm font-weight-bold">${fs.nm}</h5>
                                <div class="text-muted fx-n2">
                                    <span class="area mr-2">${fs.area}</span>
                                    <span class="dt">${fs.dt}</span>
                                </div>
                            </div>
                        </div>`)[0];
            wrap.append(elem);
        });

        this.viewer.innerHTML = wrap.outerHTML;
    }

    // 생성하기 - 앨범 형식
    renderAlbum(viewList){
        let last = this.festivals[this.festivals.length - 1];
        let wrap = $(`<div class="notice__album">
                        <div class="album__top">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="image">
                                        ${
                                            last.images.length > 0 ?
                                            `<img src="http://localhost/festivalImages/${this.getFestivalId(last)}/${last.images[0]}" title="축제 정보 이미지" alt="축제 정보 이미지">`
                                            : `<div class="no-image"></div>`
                                        }
                                    </div>
                                </div>
                                <div class="col-lg-7 p-3">
                                    <div class="fx-n2 text-red">대표 축제</div>
                                    <div class="fx-4 font-weight-bold">${last.nm}</div>
                                    <div class="text-muted fx-n1 mt-3">${last.dt}</div>
                                    <div class="fx-n2 keep-all mt-4">
                                        ${last.cn}
                                    </div>
                                    <button class="btn__dynamic--bordered mt-4" data-toggle="modal" data-target="#view-modal" data-id="${last.sn}">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        자세히 보기
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="album__row row mt-5"></div>
                    </div>`)[0];
        let row = wrap.querySelector(".album__row");

        viewList.forEach(fs => {
            let elem = $(`<div class="col-lg-4 mb-3">
                            <div class="album__item" data-target="#view-modal" data-toggle="modal" data-id="${fs.sn}">
                                <div class="image">${
                                        fs.images.length == 0 ? `<div class="no-image"></div>` :
                                        `<div class="no">${fs.images.length}</div>
                                        <img class="fit-cover" src="http://localhost/festivalImages/${this.getFestivalId(fs)}/${fs.images[0]}" title="축제 정보 이미지" alt="축제 정보 이미지">`
                                    }</div>
                                <div class="px-3 py-3">
                                    <div class="font-weight-bold fx-2 mb-1">${fs.nm}</div>
                                    <div class="fx-n1 text-muted">${fs.dt}</div>
                                </div>
                            </div>
                        </div>`)[0];
            row.append(elem);
        });
        this.viewer.innerHTML = wrap.outerHTML;
    }

    // 축제 고유 번호 가져오기
    getFestivalId(fs){
        if(fs){
            let id = new String(fs.sn);
            while(id.length < 3) id = "0" + id;
            return id + "_" + fs.no;
        }
    }


    // 축제 정보 가져오기
    getFestivals(){
        return new Promise(resolve => {
            let ls__festivals = localStorage.getItem("festivals");
            
            if(ls__festivals){
                this.festivals = JSON.parse(ls__festivals);
                resolve();
            } else {
                fetch("/api/festivals")
                .then(res => res.json())
                .then(async jsonData => {
                    let festivals = jsonData.festivals;
                    let items = [];
                    await Promise.all(festivals.map(async jsonItem => {
                        let item = jsonItem;
                        item.images = (await Promise.all(JSON.parse(item.images).map(filename => new Promise(res => {
                            let xhr = new XMLHttpRequest();
                            xhr.open("GET", `/festivalImages/${this.getFestivalId(item)}/${filename}`);
                            xhr.onload = () => {
                                if(xhr.status == 200 || xhr.status == 201) res(filename);
                                else res(null);
                            }
                            xhr.onerror = () => res(null)
                            xhr.send();
                        }))))
                        .filter(image => image !== null);
                        items[item.sn - 1] = item;
                    }));

                    this.festivals = items;
                    localStorage.setItem("festivals", JSON.stringify(items));
    
                    resolve();
                });
            }

        });
    }
}

window.addEventListener("load", () => {
    const app = new App();
});