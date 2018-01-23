<template>
    <div class="login-container">
        <el-form ref="loginFrom" label-position="right" label-width="80px" class="login-container__form" lg="6"
                 :model="user" :rules="rules">
            <h3 class="login-container__header">系统登录</h3>
            <el-form-item prop="email" label="电子邮件">
                <el-input type="text" placeholder="电子邮件" v-model="user.email"></el-input>
            </el-form-item>
            <el-form-item prop="password" label="密码">
                <el-input type="password" placeholder="密码" v-model="user.password"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" style="width:40%;float:left"
                           @click.native.prevent="loginSubmitBtn('loginFrom')">
                    登录
                </el-button>
                <el-button type="info" style="width:40%;margin-left:5%" @click.native.prevent="registerBtn">
                    注册
                </el-button>
            </el-form-item>
        </el-form>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import Component from 'vue-class-component'
    import {mapGetters, mapActions, mapMutations} from "vuex";
    import {SysAction, SysMutation} from '../../store/modules/sys'
    import RemoteValidatorMixin from '../../components/RemoteValidatorMixin'
    import {loginPost} from "../../services/index";
    import {TokenInfo, User} from "../../models";


    @Component({
        // computed: mapGetters(['user', 'token']),
        methods:mapMutations([
                SysMutation.SAVE_TOKEN as string,
                SysMutation.SAVE_USER as string
            ]),
        mixins: [RemoteValidatorMixin]

    })
    export default class Login extends Vue {

        public user: User = {
            email: 'jing.min@163.com',
            password: '123456',
            remember: true
        } as User;

        public created(){
            this.dataItem ='user';
        }
        public SAVE_USER: (user: User|undefined) => void;
        public SAVE_TOKEN: (token: TokenInfo) => void;

        public loginSubmitBtn(formName: string) {
            let self:Login = this;
            this.remoteValidate(self, formName, loginPost).then(function (data: any) {
                if (data) {
                    let token: TokenInfo = {token: data.token, remember: self.user.remember};
                    self.SAVE_USER(data.user as User);
                    self.SAVE_TOKEN(token);
                    self.$router.push('/');
                }
            }, function (data: any) {

            });
        }

        public registerBtn() {
            this.$router.push('/register');
        }

    }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
    $box-header-bg: #bf5329;
    $box-header-text: #fff;
    $prefix-name: login;
    $form-backgroud-color: #eee;
    $form-header-backgroud-color: $box-header-bg;
    $form-header-text-color: $box-header-text;

    .#{$prefix-name}-container {
        height: 100%;
        position: relative;
        width: 100%;

        &__form {
            background-color: $form-backgroud-color;
            left: 50%;
            padding: .5rem;
            position: absolute;
            top: 50%;
            transform: translate(-50%, -80%);
            width: 400px;
        }

        &__header {
            background-color: $form-header-backgroud-color;
            color: $form-header-text-color;
            font-weight: normal;
            letter-spacing: .25rem;
            line-height: 2.5rem;
            margin: -.5rem -.5rem .5rem;
            padding: 0;
            text-align: center;
        }
    }


</style>
