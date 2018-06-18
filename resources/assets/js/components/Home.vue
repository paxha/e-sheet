<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="list-group">
                    <div class="list-group-item list-group-item-action flex-column align-items-start active">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Projects</h5>
                        </div>
                    </div>
                    <div v-if="length > 0">
                        <a href="javascript:void(0)"
                           class="list-group-item list-group-item-action flex-column align-items-start"
                           v-for="(project, index) in projects.data" v-on:click="loadSheets(project.id)">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ project.name }}</h5>
                                <small class="text-muted">{{ project.created_at }}</small>
                            </div>
                            <!--<p class="mb-1"></p>-->
                            <small class="text-muted">{{ project.description }}</small>
                        </a>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#new-project"
                           class="list-group-item list-group-item-info list-group-item-action flex-column align-items-start text-center">
                            <p class="mb-1">New Project</p>
                        </a>
                        <div class="list-group-item list-group-item-action flex-column align-items-start text-center">
                            <project-pagination :data="projects" @pagination-change-page="getResults"
                                                class="mt-2"></project-pagination>
                        </div>
                    </div>
                    <div v-else>
                        <div href="javascript:void(0)" data-toggle="modal" data-target="#new-project"
                             class="list-group-item list-group-item-action flex-column align-items-start text-center">
                            <div class="w-100 justify-content-between">
                                <h3 class="mb-1">{{ 'No Project Found' }}</h3>
                            </div>
                            <p class="mb-1">Click To Create New Project</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">Sheets
                        <div class="float-right" v-if="project_id !== ''">
                            <button class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#new-sheet">
                                New Sheet
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="sheets_length > 0">
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
                                        <a href="javascript:void(0)" v-on:click="deleteSheet(sheet.id)"><i class="fa fa-trash text-danger"></i></a>
                                        <a href="javascript:void(0)"  data-toggle="modal" data-target="#edit-sheet" v-on:click="setSheetId(sheet.id, sheet.name)"><i class="fa fa-edit text-info"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <sheet-pagination :data="sheets" @pagination-change-page="getSheets"
                                              class="mt-2"></sheet-pagination>
                        </div>
                        <div v-else>
                            No Sheet Found
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <new-project @newProjectCreated="refresh"></new-project>
        <new-sheet @newSheetCreated="refreshSheets" v-bind:project_id="project_id"></new-sheet>
        <edit-sheet @sheetUpdated="refreshSheets" v-bind:project_id="project_id" v-bind:sheet_id="sheet_id" v-bind:sheet_name="sheet_name"></edit-sheet>
    </div>
</template>

<script type="text/javascript">
    import Vue from 'vue';

    window.Vue = Vue;
    Vue.component('project-pagination', require('laravel-vue-pagination'));
    Vue.component('sheet-pagination', require('laravel-vue-pagination'));
    Vue.component('newProject', require('./NewProject'));
    Vue.component('newSheet', require('./NewSheet'));
    Vue.component('editSheet', require('./EditSheet'));
    export default {
        name: "Home",
        data() {
            return {
                'projects': {},
                'sheets': [],
                'project_id': '',
                'length': '',
                'sheets_length': '',
                'sheet_id': '',
                'sheet_name': ''
            }
        },
        mounted() {
            axios.get('http://esheet.test/projects')
                .then((r) => {
                    this.projects = r.data;
                    this.length = this.projects.data.length;
                })
                .catch((e) => console.log(e));
        },
        methods: {
            loadSheets(id) {
                this.project_id = id;
                axios.get('http://esheet.test/project-sheets/' + id)
                    .then((r) => {
                        this.sheets = r.data;
                        this.sheets_length = this.sheets.data.length;
                    })
                    .catch((e) => console.log(e));
            },
            getResults(page = 1) {
                axios.get('http://esheet.test/projects?page=' + page)
                    .then(response => this.projects = response.data);
            },
            getSheets(page = 1) {
                axios.get('http://esheet.test/project-sheets/' + this.project_id + '/?page=' + page)
                    .then(response => this.sheets = response.data);
            },
            refresh(response) {
                axios.get('http://esheet.test/projects')
                    .then((r) => {
                        this.projects = r.data;
                        this.length = this.projects.data.length;
                    })
                    .catch((e) => console.log(e));
            },
            refreshSheets(response) {
                this.loadSheets(this.project_id);
            },
            setSheetId(id, sheet_name){
                this.sheet_id = id;
                this.sheet_name = sheet_name;
            },
            deleteSheet(id){
                if (!confirm('Are you sure you want to delete this sheet?')) {
                    return
                }
                axios.delete('http://esheet.test/sheets/'+ id)
                    .then((r) => this.loadSheets(this.project_id))
                    .catch((e) => console.log(e))
            }
        }
    }
</script>

<style scoped>

</style>