<template>
    <div class="container">
        <h4 class="text-center">{{ project_name }}</h4>
        <p class="float-right text-muted">{{ created_at }}</p>
        <p>{{ sheet_name }}</p>
        <button class="float-right btn btn-sm btn-primary" data-toggle="modal" data-target="#new-calculation">New Calculation</button>
        <br>
        <br>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Description</th>
                <th>Height</th>
                <th>Width</th>
                <th>Quantity</th>
                <th>Add / Sub</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(calculation, index) in calculations">
                <th>{{ ++index }}</th>
                <td>{{ calculation.description }}</td>
                <td>{{ calculation.height }}</td>
                <td>{{ calculation.width }}</td>
                <td>{{ calculation.qty }}</td>
                <td>{{ calculation.type }}</td>
                <td>{{ calculation.total }}</td>
                <td>
                    <a href="javascript:void(0)"><i class="fa fa-trash text-danger btn btn-sm"></i></a>
                    <a href="javascript:void(0)"><i class="fa fa-edit text-info btn btn-sm"></i></a>
                </td>
            </tr>
            </tbody>
        </table>
        <new-calculation v-bind:sheet_id="sheet_id" @newCalculationCreated="refresh"></new-calculation>
    </div>
</template>

<script>

    Vue.component('newCalculation', require('./NewCalculation'));

    export default {
        name: "Sheet",
        props: ['sheet_id'],
        data() {
            return {
                'calculations': [],
                'project_id': '',
                'project_name': '',
                'sheet_name': '',
                'created_at': ''
            };
        },
        mounted() {
           this.refresh();
        },
        methods: {
            refresh(){
                axios.get('http://esheet.test/sheet-calculations/' + this.sheet_id)
                    .then((r) => {
                        this.calculations = r.data;
                        this.project_id = r.data[0].sheet.project_id;
                        this.sheet_name = r.data[0].sheet.name;
                        this.created_at = r.data[0].sheet.created_at;
                        this.project_name = r.data[0].sheet.project.name;
                    })
                    .catch((e) => console.log(e));
            }
        }
    }
</script>

<style scoped>

</style>