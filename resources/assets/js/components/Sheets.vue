<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Sheets
                <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#new-sheet">New Sheet</button>
            </div>
            <div class="card-body">
                <div v-if="length > 0">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Start Work</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(sheet, index) in sheets.data">
                            <th>{{ ++index }}</th>
                            <td>{{ sheet.name }}</td>
                            <td>{{ sheet.created_at }}</td>
                            <td>
                                <router-link v-bind:to="'/sheet/'+sheet.id"
                                             class="btn btn-sm btn-outline-primary">View Sheet
                                </router-link>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger" @click="deleteSheet(sheet.id)"><i class="fa fa-trash"></i> Trash</button>
                                <button class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#edit-sheet" @click="setSheet(sheet.id)"><i class="fa fa-edit"></i> Edit</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <sheet-pagination :data="sheets" @pagination-change-page="getSheets" class="mt-2"></sheet-pagination>
                </div>
                <div v-else>
                    <h4 class="text-muted">No Sheet Created!</h4>
                </div>
            </div>
        </div>
        <new-sheet @newSheetCreated="refresh" v-bind:project_id="project_id"></new-sheet>
        <edit-sheet @sheetUpdated="refresh" v-bind:project_id="project_id" :sheet="selectedSheet"></edit-sheet>
    </div>
</template>

<script>
    Vue.component('sheet-pagination', require('laravel-vue-pagination'));
    Vue.component('newSheet', require('./NewSheet'));
    Vue.component('editSheet', require('./EditSheet'));
    export default {
        name: "Sheets",
        props:['project_id'],
        data() {
            return {
                'length': '',
                'sheets': [],
                'selectedSheet': {},
                'project_name': ''
            }
        },
        mounted(){
            this.refresh();
        },
        methods: {
            refresh(){
                axios.get('http://esheet.test/project-sheets/' + this.project_id)
                    .then((r) => {
                        this.sheets = r.data;
                        this.length = this.sheets.data.length;
                    })
                    .catch((e) => console.log(e));
            },
            getSheets(page = 1) {
                axios.get('http://esheet.test/project-sheets/' + this.project_id + '/?page=' + page)
                    .then(response => this.sheets = response.data);
            },
            setSheet(id) {
                axios.get('http://esheet.test/sheets/' + id)
                    .then((r) => this.selectedSheet = r.data)
                    .catch((e) => console.log(e));
            },
            deleteSheet(id) {
                if (!confirm('Are you sure you want to delete this sheet?')) {
                    return
                }
                axios.delete('http://esheet.test/sheets/' + id)
                    .then(this.refresh())
                    .catch((e) => console.log(e))
            }
        }
    }
</script>

<style scoped>

</style>