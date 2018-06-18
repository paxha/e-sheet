<template>
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="edit-calculation" tabindex="-1" role="dialog"
         aria-labelledby="edit-calculation" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Calculation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="description">Calculation Description:</label>
                        <input type="text" id="description" class="form-control" placeholder="abc..."
                               v-model="calculation.description">
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select id="type" class="form-control" v-model="calculation.type">
                            <option value="add">Add</option>
                            <option value="sub">Sub</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <p>Height</p>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="height-feet">Height Feet</label>
                                    <input type="number" id="height-feet" class="form-control"
                                           v-model="calculation.height_feet">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="height-inches">Height Inches</label>
                                    <input type="number" id="height-inches" class="form-control"
                                           v-model="calculation.height_inches">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <p>Width</p>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="width-feet">Width Feet</label>
                                    <input type="number" id="width-feet" class="form-control"
                                           v-model="calculation.width_feet">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="width-inches">Width Inches</label>
                                    <input type="number" id="width-inches" class="form-control"
                                           v-model="calculation.width_inches">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input type="number" id="qty" class="form-control" v-model="calculation.qty">
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
        name: "EditCalculation",
        props: ['calculation'],
        methods: {
            save() {
                axios.put('http://esheet.test/calculations/' + this.calculation.id, {
                    description: this.calculation.description,
                    height_feet: this.calculation.height_feet,
                    height_inches: this.calculation.height_inches,
                    width_feet: this.calculation.width_feet,
                    width_inches: this.calculation.width_inches,
                    qty: this.calculation.qty,
                    type: this.calculation.type,
                })
                    .then((r) => {
                        this.$emit('sheetUpdated', r.data);
                        $('#edit-calculation').modal('hide');
                    })
            }
        }
    }
</script>

<style scoped>

</style>