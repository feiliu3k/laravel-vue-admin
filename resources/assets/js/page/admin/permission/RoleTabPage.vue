<template>
    <div>
        <div>
            <el-button type="primary" @click="addBtn('editSystemConfigFrom')">增加权限</el-button>
        </div>
        <el-table :data="dataList">
            <el-table-column prop="id" label="编号" width="80"/>
            <el-table-column prop="name" label="用户名" width="380"/>
            <el-table-column prop="email" label="电子邮件" width="280"/>
            <el-table-column label="操作">
                <template slot-scope="scope">
                    <el-button size="small" @click="rowEditBtn(scope.row)">编辑</el-button>
                    <el-button size="small" type="danger" @click="rowDeleteBtn(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-dialog title="增加权限" :visible.sync="dialogFormVisible">
            <el-form ref="systemEditroleFrom" label-suffix="：" label-position="right" :model="editItem" :rules="rules"
                     label-width="120px">
                <el-form-item prop="name" label="角色名">
                    <el-col :span="15">
                        <el-input type="text" v-model="editItem.name"></el-input>
                    </el-col>
                </el-form-item>
                <el-form-item prop="display_name" label="显示名">
                    <el-col :span="15">
                        <el-input type="text" v-model="editItem.display_name"></el-input>
                    </el-col>
                </el-form-item>
                <el-form-item prop="description" label="说明">
                    <el-input type="text" v-model="editItem.description"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="saveBtn('systemEditroleFrom')">确 定</el-button>
            </div>
        </el-dialog>
    </div>
</template>
<script lang="ts">

    import Vue from 'vue';
    import Component from 'vue-class-component'
    import * as _ from 'lodash';
    import {role_list, role_save, role_remove} from '../../../services/index';
    import remoteValidatorMixin from '../../../components/RemoteValidatorMixin';
    import rowEditFormMixin from '../../../components/RowEditFormMixin';

    @Component({
        mixins: [rowEditFormMixin, remoteValidatorMixin],
    })
    export default class roleTabPage extends Vue {
        public dataItem: string = "editItem"
        public list: any = {} as any;

        public editItem: any[string] = {
            name: '',
            id: 0,
            password: '',
            repassword: ''
        };
        public dialogFormVisible: boolean = false;

        get dataList(): any[number]|undefined{
            if (this.list && this.list['data']) {
                return this.list['data'];
            } else {
                return undefined;
            }
        }

        public mounted() {
            let self = this;
            this.$nextTick(function () {
                this.$on('update', async function () {
                    if (self.dataList && self.dataList.length > 0) {
                        return;
                    }
                    let {success, data} = await role_list();
                    if (success) {
                        self.list = data;
                    }
                });
            });

        }

        public rowEditBtn(data: any) {
            this.editItem = _.clone(data);
            this.dialogFormVisible = true;
        }

        public addBtn() {
            this.editItem = {name: '', id: 0, display_name: '', description: ''} as any[string];
            this.dialogFormVisible = true;
        }

        public async saveBtn(formName:string) {
            let self = this;
            self.remoteValidate(self, formName, role_save).then(function (data:any) {
                if (data) {
                    self.updateDataItem(self.list.data, data, 'id');
                    self.dialogFormVisible = false;
                }
            }, function () {
                console.log('error');
            });
        }

        public async rowDeleteBtn(idx:number, rowData:any) {
            this.rowRemove(role_remove, rowData.id, this.dataList, idx, '权限');
        }
    }

</script>
