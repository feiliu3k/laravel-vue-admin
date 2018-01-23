<template>
    <div class='menu-wrapper'>
        <template v-for="item in routes">
            <el-menu-item v-if="!item.hidden&&item.noDropdown&&item.children.length>0"
                          :index="item.path+'/'+item.children[0].path" class='submenu-title-noDropdown'>
                <router-link :to="item.path+'/'+item.children[0].path">
                    <wscn-icon-svg v-if='item.icon' :icon-class="item.icon"></wscn-icon-svg>
                    <span>{{item.children[0].name}}</span>
                </router-link>
            </el-menu-item>

            <el-submenu :index="item.name" v-if="!item.noDropdown && !item.hidden">
                <template slot="title">
                    <wscn-icon-svg v-if='item.icon' :icon-class="item.icon"></wscn-icon-svg>
                    <span>{{item.name}}</span>
                </template>
                <template v-for="child in item.children" v-if='!child.hidden'>

                    <el-menu-item :index="item.path+'/'+child.path">
                        <router-link :to="item.path+'/'+child.path">
                            <wscn-icon-svg v-if='child.icon' :icon-class="child.icon"></wscn-icon-svg>
                            <span>{{child.name}}</span>
                        </router-link>
                    </el-menu-item>
                </template>
            </el-submenu>
        </template>
    </div>
</template>

<script lang="ts">

    import Vue from 'vue';
    import Component from 'vue-class-component'
    import {mapGetters} from 'vuex';
    // .import SidebarItem from './SidebarItem';


    @Component({
        props: {
            routes: {
                type: Array,
                default: false
            }
        }
    })
    export default class SidebarItem extends Vue {
        public routes: any[];
    }
</script>


<style rel="stylesheet/scss" lang="scss">
    .wscn-icon {
        margin-right: 16px;
        width: 1em;
        height: 1em;
        vertical-align: -.15em;
        fill: currentColor;
        overflow: hidden;
    }

    .hideSidebar .menu-indent {
        display: block;
        text-indent: 16px;
    }

</style>