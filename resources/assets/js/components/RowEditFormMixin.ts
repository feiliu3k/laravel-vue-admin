import Component from 'vue-class-component'
import Vue from "vue";
import * as _ from 'lodash';

declare module 'vue/types/vue' {
// 3. 声明为 Vue 补充的东西
    interface Vue {

        rowRemove (Remotefnt: (id: number) => Promise<any>, dataKey: number, dataList: any[], listKey: number, dataName: string): any;

        updateDataItem(self: any, formName: string, postFnt: any): any;
    }
}

@Component
export default class RowEditFormMixin extends Vue {

    public rowRemove(Remotefnt: (id: number) => Promise<any>, dataKey: number, dataList: any[number], listKey: number, dataName: string) {
        let self: Vue = this;
        if (!dataName) {
            dataName = '数据';
        }
        this.$confirm('此操作将永久删除' + dataName + ', 是否继续?', '提示', {
            confirmButtonText: '确定',
            cancelButtonText: '取消',
            type: 'warning'
        }).then(async function () {
            let data: any = await Remotefnt(dataKey);
            if (data.success) {
                dataList.splice(listKey, 1);
                self.$message({
                    showClose: true,
                    message: '删除' + dataName + '成功'
                });
            } else {
                self.$message({
                    showClose: true,
                    message: '删除' + dataName + '失败'
                });
            }
        }).catch(() => {
            this.$message({
                type: 'info',
                message: '已取消删除'
            });
        });
    }

    /**
     * 用户更新数据列表，若通过key能找到，更新，不能找到，追加
     * @param listData
     * @param newData
     * @param keyName
     */
    updateDataItem(listData: any, newData: any, keyName: string) {
        let findData: any = {};
        findData[keyName] = newData[keyName];
        let idx: string | undefined = _.findKey(listData, findData);
        if (idx) {
            _.assign(listData[idx], newData);
        } else {
            listData.push(newData);
        }
    }

}