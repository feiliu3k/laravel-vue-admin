<template>
    <el-menu class="navbar" mode="horizontal" v-if="user">
        <hamburger class="hamburger-container" :toggleClick="toggleSideBar" :isActive="!sidebarOpened"></hamburger>
        <Breadcrumb></Breadcrumb>
        <el-dropdown class="avatar-container" trigger="click">
            <div class="avatar-wrapper">
                <span>个人空间</span>
                <i class="el-icon-caret-bottom"/>
            </div>
            <el-dropdown-menu class="user-dropdown" slot="dropdown">
                <el-dropdown-item divided>
                    <span @click="logoutBtn()" style="display:block;">退出登录</span>
                </el-dropdown-item>
            </el-dropdown-menu>
        </el-dropdown>
    </el-menu>
</template>
<script lang="ts">

    import Vue from 'vue';
    import Component from 'vue-class-component'
    import {mapGetters, mapActions, mapMutations} from 'vuex';
    import Hamburger from './Hamburger.vue';
    import Breadcrumb from './Breadcrumb.vue';
    import {User} from "../../models";
    import {SysAction, SysMutation} from "../../store/modules/sys";


    @Component({
        components: {
            Hamburger,
            Breadcrumb
        },
        methods: {
            ...mapActions([SysAction.LOGOUT as string]),
            ...mapMutations([SysMutation.TOGGLE_SIDEBAR_OPENED as string]),
        },
        computed: {
            ...mapGetters(['sidebarOpened', 'user'])
        }
    })
    export default class Header extends Vue {
        public user: User;
        public userInfo: User|undefined = undefined;
        public LOGOUT: () => void;
        public sidebarOpened: boolean;
        public TOGGLE_SIDEBAR_OPENED: () => void;

        public mounted() {
            this.userInfo = this.user;
        }

        public async logoutBtn() {
            await this.LOGOUT();
            this.$router.push('/Login');
        }

        public  toggleSideBar() {
            this.TOGGLE_SIDEBAR_OPENED();
        }

    }

</script>
<style lang="scss">
    .navbar {
        height: 50px;
        line-height: 50px;
        border-radius: 0 !important;
        .hamburger-container {
            line-height: 58px;
            height: 50px;
            float: left;
            padding: 0 10px;
        }
        .avatar-container {
            height: 50px;
            display: inline-block;
            position: absolute;
            right: 35px;

        }
    }


</style>
