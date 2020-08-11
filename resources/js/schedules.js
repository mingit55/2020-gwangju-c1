class CalendarDay {
    constructor(){
        this.init(...arguments);
    }

    init(date, prevDay){
        this.date = date;
        this.prevDay = prevDay;
        this.events = [];
        this.$elem = this.getElement();
        this.$list = this.$elem.find(".schedule-list");
    }

    addEvent(){
        Array.from(arguments).forEach(eventName => {
            let overlap = this.prevDay != null && this.prevDay.events.find(event => event.name == eventName);
            this.events.push({name: eventName, display: !overlap});
        });
        this.update();
    }

    getElement(){
        if(this.date === null) return $(`<div class="schedule-item--empty"></div>`);
        else return $(`<div class="schedule-item">
                            <span class="schedule-item__span">${this.date.getDate()}</span>
                            <ol class="schedule-list"></ol>
                        </div>`);
    }

    update(){
        this.$list.html("");
        this.events.forEach(event => {
            this.$list.append($(`<li class="schedule-list__li">${event.display ? event.name : ''}</li>`));
        });
    }
}

class Calendar {
    constructor(){
        this.init();
    }

    async init(){
        this.currentDate = this.getCurrentDate();
        this.schedules = await this.getSchedules();

        this.$body = $("#schedule .schedule-body");
        this.days = [];

        this.renderDays();
    }
    get currentYear(){
        return this.currentDate.getFullYear();
    }
    get currentMonth(){
        return this.currentDate.getMonth();
    }
    get lastDate(){
        return new Date(this.currentYear, this.currentMonth + 1, 0);
    }
    get firstDate(){
        return new Date(this.currentYear, this.currentMonth, 1);
    }
    

    renderDays(){
        for(let i = 0; i < this.firstDate.getDay(); i++){
            let day = new CalendarDay(null, null);
            this.$body.append(day.$elem);
        }
        for(let i = 1; i <= this.lastDate.getDate(); i++){
            let date = new Date(this.currentYear, this.currentMonth, i);
            let prev = this.days.length > 0 ? this.days[this.days.length - 1] : null;
            let day = new CalendarDay(date, prev);

            let events = this.schedules
                .filter(schedule => schedule.start_date <= i && i <= schedule.end_date)
                .map(schedule => schedule.nm);
            day.addEvent(...events);

            this.days.push(day);
            this.$body.append(day.$elem);
        }
        for(let i = 0; i < (6-this.lastDate.getDay()); i++){
            let day = new CalendarDay(null, null);
            this.$body.append(day.$elem);
        }
    }

    getSchedules(){
        return fetch(`/openAPI/festivalList.php?searchType=M&summary=true&year=${this.currentYear}&month=${(this.currentMonth + 1)}`)
            .then(res => res.json())
            .then(res => res.schedules);
    }

    getCurrentDate(){
        let queryStr = location.search.length <= 1 ? "" : location.search.substr(1);
        let query = queryStr.split("&").reduce((obj, q) => {
            let split = q.split("=");
            obj[split[0]] = split[1];
            return obj;
        }, {});
        
        let year = !query.year ? new Date().getFullYear() : query.year;
        let month = !query.month ? new Date().getMonth() : query.month;
        try {
            return new Date(year, month, 1);
        } catch {
            return new Date();
        }
    }
}

$(function(){
    let app = new Calendar();
});