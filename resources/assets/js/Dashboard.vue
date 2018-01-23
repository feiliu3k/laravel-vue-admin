<template>
    <div class="app-wrapper" :class="{hideSidebar:!sidebarOpened}">
        <div class="sidebar-wrapper">
            <sidebar class="sidebar-container"/>
        </div>
        <div class="main-container">
            <top-header></top-header>
            <div style="padding:1rem">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script lang="ts">

    import Vue from 'vue';
    import Component from 'vue-class-component'
    import TopHeader from './components/layout/Header.vue';
    import Sidebar from './components/layout/Sidebar.vue';
    import {mapGetters} from "vuex";
    // import Sidebar from './layout/Sidebar.vue';

    @Component({
        components: {
            TopHeader,
            Sidebar
        },
        computed: mapGetters(['sidebarOpened'])
    })
    export default class Dashboard extends Vue {

        public sidebarOpened: boolean;

    }

</script>
<style rel="stylesheet/scss" lang="scss" scoped>

    .app-wrapper {
        position: relative;
        height: 100%;
        width: 100%;
        &:after {
            content: "";
            display: table;
            clear: both;
        }
        &.hideSidebar {
            .sidebar-wrapper {
                transform: translate(-140px, 0);
                .sidebar-container {
                    transform: translate(132px, 0);
                }
                &:hover {
                    transform: translate(0, 0);
                    .sidebar-container {
                        transform: translate(0, 0);
                    }
                }
            }
            .main-container {
                margin-left: 40px;
            }
        }
        .sidebar-wrapper {
            width: 180px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1001;
            overflow-x: hidden;
            transition: all .28s ease-out;
            &::-webkit-scrollbar-track-piece {
                background: #d3dce6;
            }
            &::-webkit-scrollbar {
                width: 6px;
            }
            &::-webkit-scrollbar-thumb {
                background: #99a9bf;
                border-radius: 20px;
            }
        }
        .sidebar-container {
            transition: all .28s ease-out;
        }
        .main-container {
            min-height: 100%;
            transition: all .28s ease-out;
            margin-left: 180px;
        }
    }
</style>
