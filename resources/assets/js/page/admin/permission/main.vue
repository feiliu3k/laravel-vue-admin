<template>
    <el-tabs type="border-card" v-model="activeTabName">
        <el-tab-pane label="用户管理" name="user">
            <User ref="userPane"></User>
        </el-tab-pane>
        <el-tab-pane label="角色管理" name="role">
            <Role ref="rolePane"></Role>
        </el-tab-pane>
        <el-tab-pane label="权限管理" name="permission">
            <Permission ref="permissionPane"></Permission>
        </el-tab-pane>
    </el-tabs>
</template>
<script  lang="ts">

    import Vue from 'vue';
    import Component from 'vue-class-component'
    import Permission from './PermissionTabPage.vue';
    import Role from './RoleTabPage.vue';
    import User from './UserTabPage.vue';

    @Component({
        components: {
            User: User,
            Role: Role,
            Permission: Permission
        },
        watch: {
            activeTabName: function (newValue) {
                (this as PermissionMain).switchPane(newValue + 'Pane');
            }
        }
    })
    export default class PermissionMain extends Vue {
        public activeTabName:string ="";

        public mounted () {
            this.activeTabName = 'user';
        }
        public switchPane (name:any) {
            setTimeout(() => {
                (this.$refs[name] as Vue).$emit('update');
            }, 50);
        }

    }
</script>
