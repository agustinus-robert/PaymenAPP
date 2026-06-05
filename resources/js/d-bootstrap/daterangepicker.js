// Daterangepicker.js
try {

    if(window.moment != undefined) {
        [].slice.call(document.querySelectorAll('[data-daterangepicker="true"]')).map(function (el) {
            el.setAttribute('data-coreui-toggle', 'dropdown');
            const start = el.parentNode.querySelector(el.dataset.daterangepickerStart);
            const end = el.parentNode.querySelector(el.dataset.daterangepickerEnd);
            const menu = document.createElement('div');
            menu.classList.add('dropdown-menu', 'border-0', 'shadow');

            let disabled = (el.dataset.daterangepickerDisabled || 'this_period,prev_period').split(',');

            let options = {
                today: {
                    label: 'Hari ini',
                    fn: [moment(), moment()]
                },
                yesterday: {
                    label: 'Kemarin',
                    fn: [moment().subtract(1, 'day'), moment().subtract(1, 'day')]
                },
                this_week: {
                    label: 'Minggu ini',
                    fn: [moment().startOf('week'), moment().endOf('week')]
                },
                last_week: {
                    label: '7 hari terakhir',
                    fn: [moment().subtract(6, 'day'), moment()]
                },
                this_period: {
                    label: 'Periode ini',
                    fn: [moment({day: '21'}).subtract((new Date()).getDate() >= 21 ? 0 : 1, 'month'), moment({day: '20'}).add((new Date()).getDate() >= 21 ? 1 : 0, 'month')]
                },
                prev_period: {
                    label: 'Periode kemarin',
                    fn: [moment({day: '21'}).subtract((new Date()).getDate() >= 21 ? 0 : 1, 'month').subtract(1, 'month'), moment({day: '20'}).add((new Date()).getDate() >= 21 ? 1 : 0, 'month').subtract(1, 'month')]
                },
                this_month: {
                    label: 'Bulan ini',
                    fn: [moment().startOf('month'), moment().endOf('month')]
                },
                prev_month: {
                    label: 'Bulan kemarin',
                    fn: [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                last_month: {
                    label: '30 hari terakhir',
                    fn: [moment().subtract(30, 'day'), moment()]
                },
                q1: {
                    label: 'Q1 tahun ini',
                    fn: [moment().startOf('year').quarters(1), moment().startOf('year').quarters(2).subtract(1, 'day')]
                },
                q2: {
                    label: 'Q2 tahun ini',
                    fn: [moment().startOf('year').quarters(2), moment().startOf('year').quarters(3).subtract(1, 'day')]
                },
                q3: {
                    label: 'Q3 tahun ini',
                    fn: [moment().startOf('year').quarters(3), moment().startOf('year').quarters(4).subtract(1, 'day')]
                },
                q4: {
                    label: 'Q4 tahun ini',
                    fn: [moment().startOf('year').quarters(4), moment().endOf('year')]
                },
                this_year: {
                    label: 'Tahun ini',
                    fn: [moment().startOf('year'), moment().endOf('year')]
                },
                past_year: {
                    label: 'Tahun kemarin',
                    fn: [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
                }
            }

            function setDates(e) {
                start.value = options[e.target.dataset.value].fn[0].format('YYYY-MM-DD')
                end.value = options[e.target.dataset.value].fn[1].format('YYYY-MM-DD')
                el.textContent = options[e.target.dataset.value].label
            }

            start.addEventListener('change', (e) => el.textContent = 'Rentang khusus');
            end.addEventListener('change', (e) => el.textContent = 'Rentang khusus');

            for(k in options) {
                if(!disabled.includes(k)) {
                    let li = document.createElement('li');
                    let item = document.createElement('a');
                    item.classList.add('dropdown-item', 'small', 'py-1')
                    item.dataset.value = k
                    item.setAttribute('href', 'javascript:;')
                    item.addEventListener('click', setDates)
                    item.innerHTML = options[k].label;
                    menu.appendChild(li).appendChild(item);
                }
            }

            el.parentNode.insertBefore(menu, el.nextSibling);
        });
        
    }
} catch (e) {}