<template>
    <div>
        <div>
            <el-button type="primary" @click="addBtn('editSystemConfigFrom')">增加分类</el-button>
        </div>
        <el-table :data="dataList">
            <el-table-column prop="id" label="编号" width="80"/>
            <el-table-column prop="name" label="模板名称"/>
            <el-table-column prop="alias" label="模板别名"/>
            <el-table-column prop="category_template" label="分类模板"/>
            <el-table-column prop="list_template" label="列表模板" />
            <el-table-column prop="show_template" label="显示模板" width="280"/>
            <el-table-column label="操作">
                <template slot-scope="scope">
                    <el-button size="small" @click="rowEditBtn(scope.row)">编辑</el-button>
                    <el-button size="small" type="danger" @click="rowDeleteBtn(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-dialog title="增加权限" :visible.sync="dialogFormVisible">
            <el-form ref="systemEditpatternFrom" label-suffix="：" label-position="right" :model="editItem" :rules="rules"
                     label-width="120px">
                <el-form-item prop="name" label="模板名称">
                    <el-col :span="15">
                        <el-input type="text" v-model="editItem.name"></el-input>
                    </el-col>
                </el-form-item>
                <el-form-item prop="category_templat" label="分类模板">
                    <el-col :span="15">
                        <el-input type="text" v-model="editItem.category_template"></el-input>
                    </el-col>
                </el-form-item>
                <el-form-item prop="list_template" label="列表模板">
                    <el-col :span="15">
                        <el-input type="text" v-model="editItem.list_template"></el-input>
                    </el-col>
                </el-form-item>
                <el-form-item prop="show_template" label="显示模板">
                    <el-input type="text" v-model="editItem.show_template"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="saveBtn('systemEditpatternFrom')">确 定</el-button>
            </div>
        </el-dialog>
    </div>
</template>
<script lang="ts">

    import Vue from 'vue';
    import Component from 'vue-class-component'
    import * as _ from 'lodash';
    import {pattern_list, pattern_save, pattern_remove} from '../../../services/index';
    import remoteValidatorMixin from '../../../components/RemoteValidatorMixin';
    import rowEditFormMixin from '../../../components/RowEditFormMixin';

    @Component({
        mixins: [rowEditFormMixin, remoteValidatorMixin],
    })
    export default class PatternPage extends Vue {
        public dataItem: string = "editItem"
        public list: any = {} as any;

        public editItem: any[string] = {
            name: '',
            id: 0,
            category_template: '',
            list_template: '',
            show_template:""

        };
        public dialogFormVisible: boolean = false;

        get dataList(): any[number]{
            if (this.list && this.list['data']) {
                return this.list['data'];
            } else {
                return [];
            }
        }

        public mounted() {
            let self = this;
            this.$nextTick(function () {
                this.$on('update', async function () {
                    if (self.dataList && self.dataList.length > 0) {
                        return;
                    }
                    let {success, data} = await pattern_list();
                    if (success) {
                        self.list = data;
                    }
                });
                setTimeout(() => {
                    this.$emit('update');
                }, 50);
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
            self.remoteValidate(self, formName, pattern_save).then(function (data:any) {
                if (data) {
                    self.updateDataItem(self.list.data, data, 'id');
                    self.dialogFormVisible = false;
                }
            }, function () {
                console.log('error');
            });
        }

        public async rowDeleteBtn(idx:number, rowData:any) {
            this.rowRemove(pattern_remove, rowData.id, this.dataList, idx, '分类');
        }
    }

</script>
