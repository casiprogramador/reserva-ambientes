import Vue from 'vue'
import EventDialog from './EventDialog.vue';

function open(propsData) {
    const EventDialogComponent = Vue.extend(EventDialog);
    return new EventDialogComponent({
        el: document.createElement('div'),
        propsData
    });
}

export default {
    show(params, extraFields) {
        const defaultParam = {
            title: 'Reservar Ambiente',
            inputClass: null,
            overrideInputClass: false,
            createButtonLabel: 'Reservar',
            //  -------------------------
            date: null,
            startTime: null,
            endTime: null,
            enableTimeInputs: true,
        };

        const propsData = Object.assign(defaultParam, params);

        const defaultFields = [
            {
                name: 'date',   //  Required
                type: 'date',   //  def: 'text'
                label: 'Fecha',  //  def: this.name
                // showLabel: false,    //  def: true
                required: true, //  def: false,
                value: propsData.date,   //  def: null
            }
        ];

        if ( propsData.enableTimeInputs )
            defaultFields.splice(1, 0, {
                label: 'Hora (24 Hr)',
                fields: [
                    {
                        name: 'startTime',
                        type: 'time',
                        label: 'Hora Inicio',
                        required: true,
                        value: propsData.startTime
                    },
                    {
                        name: 'endTime',
                        type: 'time',
                        label: 'Hora Final',
                        required: true,
                        value: propsData.endTime
                    }
                ]
            });

        propsData.fields = extraFields ? defaultFields.concat(extraFields) : defaultFields;
        return open(propsData);
    }
}