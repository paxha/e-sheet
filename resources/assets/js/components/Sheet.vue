<template>
    <div class="container">


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
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "Sheet",
        props: ['id'],
        data(){
            return {'calculations': []};
        },
        mounted(){
            axios.get('http://esheet.test/sheet-calculations/'+this.id)
                .then((r) => this.calculations = r.data)
                .catch((e) => console.log(e))
        }
    }
</script>

<style scoped>

</style>