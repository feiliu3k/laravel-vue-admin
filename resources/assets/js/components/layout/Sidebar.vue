<template>
    <el-menu mode="vertical" unique-opened :default-active="$route.path" :collapse="isCollapse">
        <sidebar-item :routes='permission_routers'></sidebar-item>
    </el-menu>
</template>

<script lang="ts">

    import Vue from 'vue';
    import Component from 'vue-class-component'
    import {mapGetters} from 'vuex';
    import SidebarItem from './SidebarItem.vue';


    @Component({
        computed: mapGetters([
            'permission_routers',
            'sidebarOpened'
        ]),
        components: {
            SidebarItem
        },
    })
    export default class Sidebar extends Vue {
        public sidebarOpened: boolean;
        public permission_routers:any[];

        get isCollapse(){
            return !this.sidebarOpened;
        }
    }
</script>
<style rel="stylesheet/scss" lang="scss" scoped>
    .el-menu {
        min-height: 100%;
    }
</style>
