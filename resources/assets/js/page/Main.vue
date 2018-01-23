<template>
    <div id="app">
        <Loading ref="loadingBar"></Loading>
        <router-view></router-view>
    </div>
</template>
<script  lang="ts">
    import Loading from '../components/Loading.vue';
    import Vue from 'vue';
    import Component from 'vue-class-component'

    @Component({
        components: {
            Loading: Loading
        },
    })
    export default class Main extends Vue {

        public mounted() {
            this.$loadingBar = this.$refs.loadingBar as Loading ;
        }

        public created() {
            this.$root.$loading = this.$loading;
        }
    }
</script>
