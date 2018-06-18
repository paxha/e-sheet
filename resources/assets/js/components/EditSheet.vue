<template>
    <!-- Modal -->
    <div class="modal fade" id="edit-sheet" tabindex="-1" role="dialog" aria-labelledby="edit-sheet" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Sheet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sheet-name">Sheet Name:</label>
                        <input type="text" id="sheet-name" class="form-control" placeholder="abc..."
                               v-model="sheet_name">
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
        name: "EditSheet",
        props: ['project_id', 'sheet_id', 'sheet_name'],
        data() {
            return {
            }
        },
        methods: {
            save() {
                if (this.sheet_name === '') {
                    return
                }
                axios.put('http://esheet.test/sheets/' + this.sheet_id, {
                    project_id: this.project_id,
                    name: this.sheet_name
                })
                    .then((r) => {
                        this.$emit('sheetUpdated', r.data);
                        $('#edit-sheet').modal('hide');
                    })
                    .catch((e) => console.log(e))
            }
        }
    }
</script>

<style scoped>

</style>