<template>
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="new-calculation" tabindex="-1" role="dialog" aria-labelledby="new-calculation" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Calculation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="description">Calculation Description:</label>
                        <input type="text" id="description" class="form-control" placeholder="abc..." v-model="description">
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select id="type" class="form-control" v-model="type">
                            <option value="add" selected>Add</option>
                            <option value="sub">Sub</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <p>Height</p>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="height-feet">Height Feet</label>
                                    <input type="number" id="height-feet" class="form-control" v-model="height_feet">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="height-inches">Height Inches</label>
                                    <input type="number" id="height-inches" class="form-control" v-model="height_inches">
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
                                    <input type="number" id="width-feet" class="form-control" v-model="width_feet">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="width-inches">Width Inches</label>
                                    <input type="number" id="width-inches" class="form-control" v-model="width_inches">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input type="number" id="qty" class="form-control" v-model="qty">
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
        name: "NewCalculation",
        props: ['sheet_id'],
        data(){
            return {
                'description': '',
                'type': '',
                'height_feet': '',
                'height_inches': '',
                'width_feet': '',
                'width_inches': '',
                'qty': ''
            }
        },
        methods: {
            save(){
                axios.post('http://esheet.test/calculations', {
                    sheet_id: this.sheet_id,
                    description: this.description,
                    type: this.type,
                    height_feet: this.height_feet,
                    height_inches: this.height_inches,
                    width_feet: this.width_feet,
                    width_inches: this.width_inches,
                    qty: this.qty
                })
                    .then((r) => {
                        this.$emit('newCalculationCreated', r.data);
                        this.description = '';
                        this.type = '';
                        this.height_feet = '';
                        this.height_inches = '';
                        this.width_feet = '';
                        this.width_inches = '';
                        this.qty = '';
                        $('#new-calculation').modal('hide');
                    })
                    .catch((e) => console.log(e))
            }
        }
    }
</script>

<style scoped>

</style>