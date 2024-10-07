<template>
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>


        <TotalAdmin></TotalAdmin>



    </section>
</template>

<script>
import TotalAdmin from "./TotalAdmin.vue"
export default {
    props: {
        data: {
            type: Array,
            default: 'None'
        }
    },

    components: {
        TotalAdmin,
    },

    mounted() {
    },
    data() {
        return {
            categories: [
                { name: 'Gents' },
                { name: 'Ladies' },
                { name: 'Kids' },
            ]
        };
    }
};
</script>


<style scoped>
/* Your CSS for this component goes here */
h1 {
    color: blue;
}
</style>