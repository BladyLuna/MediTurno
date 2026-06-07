import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import esLocale from '@fullcalendar/core/locales/es';
import { Modal } from 'bootstrap';

const calendarElement = document.getElementById('shift-calendar');

if (calendarElement) {
    const filterForm = document.querySelector('[data-calendar-filter-form]');
    const modalElement = document.getElementById('shiftCalendarEventModal');
    const modal = modalElement ? new Modal(modalElement) : null;

    const setModalField = (name, value) => {
        const field = modalElement?.querySelector(`[data-calendar-modal-field="${name}"]`);

        if (field) {
            field.textContent = value || 'Sin dato';
        }
    };

    const calendar = new Calendar(calendarElement, {
        plugins: [dayGridPlugin],
        locale: esLocale,
        initialView: 'dayGridMonth',
        initialDate: calendarElement.dataset.initialDate,
        height: 'auto',
        displayEventTime: true,
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false,
        },
        headerToolbar: {
            left: '',
            center: 'title',
            right: '',
        },
        events: (fetchInfo, successCallback, failureCallback) => {
            const params = new URLSearchParams(filterForm ? new FormData(filterForm) : undefined);
            params.set('start', fetchInfo.startStr);
            params.set('end', fetchInfo.endStr);

            fetch(`${calendarElement.dataset.eventsUrl}?${params.toString()}`, {
                headers: {
                    Accept: 'application/json',
                },
            })
                .then((response) => {
                    if (! response.ok) {
                        throw new Error('No se pudo cargar el calendario.');
                    }

                    return response.json();
                })
                .then(successCallback)
                .catch(failureCallback);
        },
        eventClick: (info) => {
            const props = info.event.extendedProps;

            setModalField('staff_name', props.staff_name);
            setModalField('hospital_service_name', props.hospital_service_name);
            setModalField('shift_name', props.shift_name);
            setModalField('shift_code', props.shift_code);
            setModalField('start_time', props.start_time);
            setModalField('end_time', props.end_time);
            setModalField('status', props.status);
            setModalField('notes', props.notes);

            modal?.show();
        },
    });

    calendar.render();
}
