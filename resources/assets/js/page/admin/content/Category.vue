<template>
    <div>
        <div>
            <el-button type="primary" @click="addBtn('editSystemConfigFrom')">增加分类</el-button>
        </div>
        <el-table :data="dataList">
            <el-table-column prop="id" label="编号" width="80"/>
            <el-table-column prop="name" label="分类名称" width="380"/>
            <el-table-column prop="alias" label="分类别名" width="280"/>
            <el-table-column prop="pattern.name" label="模型名称" width="280"/>
            <el-table-column label="操作">
                <template slot-scope="scope">
                    <el-button size="small" @click="rowEditBtn(scope.row)">编辑</el-button>
                    <el-button size="small" type="danger" @click="rowDeleteBtn(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-dialog title="增加权限" :visible.sync="dialogFormVisible">
            <el-form ref="systemEditCategoryFrom" label-suffix="：" label-position="right" :model="editItem"
                     :rules="rules"
                     label-width="120px">
                <el-form-item prop="name" label="分类名">
                    <el-col :span="15">
                        <el-input type="text" v-model="editItem.name"></el-input>
                    </el-col>
                </el-form-item>
                <el-form-item prop="alias" label="分类别名">
                    <el-col :span="15">
                        <el-input type="text" v-model="editItem.alias"></el-input>
                    </el-col>
                </el-form-item>
                <el-form-item prop="pattern_id" label="模型">
                    <el-select v-model="editItem.pattern_id" placeholder="请选择">
                        <el-option
                                v-for="item in patterns"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="saveBtn('systemEditCategoryFrom')">确 定</el-button>
            </div>
        </el-dialog>
    </div>
</template>
<script lang="ts">

    import Vue from 'vue';
    import Component from 'vue-class-component'
    import * as _ from 'lodash';
    import {category_list, category_save, category_remove, pattern_all} from '../../../services/index';
    import remoteValidatorMixin from '../../../components/RemoteValidatorMixin';
    import rowEditFormMixin from '../../../components/RowEditFormMixin';

    @Component({
        mixins: [rowEditFormMixin, remoteValidatorMixin],
    })
    export default class Category extends Vue {
        public dataItem: string = "editItem";
        public list: any = {} as any;
        public patterns: any[] = {} as any;

        public editItem: any[string] = {
            name: '',
            id: 0,
            alias: '',
            pattern_id: 0
        };
        public dialogFormVisible: boolean = false;

        get dataList(): any[number] {
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
                    let categories = await category_list();
                    let patterns = await pattern_all();
                    if (categories.success && patterns.success) {
                        self.list = categories.data;
                        self.patterns = patterns.data;
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
            this.editItem = {name: '', id: 0, alias: '', pattern_id: ''} as any[string];
            this.dialogFormVisible = true;
        }

        public async saveBtn(formName: string) {
            let self = this;
            self.remoteValidate(self, formName, category_save).then(function (data: any) {
                if (data) {
                    self.updateDataItem(self.list.data, data, 'id');
                    self.dialogFormVisible = false;
                }
            }, function () {
                console.log('error');
            });
        }

        public async rowDeleteBtn(idx: number, rowData: any) {
            this.rowRemove(category_remove, rowData.id, this.dataList, idx, '分类');
        }
    }

</script>
