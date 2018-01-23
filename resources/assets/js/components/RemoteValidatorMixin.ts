import Component from 'vue-class-component'
import Vue from "vue";

declare module 'vue/types/vue' {
// 3. 声明为 Vue 补充的东西
    interface Vue {
        error: { [key: string]: any };
        rules: { [key: string]: any };
        dataItem: string | undefined ;

        remoteValidatorInfo(rule: any, value: any, callback: any): any;

        remoteValidate(self: any, formName: string, postFnt: any): any;
    }
}

@Component
export default class RemoteValidatorMixin extends Vue {

    public error: { [key: string]: any } = {};
    public rules: { [key: string]: any } = {};
    public dataItem: string | undefined;

    public mounted() {

        if (this.fromData) {

            for (let itemKey in  this.fromData) {
                if (!this.rules[itemKey]) {
                    this.rules[itemKey] = [];
                }
                this.rules[itemKey].push({
                    validator: this.remoteValidatorInfo,
                    trigger: 'blur'
                });
            }
        }
    }

    get fromData(): { [key: string]: any } | undefined {
        if (this.dataItem) {
            return (this as any)[this.dataItem];
        }
        return undefined;
    }

    public remoteValidatorInfo(rule: any, value: any, callback: any) {
        if (this.error && this.error[rule.field]) {
            let message = this.error[rule.field];
            if (message) {
                this.error[rule.field] = undefined;
                return callback(new Error(message));
            }
        }
        return callback();
    }

    public remoteValidate(self: any, formName: string, postFnt: any) {
        return new Promise(function (resolve, reject) {
            self.$refs[formName].validate(async function (valid: boolean) {
                let remoteData;
                if (valid) {
                    remoteData = await postFnt(self[self.dataItem]);
                    if (!remoteData['success']) {
                        self.error = remoteData['error'];
                        self.$refs[formName].validate((valid: boolean) => {
                        });
                        reject(new Error('request error'));
                    } else {
                        resolve(remoteData['data']);
                    }
                } else {
                    reject(new Error('request error'));
                }
            });
        });
    }
}