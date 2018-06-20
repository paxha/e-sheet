<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Projects
                <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#new-project">New Project</button>
            </div>
            <div class="card-body">
                <div v-if="length > 0">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Start</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(project, index) in projects.data">
                            <th>{{ ++index }}</th>
                            <td>{{ project.name }}</td>
                            <td>{{ project.description }}</td>
                            <td>{{ project.created_at }}</td>
                            <td><router-link v-bind:to="'/sheets/'+project.id" class="btn btn-sm btn-outline-primary">Start Work</router-link></td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Trash</button>
                                <button class="btn btn-sm btn-outline-info"><i class="fa fa-edit"></i> Edit</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <project-pagination :data="projects" @pagination-change-page="getResults" class="mt-2"></project-pagination>
                </div>
                <div v-else>
                    <h4 class="text-muted">No Project Created!</h4>
                </div>
            </div>
        </div>
        <new-project @newProjectCreated="refresh"></new-project>
    </div>
</template>

<script type="text/javascript">
    import Vue from 'vue';

    window.Vue = Vue;
    Vue.component('project-pagination', require('laravel-vue-pagination'));
    Vue.component('newProject', require('./NewProject'));
    export default {
        name: "Home",
        data() {
            return {
                'projects': {},
                'length': ''
            }
        },
        mounted() {
            this.refresh();
        },
        methods: {
            getResults(page = 1) {
                axios.get('http://esheet.test/projects?page=' + page)
                    .then(response => this.projects = response.data);
            },
            refresh() {
                axios.get('http://esheet.test/projects')
                    .then((r) => {
                        this.projects = r.data;
                        this.length = this.projects.data.length;
                    })
                    .catch((e) => console.log(e));
            },
        }
    }
</script>

<style scoped>

</style>