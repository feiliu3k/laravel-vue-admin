<template>
    <el-breadcrumb class="app-levelBar" separator="/">
        <el-breadcrumb-item v-for="(item, index)  in levelList" :key="item.name">
            <router-link v-if='index==levelList.length-1' to="" class="no-redirect">{{item.name}}</router-link>
            <router-link v-else :to="item.path">{{item.name}}</router-link>
        </el-breadcrumb-item>
    </el-breadcrumb>
</template>

<script lang="ts">

    import Vue from 'vue';
    import Component from 'vue-class-component'


    @Component({
        watch: {
            $route(to, from) {
                (this as Breadcrumb).getBreadcrumb();
            }
        }
    })
    export default class Breadcrumb extends Vue {
        public levelList: any[]=[];

        created() {
            this.getBreadcrumb();
        }

        public getBreadcrumb() :void{
            let matched: any[] = this.$route.matched.filter(item => item.name);
            const first: any = matched[0];
            if (first && (first.name !== '首页' || first.path !== '')) {
                matched = [{name: '首页', path: '/'}].concat(matched);
            }
            this.levelList = matched;
        }
    }
</script>
<style rel="stylesheet/scss" lang="scss" scoped>
    .app-levelBar.el-breadcrumb {
        display: inline-block;
        font-size: 14px;
        line-height: 50px;
        margin-left: 10px;
        .no-redirect {
            color: #97a8be;
            cursor: text;
        }
    }
</style>
