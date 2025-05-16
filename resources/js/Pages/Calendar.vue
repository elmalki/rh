<script setup>
import {ScheduleXCalendar} from '@schedule-x/vue'
import Mission from "@/Pages/Missions/Mission.vue";
import {createCalendar, createViewDay, createViewMonthGrid, createViewWeek, viewMonthGrid,} from '@schedule-x/calendar'
import '@schedule-x/theme-default/dist/index.css'
import {onMounted, ref,} from "vue";
import {createCalendarControlsPlugin} from "@schedule-x/calendar-controls";
import { createEventModalPlugin } from '@schedule-x/event-modal'
const visible = ref(false)
const item = ref(null)
onMounted(() => {
    fetchCommandes(calendarControls.getRange().start, calendarControls.getRange().end)
})
// Do not use a ref here, as the calendar instance is not reactive, and doing so might cause issues
// For updating events, use the events service plugin
const calendarControls = createCalendarControlsPlugin()
const calendarApp = createCalendar({
    calendars: {
        Moyenne: {
            colorName: 'Moyenne',
            lightColors: {
                main: '#f9d71c',
                container: '#fff5aa',
                onContainer: '#594800',
            },
            darkColors: {
                main: '#fff5c0',
                onContainer: '#fff5de',
                container: '#a29742',
            },
        },
        Maximale: {
            colorName: 'Maximale',
            lightColors: {
                main: '#f91c45',
                container: '#ffd2dc',
                onContainer: '#59000d',
            },
            darkColors: {
                main: '#ffc0cc',
                onContainer: '#ffdee6',
                container: '#a24258',
            },
        },
        Ordinaire: {
            colorName: 'Ordinaire',
            lightColors: {
                main: '#0B9488',
                container: '#dafff0',
                onContainer: '#004d3d',
            },
            darkColors: {
                main: '#c0fff5',
                onContainer: '#e6fff5',
                container: '#42a297',
            },
        },

    },
    defaultView: viewMonthGrid,
    locale: 'fr-FR',
    // selectedDate: '2023-12-19',
    views: [
        createViewMonthGrid(),
        createViewWeek(),
        createViewDay()
    ],
    plugins: [calendarControls,createEventModalPlugin()],
    events: [],
    callbacks: {
        onRangeUpdate(range) {
            fetchCommandes(range.start, range.end)
        },
        onClickAgendaDate(date) {
            alert('Date clicked:', date);
        },
        onSelectedDateUpdate(date) {
            //axios to get event alert(date)
        },
        onClickDate(date) {
            /*calendarApp.events.add({
                id: 3,
                title: 'Event '+date,
                start: date,
                end: date
            })*/
        },
        onEventClick(calendarEvent) {
            if(calendarEvent.type=='mission') {
                item.value = items.value[calendarEvent.id]
                visible.value = true
            }
        },
    }
})
let items = ref([])
const fetchCommandes = (start, end) => {
    axios.post('/missions-calendar', {start: start, end: end})
        .then(response => {
            response.data.forEach(item => {
                if (!items.value.hasOwnProperty(item.id))
                    items.value[item.id] = item
                if (!calendarApp.events.get(item.id)) {
                    calendarApp.events.add({
                        id: item.id,
                        calendarId: 'Ordinaire',
                        title: item.mission,
                        start: item.depart_date,
                        end: item.return_date,
                        people: item.equipes.flatMap(e => e.personnels).map(el => el.fullname),
                        description: 'TEST',
                        type:'mission'
                    })
                }
            })
        })
        /*
    axios.post('/leaves-calendar', {start: start, end: end})
        .then(response => {
            console.log(response.data)
            response.data.forEach(item => {
                if (!items.value.hasOwnProperty(item.id))
                    items.value[item.id] = item
                if (!calendarApp.events.get(item.id)) {
                    calendarApp.events.add({
                        id: item.id,
                        calendarId: 'Moyenne',
                        title: item.leave_type?.label + ' de ' + item.personnel.fullname,
                        start: item.start_date,
                        end: item.end_date,
                        people: [item.personnel.fullname],
                        description: item.personnel.grade + ' ' + item.personnel.department?.label,
                        type:'leave'
                    })
                }
            })
        })*/
}

</script>

<template>
    <div>
        <ScheduleXCalendar :calendar-app="calendarApp"/>
        <Mission :visible="visible" :item="item" @close="visible=false"></Mission>
    </div>
</template>
<style scoped>
.sx-vue-calendar-wrapper {
    width: 1200px;
    max-width: 100vw;
    height: 800px;
    max-height: 90vh;
}

</style>
