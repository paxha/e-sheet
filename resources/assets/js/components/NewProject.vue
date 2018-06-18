<template>
    <!-- Modal -->
    <div class="modal fade" id="new-project" tabindex="-1" role="dialog" aria-labelledby="new-project" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="project-name">Project Name:</label>
                        <input type="text" id="project-name" class="form-control" placeholder="abc..." v-model="project_name">
                    </div>
                    <div class="form-group">
                        <label for="project-description">Project Description</label>
                        <textarea id="project-description" cols="30" rows="10" class="form-control" placeholder="abc..." v-model="project_description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="save">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NewProject",
        data(){
            return {
                'project_name': '',
                'project_description': ''
            }
        },
        methods:{
            save(){
                if (this.project_name === '') {
                    return
                }
                if (this.project_description === '') {
                    return
                }
                axios.post('http://esheet.test/projects', {
                    name: this.project_name,
                    description: this.project_description
                })
                    .then((r) => {
                        this.$emit('newProjectCreated', r.data);
                        this.project_name = '';
                        this.project_description = '';
                        $('#new-project').modal('hide');
                    })
                    .then((e) => console.log(e))
            }
        }
    }
</script>

<style scoped>

</style>